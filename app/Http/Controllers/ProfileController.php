<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $email = session('user_email');
        $url = env('SUPABASE_URL') . "/rest/v1/users?email=eq." . $email;
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $user = $response->json()[0] ?? null;
        return view('profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $email = session('user_email');
        $data = $request->only(['first_name','surname','other_name','whatsapp_number','alternate_number','home_address']);
        $url = env('SUPABASE_URL') . "/rest/v1/users?email=eq." . $email;
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/json',
        ])->patch($url, $data);
        return redirect()->route('profile')->with('status', 'Profile updated!');
    }
}
