<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Paystack;

class PaystackPaymentController extends Controller
{
    public function index(Request $request)
    {
        session()->put('redirect_to', $request->redirect_to);
        session()->put('amount', $request->amount);
        session()->put('payment_method', $request->payment_method);
        session()->put('payment_type', $request->payment_type);
        session()->put('user_id', $request->user_id);
        session()->put('order_code', $request->order_code);

        if ($request->payment_type == 'cart_payment') {
            $order = Order::where('code',session('order_code'))->first();
            $user = User::find($request->user_id);
            $request->email = $user->email;
            $request->amount = round($order->grand_total * 100);
            $request->currency = env('PAYSTACK_CURRENCY_CODE', 'NGN');
            $request->reference = Paystack::genTranxRef();
            return Paystack::getAuthorizationUrl()->redirectNow();
        }
        elseif ($request->payment_type == 'wallet_payment') {
            $user = User::find($request->user_id);
            $request->email = $user->email;
            $request->amount = round($request->amount * 100);
            $request->currency = env('PAYSTACK_CURRENCY_CODE', 'NGN');
            $request->reference = Paystack::genTranxRef();
            return Paystack::getAuthorizationUrl()->redirectNow();
        }
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
                if (session('payment_type') == 'cart_payment') {
                    $order = Order::where('code',session('order_code'))->first();
                    $ordercontroller = new OrderController;
                    $ordercontroller->paymentDone($order,session('payment_method'), $payment_details);
        
                }else if (session('payment_type') == 'wallet_payment') {
                    $payment_data['amount'] = session('amount');
                    $payment_data['user_id'] = session('user_id');
                    $payment_data['payment_method'] = session('payment_method');

                    $walletController = new WalletController;
                    $walletController->wallet_payment_done($payment_data, $payment_details);
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
            else{
                $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
                return redirect($redirect_to);
            }
        }
        catch(\Exception $e){
            $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
            return redirect($redirect_to);
        }
    }
}
