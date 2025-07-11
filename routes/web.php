<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/register', function() { return view('auth.register'); })->name('register');
Route::get('/login', function() { return view('auth.login'); })->name('login');
Route::get('/faq', function() { return view('faq'); })->name('faq');
