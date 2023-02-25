<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createPaymentIntent()
    {
        $stripe = new \Stripe\StripeClient('sk_test_51Meg81Loe7VzYnJpfATP4ynIRnPLm2KyHO6pG8j6khveKw9PC31cNgtwioMWm90HxCTR2Vp1kgNlsGjazYF25SV800WCPxWrQw');
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => 2000,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);
        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }
}
