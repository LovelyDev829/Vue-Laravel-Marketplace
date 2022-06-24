<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\CombinedOrder;
use Illuminate\Http\Request;
use App\Models\User;
use PaytmWallet;

class PaytmPaymentController extends Controller
{
    public function index(){
        
        $user = User::find(session('user_id'));

        if(session('payment_type') == 'cart_payment'){
            $order = CombinedOrder::where('code',session('order_code'))->first();
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
        elseif (session('payment_type') == 'wallet_payment') {
            $amount= session('amount');
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
        elseif (session('payment_type') == 'seller_package_payment') {
            $amount= session('amount');
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
            return ( new PaymentController )->payment_success($response);
        }
        elseif($transaction->isFailed()){
            return ( new PaymentController )->payment_failed();
        }
    }
}
