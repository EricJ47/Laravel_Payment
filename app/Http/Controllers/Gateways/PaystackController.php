<?php

namespace App\Http\Controllers\gateways;

use App\Http\Controllers\Controller;
use Http;
use Illuminate\Http\Request;

class PaystackController extends Controller
{
    public function redirectToGateway(Request $request)
    {
        return view('gateways.paystack-redirect');

    }

    public function verifyTransaction(Request $request)
    {
        $reference = $request->reference;

        $secret_key = config('paystack.secret_key');

        $response = Http::withHeaders([
            'Authorization'=> 'bearer ' . $secret_key,
        ])->get('https://api.paystack.co/transaction/verify/'.$reference);

        $response_body = json_decode($response);

        // dd($response_body);
        if (isset($response_body->data->status) && $response_body->data->status == "success") {
            return 'Payment Success!';
        }else{
            return 'Payment can not completed';
        }
        
    }
}
