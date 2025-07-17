<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Process admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Simple hardcoded login for admin
        if ($request->email === 'info@arkbridge360.com.ng' && $request->password === 'Psa@3080') {
            Session::put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    /**
     * Admin logout
     */
    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    /**
     * Check if admin is authenticated
     */
    private function checkAdminAuth()
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login to access the admin panel');
        }
        return true;
    }

    public function dashboard(Request $request)
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        // Use local database instead of Supabase
        $users = DB::table('users')->get()->toArray();

        $totalUsers = count($users);
        $paidUsers = count(array_filter($users, function($u){ return ($u->payment_status ?? '') === 'paid'; }));
        $totalReferrals = array_sum(array_map(function($u){ return $u->referral_count ?? 0; }, $users));
        $conversionRate = $totalUsers ? round(($paidUsers/$totalUsers)*100, 2) : 0;

        // Registration trends by day
        $trend = [];
        foreach ($users as $u) {
            $date = isset($u->created_at) ? substr($u->created_at,0,10) : null;
            if ($date) $trend[$date] = ($trend[$date] ?? 0) + 1;
        }
        ksort($trend);

        // Top 5 referrers
        $topReferrers = collect($users)->sortByDesc('referral_count')->take(5)->values()->all();
        if ($request->ajax()) {
            return response()->json([
                'totalUsers' => $totalUsers,
                'paidUsers' => $paidUsers,
                'totalReferrals' => $totalReferrals,
                'conversionRate' => $conversionRate,
            ]);
        }
        return view('admin.dashboard', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'paidUsers' => $paidUsers,
            'totalReferrals' => $totalReferrals,
            'conversionRate' => $conversionRate,
            'trend' => $trend,
            'topReferrers' => $topReferrers,
        ]);
    }

    public function updateUser(Request $request)
    {
        $id = $request->input('id');
        $data = $request->except('id');
        $url = env('SUPABASE_URL') . "/rest/v1/users?id=eq." . $id;
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/json',
        ])->patch($url, $data);
        return redirect()->route('admin.dashboard')->with('status', 'User updated!');
    }

    public function exportUsers(Request $request)
    {
        // Export all users as CSV
        $url = env('SUPABASE_URL') . '/rest/v1/users?select=*';
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $users = $response->json();
        $csv = "Name,Email,Type,Referral Code,Payment Status\n";
        foreach ($users as $user) {
            $csv .= ($user['first_name'] ?? $user['full_name']) . ',' . ($user['email'] ?? '') . ',' . ($user['type'] ?? '') . ',' . ($user['referral_code'] ?? '') . ',' . ($user['payment_status'] ?? '') . "\n";
        }
        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ]);
    }

    public function auditLog()
    {
        // Fetch audit logs from Supabase (assuming audit_logs table exists)
        $url = env('SUPABASE_URL') . '/rest/v1/audit_logs?select=*';
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $logs = $response->json();
        return view('admin.audit', ['logs' => $logs]);
    }

    public function impersonateUser(Request $request)
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        // Admin tool: Impersonate another user
        $id = $request->input('id');
        $url = env('SUPABASE_URL') . "/rest/v1/users?id=eq." . $id;
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $user = $response->json()[0] ?? null;
        if ($user) {
            session(['user_email' => $user['email']]);
            return redirect()->route('dashboard', ['referral_code' => $user['referral_code']]);
        }
        return back()->withErrors(['impersonate' => 'User not found.']);
    }

    /**
     * List all manual payments
     */
    public function manualPayments()
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        $payments = DB::table('manual_payments')
            ->join('users', 'manual_payments.user_id', '=', 'users.id')
            ->select(
                'manual_payments.*', 
                'users.surname', 
                'users.first_name', 
                'users.full_name', 
                'users.type', 
                'users.email', 
                'users.whatsapp_number'
            )
            ->orderBy('manual_payments.created_at', 'desc')
            ->get();

        return view('admin.manual-payments', compact('payments'));
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'status' => 'required|in:pending,verified,rejected',
        ]);

        DB::table('manual_payments')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        // If payment is verified, update user status in Supabase
        if ($request->status === 'verified') {
            $userId = DB::table('manual_payments')->where('id', $id)->value('user_id');

            if ($userId) {
                $url = env('SUPABASE_URL') . "/rest/v1/users?id=eq." . $userId;

                Http::withHeaders([
                    'apikey' => env('SUPABASE_API_KEY'),
                    'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                    'Content-Type' => 'application/json',
                ])->patch($url, [
                    'payment_status' => 'verified',
                    'updated_at' => now()->toIso8601String(),
                ]);
            }
        }

        return back()->with('success', 'Payment status updated successfully');
    }

    public function sendNotification(Request $request)
    {
        // Send notification to user (email)
        $email = $request->input('email');
        $message = $request->input('message');
        \Illuminate\Support\Facades\Mail::raw($message, function ($m) use ($email) {
            $m->to($email)->subject('ArkBridge360 Notification');
        });
        return back()->with('status', 'Notification sent!');
    }

    public function sendPushNotification(Request $request)
    {
        // Example: send push notification via OneSignal (or similar)
        $message = $request->input('message');
        $onesignalUrl = 'https://onesignal.com/api/v1/notifications';
        $fields = [
            'app_id' => env('ONESIGNAL_APP_ID'),
            'included_segments' => ['All'],
            'contents' => ['en' => $message],
        ];
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Basic ' . env('ONESIGNAL_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post($onesignalUrl, $fields);
        return back()->with('status', 'Push notification sent!');
    }

    public function customReport(Request $request)
    {
        // Example: filter users by payment status and export
        $status = $request->input('status', 'paid');
        $url = env('SUPABASE_URL') . "/rest/v1/users?payment_status=eq." . $status;
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $users = $response->json();
        $csv = "Name,Email,Type,Referral Code,Payment Status\n";
        foreach ($users as $user) {
            $csv .= ($user['first_name'] ?? $user['full_name']) . ',' . ($user['email'] ?? '') . ',' . ($user['type'] ?? '') . ',' . ($user['referral_code'] ?? '') . ',' . ($user['payment_status'] ?? '') . "\n";
        }
        return \Illuminate\Support\Facades\Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="custom_report.csv"',
        ]);
    }

    public function integrationStats(Request $request)
    {
        // Example: fetch stats from external APIs (Google Analytics, OPay, etc.)
        $googleStats = [];
        $opayStats = [];
        // ...fetch and process external API data here...
        return view('admin.integrations', [
            'googleStats' => $googleStats,
            'opayStats' => $opayStats,
        ]);
    }
}
