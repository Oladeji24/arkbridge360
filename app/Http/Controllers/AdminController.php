<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Advanced role management: Only allow admins and superadmins
        $email = session('user_email');
        $userUrl = env('SUPABASE_URL') . "/rest/v1/users?email=eq." . $email;
        $userResponse = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($userUrl);
        $user = $userResponse->json()[0] ?? null;
        if (!$user || !in_array($user['type'] ?? '', ['admin', 'superadmin'])) {
            return redirect()->route('login')->withErrors(['login' => 'Admin access only.']);
        }
        // Advanced analytics: registration trends, top referrers, payment conversion
        $url = env('SUPABASE_URL') . '/rest/v1/users?select=*';
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $users = $response->json();
        $totalUsers = count($users);
        $paidUsers = count(array_filter($users, function($u){ return ($u['payment_status'] ?? '') === 'paid'; }));
        $totalReferrals = array_sum(array_map(function($u){ return $u['referral_count'] ?? 0; }, $users));
        $conversionRate = $totalUsers ? round(($paidUsers/$totalUsers)*100, 2) : 0;
        // Registration trends by day
        $trend = [];
        foreach ($users as $u) {
            $date = isset($u['created_at']) ? substr($u['created_at'],0,10) : null;
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

    public function sendNotification(Request $request)
    {
        // Send notification to user (email)
        $email = $request->input('email');
        $message = $request->input('message');
        \Illuminate\Support\Facades\Mail::raw($message, function ($m) use ($email) {
            $m->to($email)->subject('ArtBridge360 Notification');
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
        // Example: fetch stats from external APIs (Google Analytics, Paystack, etc.)
        $googleStats = [];
        $paystackStats = [];
        // ...fetch and process external API data here...
        return view('admin.integrations', [
            'googleStats' => $googleStats,
            'paystackStats' => $paystackStats,
        ]);
    }
}
