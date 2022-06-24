<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Utility\SSLCommerz;

class SSLCommerzPaymentController extends Controller
{

    public function index(Request $request)
    {

            # Here you have to receive all the order data to initate the payment.
            # Lets your oder trnsaction informations are saving in a table called "orders"
            # In orders table order uniq identity is "order_id","order_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
            if($request->payment_type == 'cart_payment'){
                $order = Order::where('code', $request->order_code)->first();
                $post_data = array();
                $post_data['total_amount'] = $order->grand_total; # You cant not pay less than 10
                $post_data['currency'] = "BDT";
                $post_data['tran_id'] = substr(md5($request->order_code), 0, 10); // tran_id must be unique

                $post_data['value_a'] = $request->redirect_to;
                $post_data['value_b'] = $request->payment_type;
                $post_data['value_c'] = $request->order_code;
            }
            elseif ($request->payment_type == 'wallet_payment') {
                $post_data = array();
                $post_data['total_amount'] = $request->amount; # You cant not pay less than 10
                $post_data['currency'] = "BDT";
                $post_data['tran_id'] = substr(md5($request->user_id), 0, 10); // tran_id must be unique

                $post_data['value_a']     = $request->redirect_to;
                $post_data['value_b']     = $request->payment_type;
                $post_data['value_c']     = $request->user_id;
                $post_data['value_d']     = $request->amount;
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
        //echo "Transaction is Successful";

        $sslc = new SSLCommerz();
        #Start to received these value from session. which was saved in index function.
        $tran_id = $request->value_a;
        #End to received these value from session. which was saved in index function.
        $payment = json_encode($request->all());

        if(isset($request->value_b)){
            if ($request->value_b == 'cart_payment') {
                $order = Order::where('code',$request->value_c)->first();
                $ordercontroller = new OrderController;
                $ordercontroller->paymentDone($order, 'sslcommerz', $payment);
                
                $redirect_to = $request->value_a."?".$request->value_b."=success&order_code=".$request->value_c;

            }else if ($request->value_b == 'wallet_payment') {
                $payment_data['amount'] = $request->value_d;
                $payment_data['user_id'] = $request->value_c;
                $payment_data['payment_method'] = 'sslcommerz';

                $walletController = new WalletController;
                $walletController->wallet_payment_done($payment_data, null);

                $redirect_to = $request->value_a."?".$request->value_b."=success";
            }

            return redirect($redirect_to);
        }
    }

    public function fail(Request $request)
    {
        $redirect_to = $request->value_a."?".$request->value_b."=failed&order_code=".$request->value_c."&payment_method=sslcommerz";
        return redirect($redirect_to);
    }

     public function cancel(Request $request)
    {
        $redirect_to = $request->value_a."?".$request->value_b."=failed&order_code=".$request->value_c."&payment_method=sslcommerz";
        return redirect($redirect_to);
    }
}
