<?php

namespace App\Http\Controllers;

use App\Models\CourseRegistration;
use App\Models\OrderPayment;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class PaymentController extends Controller
{
    use GeneralTrait;
    public $client_secret;
    public function createPaymentIntent(Request $request)
    {
        // return $request->amount;
        $stripe = new \Stripe\StripeClient('sk_test_51Meg81Loe7VzYnJpfATP4ynIRnPLm2KyHO6pG8j6khveKw9PC31cNgtwioMWm90HxCTR2Vp1kgNlsGjazYF25SV800WCPxWrQw');
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $request->amount * 100,
            'currency' => 'USD',
            'payment_method_types' => ['card'],
        ]);
        $this->client_secret = $paymentIntent->client_secret;
        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }


    public function checkStripeReturn(Request $request)
    {
        $stripe = new \Stripe\StripeClient(
            'sk_test_51Meg81Loe7VzYnJpfATP4ynIRnPLm2KyHO6pG8j6khveKw9PC31cNgtwioMWm90HxCTR2Vp1kgNlsGjazYF25SV800WCPxWrQw'
        );
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->payment_intent,
            []
        );
        if ($paymentIntent->status == 'succeeded') {
            $summary = [];
            foreach($request->orderItems as $course) {
                CourseRegistration::create([
                    'user_id' => $request->user_id,
                    'course_id' => $course['id']
                ]);

                array_push($summary, ['id' => $course['id'], 'name' => $course['name']]);
            }
            OrderPayment::create([
                'user_id' => $request->user_id,
                'totalPrice' => $request->totalPrice,
                'basicPrice' => $request->basicPrice,
                'discount' => $request->discount,
                'summary' => json_encode($summary),
            ]);

            return $this->returnSuccessMessage('confirm succss');
        }
    }

    public function enrollCourseFree(Request $request){
        $res = CourseRegistration::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id
        ]);
        if($res)
            return $this->returnSuccessMessage('enroll free success');
    }
}
