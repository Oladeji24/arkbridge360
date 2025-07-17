<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;
use Exception;

class ManualPaymentController extends Controller
{
    public function showPaymentPage()
    {
        // Check if registration data exists in session
        if (!Session::has('registration_data')) {
            return redirect()->route('register')->with('error', 'Please complete the registration form first.');
        }

        $registrationData = Session::get('registration_data');
        $name = "";

        if ($registrationData['type'] === 'adult') {
            $name = $registrationData['surname'] . ' ' . $registrationData['first_name'];
        } else {
            $name = $registrationData['full_name'];
        }

        return view('manual-payment', compact('name'));
    }

    public function processPayment(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'payment_for' => 'required|string|in:self,other',
                'transaction_code' => 'required|string|max:100',
                'receipt' => 'required|file|mimes:jpeg,png,pdf|max:5120', // 5MB max
            ]);

            // Get registration data from session
            $registrationData = Session::get('registration_data');

            if (!$registrationData) {
                Log::error('Registration data not found in session');
                return redirect()->route('register')->with('error', 'Registration data not found. Please register again.');
            }

            // Store the uploaded receipt
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
            $receiptUrl = Storage::url($receiptPath);

            // Create user record in Supabase via REST API
            // For this implementation, we'll use a direct DB insertion for simplicity
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
                'payment_status' => 'pending_verification',
                'created_at' => now(),
            ]);

            // Record the manual payment
            DB::table('manual_payments')->insert([
                'user_id' => $userId,
                'amount' => 300,
                'payment_for' => $validatedData['payment_for'] === 'self' ? 'I am paying for myself' : 'I am paying for someone else',
                'transaction_code' => $validatedData['transaction_code'],
                'receipt_url' => $receiptUrl,
                'status' => 'pending',
                'created_at' => now(),
            ]);

            // Process referral if applicable
            if (!empty($registrationData['referred_by'])) {
                DB::table('referrals')->insert([
                    'user_id' => DB::table('users')->where('referral_code', $registrationData['referred_by'])->value('id'),
                    'referred_user_id' => $userId,
                    'created_at' => now(),
                ]);
            }

            // Send welcome email to the participant
            $name = "";
            if ($registrationData['type'] === 'adult') {
                $name = $registrationData['surname'] . ' ' . $registrationData['first_name'];
            } else {
                $name = $registrationData['full_name'];
            }

            $email = $registrationData['email'] ?? '';

            if (!empty($email)) {
                try {
                    Mail::to($email)->send(new PaymentConfirmation($name));
                    Log::info('Payment confirmation email sent', ['email' => $email, 'user_id' => $userId]);
                } catch (Exception $e) {
                    Log::error('Failed to send payment confirmation email', ['error' => $e->getMessage(), 'email' => $email]);
                    // Continue with the process even if email fails
                }
            }

            // Clear session data
            Session::forget(['registration_data', 'referred_by']);

            // Redirect to success page
            return redirect()->route('payment.success');

        } catch (Exception $e) {
            Log::error('Manual payment submission error', ['error' => $e->getMessage()]);
            return back()->with('error', 'An error occurred while submitting your payment: ' . $e->getMessage());
        }
    }
}
