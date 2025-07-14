<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Exception;

class OpayPaymentController extends Controller
{
    public function showPaymentPage()
    {
        // Check if registration data exists in session
        if (!Session::has('registration_data')) {
            return redirect()->route('register')->with('error', 'Please complete the registration form first.');
        }

        return view('pay');
    }

    public function initiatePayment(Request $request)
    {
        try {
            // Generate a unique reference
            $reference = uniqid('opay_', true);
            $amount = 30000; // kobo (₦300)
            $currency = 'NGN';
            $payType = 'bank_card';
            $callbackUrl = route('opay.callback');
            $returnUrl = route('home');

            // Get user data from session if available
            $userData = Session::get('registration_data', []);

            $userInfo = [
                'name' => $userData['first_name'] ?? 'Oladeji Showunmi',
                'email' => $userData['email'] ?? 'oladeji@email.com',
                'phoneNumber' => $userData['whatsapp_number'] ?? '08012345678',
            ];

            $body = [
                'reference' => $reference,
                'amount' => $amount,
                'currency' => $currency,
                'payType' => $payType,
                'callbackUrl' => $callbackUrl,
                'returnUrl' => $returnUrl,
                'userInfo' => $userInfo,
            ];

            // Store transaction reference in session
            Session::put('transaction_reference', $reference);

            $timestamp = time();
            $payload = json_encode($body);
            $signature = hash_hmac('sha512', $payload . $timestamp, env('OPAY_SECRET_KEY'));

            // Log the request for debugging
            Log::info('OPay Payment Request', ['body' => $body]);

            $response = Http::withHeaders([
                'Authorization' => $signature,
                'MerchantId' => env('OPAY_MERCHANT_ID'),
                'Timestamp' => $timestamp,
                'Content-Type' => 'application/json',
            ])->post(env('OPAY_BASE_URL', 'https://api.opaycheckout.com') . '/api/v1/transaction/initialize', $body);

            // Log the response
            Log::info('OPay Payment Response', ['response' => $response->json()]);

            if ($response->ok() && isset($response['cashierUrl'])) {
                // Store pending payment record
                DB::table('payments')->insert([
                    'user_id' => null, // Will be updated after successful payment
                    'amount' => $amount / 100, // Convert from kobo to naira
                    'status' => 'pending',
                    'paystack_ref' => $reference, // Using same field for OPay reference
                    'created_at' => now(),
                ]);

                return Redirect::away($response['cashierUrl']);
            }

            // Handle API errors
            $errorMessage = $response['message'] ?? 'Payment initialization failed. Please try again.';
            Log::error('OPay Payment Error', ['error' => $errorMessage, 'response' => $response->json()]);

            return back()->with('error', $errorMessage);
        } catch (Exception $e) {
            Log::error('OPay Payment Exception', ['error' => $e->getMessage()]);
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function handleCallback(Request $request)
    {
        try {
            $data = $request->all();
            Log::info('OPay Callback Data', ['data' => $data]);

            if (isset($data['status']) && $data['status'] === 'SUCCESS') {
                // Get registration data from session
                $registrationData = Session::get('registration_data');

                if (!$registrationData) {
                    Log::error('Registration data not found in session');
                    return response()->json(['message' => 'Registration data not found'], 400);
                }

                // Create user record in Supabase via REST API or direct DB insertion
                // For now, we'll simulate this with a direct DB query
                $userId = DB::table('users')->insertGetId([
                    'type' => $registrationData['type'] ?? 'adult',
                    'surname' => $registrationData['surname'] ?? '',
                    'first_name' => $registrationData['first_name'] ?? '',
                    'other_name' => $registrationData['other_name'] ?? '',
                    'whatsapp_number' => $registrationData['whatsapp_number'] ?? '',
                    'alternate_number' => $registrationData['alternate_number'] ?? '',
                    'email' => $registrationData['email'] ?? '',
                    'home_address' => $registrationData['home_address'] ?? '',
                    'full_name' => $registrationData['full_name'] ?? '',
                    'guardian_name' => $registrationData['guardian_name'] ?? '',
                    'guardian_phone' => $registrationData['guardian_phone'] ?? '',
                    'guardian_alternate' => $registrationData['guardian_alternate'] ?? '',
                    'referral_code' => $registrationData['referral_code'] ?? '',
                    'referred_by' => Session::get('referred_by'),
                    'created_at' => now(),
                ]);

                // Update payment record
                DB::table('payments')
                    ->where('paystack_ref', $data['reference'])
                    ->update([
                        'user_id' => $userId,
                        'status' => 'paid',
                        'updated_at' => now(),
                    ]);

                // Process referral if applicable
                if (!empty($registrationData['referred_by'])) {
                    DB::table('referrals')->insert([
                        'user_id' => DB::table('users')->where('referral_code', $registrationData['referred_by'])->value('id'),
                        'referred_user_id' => $userId,
                        'created_at' => now(),
                    ]);
                }

                // Clear session data
                Session::forget(['registration_data', 'referred_by', 'transaction_reference']);

                // Redirect to success page for user feedback
                if ($request->wantsJson()) {
                    return response()->json(['message' => 'Payment successful', 'redirect' => route('success')], 200);
                } else {
                    return redirect()->route('success');
                }
            }

            // Handle payment failure
            Log::warning('Payment failed', ['data' => $data]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Payment failed: ' . ($data['message'] ?? 'Unknown reason')], 400);
            } else {
                return redirect()->route('payment.failed')->with('error', $data['message'] ?? 'Payment failed');
            }
        } catch (Exception $e) {
            Log::error('Payment callback exception', ['error' => $e->getMessage()]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'An error occurred processing your payment'], 500);
            } else {
                return redirect()->route('payment.failed')->with('error', 'An error occurred processing your payment');
            }
        }
    }
}

