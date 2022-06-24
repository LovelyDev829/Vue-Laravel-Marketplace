<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\CombinedOrder;
use Illuminate\Http\Request;
use App\Models\User;
use Paystack;

class PaystackPaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find($request->user_id);
        $request->email = $user->email;
        $request->currency = env('PAYSTACK_CURRENCY_CODE', 'NGN');

        if ($request->payment_type == 'cart_payment') {
            $order = CombinedOrder::where('code',session('order_code'))->first();
            $request->amount = round($order->grand_total * 100);
        }
        elseif ($request->payment_type == 'wallet_payment') {
            $request->amount = round($request->amount * 100);
        }
        elseif ($request->payment_type == 'seller_package_payment') {
            $request->amount = round($request->amount * 100);
        }

        $request->reference = Paystack::genTranxRef();
        return Paystack::getAuthorizationUrl()->redirectNow();
    }


    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function return()
    {
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want

        try{
            $payment = Paystack::getPaymentData();
            $payment_details = json_encode($payment);
            if (!empty($payment['data']) && $payment['data']['status'] == 'success') {   
                return ( new PaymentController )->payment_success($payment_details); 
            }
            else{
                return ( new PaymentController )->payment_failed();
            }
        }
        catch(\Exception $e){
            return ( new PaymentController )->payment_failed();
        }
    }
}
