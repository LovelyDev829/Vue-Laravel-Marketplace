<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use PaytmWallet;

class PaytmPaymentController extends Controller
{
    public function index(Request $request){

        session()->put('redirect_to', $request->redirect_to);
        session()->put('amount', $request->amount);
        session()->put('payment_method', $request->payment_method);
        session()->put('payment_type', $request->payment_type);
        session()->put('user_id', $request->user_id);
        session()->put('order_code', $request->order_code);
        $user = User::find($request->user_id);

        if($request->payment_type == 'cart_payment'){
            $order = Order::where('code',session('order_code'))->first();
            $amount = $order->grand_total;

            $payment = PaytmWallet::with('receive');
            $payment->prepare([
                'order' => $order->id,
                'user' => $user->id,
                'mobile_number' => $user->phone,
                'email' => $user->email,
                'amount' => $amount,
                'callback_url' => route('paytm.callback')
            ]);
            return $payment->receive();
        }
        elseif ($request->payment_type == 'wallet_payment') {
            $amount= $request->amount;
            $payment = PaytmWallet::with('receive');
            $payment->prepare([
                'order' => rand(10000,99999),
                'user' => $user->id,
                'mobile_number' => $user->phone,
                'email' => $user->email,
                'amount' => $amount,
                'callback_url' => route('paytm.callback')
            ]);
            return $payment->receive();
        }
    }

    public function callback(Request $request){
        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm

        if($transaction->isSuccessful()){
            if(session('payment_type') == 'cart_payment'){
                $order = Order::where('code',session('order_code'))->first();
                $ordercontroller = new OrderController;
                $ordercontroller->paymentDone($order,session('payment_method'), json_encode($response));
            }
            elseif (session('payment_type') == 'wallet_payment') {
                $payment_data['amount'] = session('amount');
                $payment_data['user_id'] = session('user_id');
                $payment_data['payment_method'] = session('payment_method');

                $walletController = new WalletController;
                $walletController->wallet_payment_done($payment_data, json_encode($response));
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
        elseif($transaction->isFailed()){
            $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
            return redirect($redirect_to);
        }
    }
}
