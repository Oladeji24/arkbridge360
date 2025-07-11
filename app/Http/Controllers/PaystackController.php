<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PaystackController extends Controller
{
    public function pay(Request $request)
    {
        $data = session('registration_data');
        if (!$data) return redirect()->route('register');
        // Prepare Paystack payment initialization
        $paystackUrl = 'https://api.paystack.co/transaction/initialize';
        $amount = 100000; // Example: 1000 NGN in kobo
        $email = $data['email'] ?? 'test@example.com';
        $fields = [
            'email' => $email,
            'amount' => $amount,
            'callback_url' => route('paystack.callback'),
        ];
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->post($paystackUrl, $fields);
        if ($response->successful() && isset($response['data']['authorization_url'])) {
            return redirect($response['data']['authorization_url']);
        }
        return back()->withErrors(['payment' => 'Unable to initiate payment.']);
    }

    public function callback(Request $request)
    {
        // Verify payment with Paystack
        $reference = $request->query('reference');
        $verifyUrl = 'https://api.paystack.co/transaction/verify/' . $reference;
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))->get($verifyUrl);
        if ($response->successful() && $response['data']['status'] === 'success') {
            $userData = session('registration_data');
            // Attach referral tracking if present
            if (session('referred_by')) {
                $userData['referred_by'] = session('referred_by');
            }
            $supabaseUrl = env('SUPABASE_URL') . '/rest/v1/users';
            $insertResponse = Http::withHeaders([
                'apikey' => env('SUPABASE_API_KEY'),
                'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation',
            ])->post($supabaseUrl, json_encode([$userData]));
            // Optionally send confirmation email here
            if (isset($userData['email'])) {
                Mail::raw('Thank you for registering with ArtBridge360!', function ($message) use ($userData) {
                    $message->to($userData['email'])
                            ->subject('ArtBridge360 Registration Confirmation');
                });
            }
            session()->forget(['registration_data', 'referred_by']);
            return view('success');
        }
        return view('failed');
    }
}
