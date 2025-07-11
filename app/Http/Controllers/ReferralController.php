<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReferralController extends Controller
{
    public function leaderboard()
    {
        // Get top 3 referrers from Supabase
        $url = env('SUPABASE_URL') . '/rest/v1/users?select=referral_code,first_name,surname,(
            select=count(*) from users as u2 where u2.referred_by=users.referral_code
        ) as referral_count&order=referral_count.desc.nullslast&limit=3';
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $topReferrers = $response->json();
        return view('referrals', ['topReferrers' => $topReferrers]);
    }

    public function history()
    {
        $email = session('user_email');
        $userUrl = env('SUPABASE_URL') . "/rest/v1/users?email=eq." . $email;
        $userResponse = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($userUrl);
        $user = $userResponse->json()[0] ?? null;
        $referralCode = $user['referral_code'] ?? null;
        $refUrl = env('SUPABASE_URL') . "/rest/v1/users?referred_by=eq." . $referralCode;
        $refResponse = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($refUrl);
        $referrals = $refResponse->json();
        return view('referral-history', ['referrals' => $referrals]);
    }
}
