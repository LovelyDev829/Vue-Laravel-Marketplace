<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $request)
    {
        session()->put('redirect_to', $request->redirect_to);
        session()->put('amount', $request->amount);
        session()->put('payment_method', $request->payment_method);
        session()->put('payment_type', $request->payment_type);
        session()->put('user_id', $request->user_id);
        session()->put('order_code', $request->order_code);

        return view('frontend.payment.stripe');
    }

    public function create_checkout_session() {
        
        $amount = 0;
        if (session('payment_type') == 'cart_payment') {
            $order = Order::where('code',session('order_code'))->first();
            $amount = round($order->grand_total * 100);
        } elseif (session('payment_type') == 'wallet_payment') {
            $amount = round(session('amount') * 100);
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
            if (session('payment_type') == 'cart_payment') {
                $order = Order::where('code',session('order_code'))->first();
                $ordercontroller = new OrderController;
                $ordercontroller->paymentDone($order,session('payment_method'), null);

            }else if (session('payment_type') == 'wallet_payment') {
                $payment_data['amount'] = session('amount');
                $payment_data['user_id'] = session('user_id');
                $payment_data['payment_method'] = session('payment_method');

                $walletController = new WalletController;
                $walletController->wallet_payment_done($payment_data, null);
            }

            $redirect_to = session('redirect_to')."?".session('payment_type')."=success&order_code=".session('order_code');

            session()->forget('redirect_to');
            session()->forget('amount');
            session()->forget('payment_method');
            session()->forget('payment_type');
            session()->forget('user_id');
            session()->forget('order_code');

            return redirect($redirect_to);
        }
        catch (\Exception $e) {
            $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
            return redirect($redirect_to);
        }
    }

    public function cancel(){
        $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
        return redirect($redirect_to);
    }
}
