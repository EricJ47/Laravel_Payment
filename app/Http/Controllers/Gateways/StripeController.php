<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function payment(Request $request)
    {
        Stripe::setApiKey(config('stripe.sk'));

        $response = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name'=> 'Gimme my money',
                    ],
                    'unit_amount' => $request->price * 100, //converting cent to dollar, if the price was 40 it would be 4000cent = $40
                ],
                'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),

        ]);
        // return response()->json($response);
        return redirect()->away($response->url);
        
    }

    public function success(Request $request)
    {
        return '<h1>Payment Successfully</h1>';
        
    }
    public function cancel(Request $request)
    {
        return 'Payment Cancelled';

    }
}
