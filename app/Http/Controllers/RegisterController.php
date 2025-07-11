<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showForm(Request $request)
    {
        return view('auth.register');
    }

    public function submitForm(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:adult,child',
            'surname' => 'nullable|string|max:100',
            'first_name' => 'nullable|string|max:100',
            'other_name' => 'nullable|string|max:100',
            'whatsapp_number' => 'nullable|string|max:20',
            'alternate_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'home_address' => 'nullable|string',
            'full_name' => 'nullable|string|max:150',
            'guardian_name' => 'nullable|string|max:150',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_alternate' => 'nullable|string|max:20',
            'referral_code' => 'nullable|string|max:20',
        ]);
        // Generate a unique referral code for new user
        $data['referral_code'] = $data['referral_code'] ?? strtoupper(substr(bin2hex(random_bytes(5)), 0, 8));
        // Track referral if referral_code is present
        if (!empty($data['referral_code'])) {
            session(['referred_by' => $data['referral_code']]);
        }
        // Save to session for payment
        session(['registration_data' => $data]);
        // Redirect to payment page
        return redirect()->route('paystack.pay');
    }
}
