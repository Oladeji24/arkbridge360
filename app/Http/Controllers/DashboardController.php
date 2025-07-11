<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $token = session('supabase_token');
        $referralCode = $request->query('referral_code');
        // Fetch user info from Supabase
        $url = env('SUPABASE_URL') . "/rest/v1/users?referral_code=eq." . $referralCode;
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $user = $response->json()[0] ?? null;
        // Fetch referral count
        $refCount = 0;
        if ($user && isset($user['referral_code'])) {
            $refUrl = env('SUPABASE_URL') . "/rest/v1/users?referred_by=eq." . $user['referral_code'];
            $refResponse = Http::withHeaders([
                'apikey' => env('SUPABASE_API_KEY'),
                'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            ])->get($refUrl);
            $refCount = is_array($refResponse->json()) ? count($refResponse->json()) : 0;
        }
        return view('dashboard', [
            'user' => $user,
            'referral_count' => $refCount,
        ]);
    }
}
