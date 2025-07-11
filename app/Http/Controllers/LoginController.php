<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function submitForm(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Authenticate via Supabase REST API
        $url = env('SUPABASE_URL') . '/auth/v1/token?grant_type=password';
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post($url, [
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        if ($response->successful() && isset($response['access_token'])) {
            // Store token in session
            session(['supabase_token' => $response['access_token'], 'user_email' => $data['email']]);
            return redirect()->route('dashboard', ['referral_code' => $this->getReferralCode($data['email'])]);
        }
        return back()->withErrors(['login' => 'Invalid credentials or Supabase error.']);
    }

    private function getReferralCode($email)
    {
        $url = env('SUPABASE_URL') . "/rest/v1/users?email=eq." . $email;
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $user = $response->json()[0] ?? null;
        return $user['referral_code'] ?? null;
    }
}
