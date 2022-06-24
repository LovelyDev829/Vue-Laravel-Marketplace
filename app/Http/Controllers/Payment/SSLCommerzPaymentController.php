<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\CombinedOrder;
use Illuminate\Http\Request;
use App\Utility\SSLCommerz;

class SSLCommerzPaymentController extends Controller
{

    public function index()
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "order_id","order_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        if(session('payment_type') == 'cart_payment'){
            $order = CombinedOrder::where('code', session('order_code'))->first();
            $post_data = array();
            $post_data['total_amount'] = $order->grand_total; # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = substr(md5(session('order_code')), 0, 10); // tran_id must be unique

            $post_data['value_a'] = session('redirect_to');
            $post_data['value_b'] = session('payment_type');
            $post_data['value_c'] = session('order_code');
        }
        elseif (session('payment_type') == 'wallet_payment') {
            $post_data = array();
            $post_data['total_amount'] = session('amount'); # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = substr(md5(session('user_id')), 0, 10); // tran_id must be unique

            $post_data['value_a']     = session('redirect_to');
            $post_data['value_b']     = session('payment_type');
            $post_data['value_c']     = session('user_id');
            $post_data['value_d']     = session('amount');
        }
        elseif (session('payment_type') == 'seller_package_payment') {
            $post_data = array();
            $post_data['total_amount'] = session('amount'); # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = substr(md5(session('user_id')), 0, 10); // tran_id must be unique

            $post_data['value_a']     = session('redirect_to');
            $post_data['value_b']     = session('payment_type');
            $post_data['value_c']     = session('user_id');
            $post_data['value_d']     = session('seller_package_id');
        }

        $post_data['success_url'] = route('sslcommerz.success');
        $post_data['fail_url'] = route('sslcommerz.fail');
        $post_data['cancel_url'] = route('sslcommerz.cancel');

        $sslc = new SSLCommerz();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->initiate($post_data, false);

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        
        $payment = json_encode($request->all());

        $this->generate_session($request);

        return ( new PaymentController )->payment_success($payment);
        
    }

    public function fail(Request $request)
    {
        $this->generate_session($request);

        return ( new PaymentController )->payment_failed();
    }

    public function cancel(Request $request)
    {
        $this->generate_session($request);

        return ( new PaymentController )->payment_failed();
    }

    private function generate_session($request){
        session()->put('redirect_to', $request->value_a);
        session()->put('payment_method', 'sslcommerz');
        session()->put('payment_type', $request->value_b);
        session()->put('amount', $request->value_b == 'wallet_payment' ? $request->value_d : 0);
        session()->put('user_id', $request->value_b != 'cart_payment' ? null : $request->value_c);
        session()->put('order_code', $request->value_b == 'cart_payment' ? $request->value_c : null);
        session()->put('seller_package_payment', $request->value_b == 'seller_package_payment' ? $request->value_d : null);
    }
}
