<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CounterController extends Controller
{
    public function getCount()
    {
        // Supabase REST API call to count users
        $url = env('SUPABASE_URL') . '/rest/v1/users?select=id';
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get($url);
        $count = is_array($response->json()) ? count($response->json()) : 0;
        return response()->json(['count' => $count]);
    }
}
