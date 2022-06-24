<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\CombinedOrder;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.payment.stripe');
    }

    public function create_checkout_session() {
        
        $amount = 0;
        if (session('payment_type') == 'cart_payment') {
            $order = CombinedOrder::where('code',session('order_code'))->first();
            $amount = round($order->grand_total * 100);
        } elseif (session('payment_type') == 'wallet_payment') {
            $amount = round(session('amount') * 100);
        }elseif(session('payment_type') == 'seller_package_payment'){
            $amount = session('amount') * 100;
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'USD',
                        'product_data' => [
                            'name' => "Payment"
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);


        return response()->json(['id' => $session->id, 'status' => 200]);
    }

    public function success() {
        try{
            return ( new PaymentController )->payment_success(null);
        }
        catch (\Exception $e) {
            // dd($e);
            return ( new PaymentController )->payment_failed();
        }
    }

    public function cancel(){
        return ( new PaymentController )->payment_failed();
    }
}
