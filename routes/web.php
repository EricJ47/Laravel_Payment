<?php

use App\Http\Controllers\Gateways\PaypalController;
use App\Http\Controllers\gateways\RazorPayController;
use App\Http\Controllers\Gateways\StripeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Paypal Payment
Route::post('paypal/payment', [PaypalController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/success', [PaypalController::class,'success'])->name('paypal.success');
Route::get('paypal/cancel', [PaypalController::class,'cancel'])->name('paypal.cancel');

// Stripe Payment
Route::post('stripe/payment', [StripeController::class,'payment'])->name('stripe.payment');
Route::get('stripe/success', [StripeController::class,'success'])->name('stripe.success');
Route::get('stripe/cancel', [StripeController::class,'cancel'])->name('stripe.cancel');


// razorpay payment

Route::post('razorpay/payment', [RazorPayController::class,'payment'])->name('razorpay.payment');
Route::get('razorpay/success', [RazorPayController::class,'success'])->name('razorpay.success');
Route::get('razorpay/cancel', [RazorPayController::class,'cancel'])->name('razorpay.cancel');