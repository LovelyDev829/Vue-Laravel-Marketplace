<?php

namespace App\Http\Controllers\Payment;

use App\Addons\Multivendor\Http\Controllers\Seller\SellerPackageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use App\Models\User;
use Auth;

class PaymentController extends Controller
{

    public function payment_initialize(Request $request, $gateway){

        session()->put('redirect_to', $request->redirect_to);
        session()->put('amount', $request->amount);
        session()->put('payment_method', $request->payment_method);
        session()->put('payment_type', $request->payment_type);
        session()->put('user_id', $request->user_id);
        session()->put('order_code', $request->order_code);
        session()->put('seller_package_id', $request->seller_package_id ?? null);

        if($gateway == 'paypal'){
            return ( new PaypalPaymentController )->index();
        }
        elseif ($gateway == 'stripe') {
            return ( new StripePaymentController )->index();
        }
        elseif ($gateway == 'sslcommerz') {
            return ( new SSLCommerzPaymentController )->index();
        }
        elseif ($gateway == 'paystack') {
            return ( new PaystackPaymentController )->index($request);
        }
        elseif ($gateway == 'flutterwave') {
            return ( new FlutterwavePaymentController )->index();
        }
        elseif ($gateway == 'paytm') {
            return ( new PaytmPaymentController )->index();
        }
        elseif ($gateway == 'razorpay') {
            return ( new RazorpayPaymentController )->index();
        }

    }

    public function payment_success($payment_details = null)
    {
        if (session('payment_type') == 'cart_payment') {

            $order = CombinedOrder::where('code',session('order_code'))->first();

            (new OrderController)->paymentDone($order, session('payment_method'), json_encode($payment_details));

        }elseif (session('payment_type') == 'wallet_payment') {

            $payment_data['amount'] = session('amount');
            $payment_data['user_id'] = session('user_id');
            $payment_data['payment_method'] = session('payment_method');

            (new WalletController)->wallet_payment_done($payment_data, json_encode($payment_details));

        }elseif(session('payment_type') == 'seller_package_payment'){
            
            (new SellerPackageController)->purchase_payment_done(session('seller_package_id'), session('payment_method'), json_encode($payment_details));

            if(!Auth::check()){
                Auth::login(User::find(session('user_id')));
            }

            return redirect()->route('seller.dashboard');
        }

        $redirect_to = session('redirect_to')."?";
        $redirect_to .= session('payment_type')."=success";
        $redirect_to .= "&payment_method=".session('payment_method');
        $redirect_to .= session('payment_type') == 'cart_payment' ? "&order_code=".session('order_code') : "";

        $this->clear_session();

        return redirect($redirect_to);
    }

    public function payment_failed()
    {
        
        if(session('payment_type') == 'seller_package_payment'){
            flash(translate('Package purchasing failed'))->error();
            return redirect()->route('seller.dashboard');
        }

        $redirect_to = session('redirect_to')."?";
        $redirect_to .= session('payment_type')."=failed";
        $redirect_to .= "&payment_method=".session('payment_method');
        $redirect_to .= session('payment_type') == 'cart_payment' ? "&order_code=".session('order_code') : "";

        $this->clear_session();

        return redirect($redirect_to);
    }

    private function clear_session()
    {
        session()->forget('redirect_to');
        session()->forget('amount');
        session()->forget('payment_method');
        session()->forget('payment_type');
        session()->forget('user_id');
        session()->forget('order_code');
        session()->forget('seller_package_id');
    }
}