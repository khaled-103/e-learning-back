<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\OrderPayment;
use App\Models\Wishlist;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class PaymentController extends Controller
{
    use GeneralTrait;

    public function cartCheckOut(Request $request)
    {
        $summary = [];
        foreach ($request->orderItems as $course) {
            array_push($summary, ['id' => $course['id'], 'name' => $course['name'], 'image' => 'http://127.0.0.1:8000/uploads/images/org/courses/' . $course['image'], 'price' => $course['price'], 'discount' => $course['discount']]);
        }
        $order =  OrderPayment::create([
            'user_id' => $request->user_id,
            'totalPrice' => $request->totalPrice,
            'basicPrice' => $request->basicPrice,
            'discount' => $request->discount,
            'summary' => json_encode($summary),
            'payment_id' => 'not set',
        ]);
        if ($order) {
            return $this->returnData('orderId', $order->id);
        }
        return $this->returnError('falid', 'faild add order');
    }

    public function createNewOrder(Request $request)
    {
        $order = OrderPayment::create([
            'user_id' => $request->userId,
            'totalPrice' => $request->amount,
            'basicPrice' => $request->basicPrice,
            'discount' => $request->discount,
            'summary' => json_encode($request->orderItems),
            'payment_id' => 'not set',
        ]);
        if ($order) {
            return $this->returnData('orderId', $order->id);
        }
        return $this->returnError(429, 'something wrong when creating order');
    }

    public function createPaymentIntent(Request $request)
    {
        // return $request->amount;
        $stripe = new \Stripe\StripeClient('sk_test_51Meg81Loe7VzYnJpfATP4ynIRnPLm2KyHO6pG8j6khveKw9PC31cNgtwioMWm90HxCTR2Vp1kgNlsGjazYF25SV800WCPxWrQw');
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $request->amount * 100,
            'currency' => 'USD',
            'payment_method_types' => ['card'],
        ]);
        $paymentIntent->client_secret;
        $order = OrderPayment::where('id', $request->orderId)->where('user_id', $request->userId)->first();
        if ($order) {
            $order->update([
                'payment_id' => $paymentIntent->id
            ]);
        }
        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }
    public function getInitOrderInfo(Request $request)
    {
        $order = OrderPayment::where('id', $request->orderId)->where('user_id', $request->userId)->first();
        if ($order && $order->status != 'completed')
            return $this->returnData('order', $order);
        return $this->returnError(429, 'cant access to this order');
    }

    public function checkStripeReturn(Request $request)
    {
        $order = OrderPayment::find($request->orderId);
        if ($order) {
            $order->update([
                'status' => 'pending'
            ]);
        }

        $stripe = new \Stripe\StripeClient(
            'sk_test_51Meg81Loe7VzYnJpfATP4ynIRnPLm2KyHO6pG8j6khveKw9PC31cNgtwioMWm90HxCTR2Vp1kgNlsGjazYF25SV800WCPxWrQw'
        );
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->payment_intent,
            []
        );
        if ($paymentIntent->status == 'succeeded') {
            $summary = json_decode($order->summary);
            foreach ($summary as $course) {
                CourseRegistration::create([
                    'user_id' => $order->user_id,
                    'course_id' => $course->id
                ]);
                $cart = Cart::where(['course_id'=> $course->id, 'user_id' => $order->user_id])->first();
                if ($cart)
                    $cart->delete();
                $wishlist = Wishlist::where(['course_id'=> $course->id, 'user_id' => $order->user_id])->first();
                if ($wishlist)
                    $wishlist->delete();
            }
            if ($order) {
                $order->update([
                    'status' => 'completed'
                ]);
                return $this->returnSuccessMessage('confirm succss');
            }
            return $this->returnError(429, 'something error');
        }
    }

    public function enrollCourseFree(Request $request)
    {
        $res = CourseRegistration::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id
        ]);
        if ($res)
            return $this->returnSuccessMessage('enroll free success');
    }

    public function cancleOrder(Request $request)
    {
        $order = OrderPayment::find($request->orderId);
        if ($order->status == 'not pay') {
            $order->delete();
        }
    }
}
