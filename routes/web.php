<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OpayPaymentController;

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
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'submitForm'])->name('register.submit');
Route::get('/login', function() { return view('auth.login'); })->name('login');
Route::get('/faq', function() { return view('faq'); })->name('faq');
Route::get('/why-join', function() { return view('why-join'); })->name('why-join');

// OPay Payment Routes
Route::get('/pay', [OpayPaymentController::class, 'showPaymentPage'])->name('opay.pay');
Route::post('/pay', [OpayPaymentController::class, 'initiatePayment'])->name('opay.init');
Route::post('/opay/callback', [OpayPaymentController::class, 'handleCallback'])->name('opay.callback');
Route::get('/payment/failed', function() { return view('payment_failed'); })->name('payment.failed');
Route::get('/success', function() { return view('success'); })->name('success');

