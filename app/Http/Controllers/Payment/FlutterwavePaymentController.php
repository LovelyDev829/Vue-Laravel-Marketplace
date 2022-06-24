<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\CombinedOrder;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Rave as Flutterwave;

class FlutterwavePaymentController extends Controller
{
    public function index()
    {
        if(session('payment_type') == 'cart_payment'){
            $order = CombinedOrder::where('code',session('order_code'))->first();
            return $this->initialize($order->grand_total);
        }
        elseif (session('payment_type') == 'wallet_payment') {
            return $this->initialize(session('amount'));
        }
        elseif(session('payment_type') == 'seller_package_payment'){
            return $this->initialize(session('amount'));
        }
    }

    public function initialize($amount)
    {
        //This generates a payment reference
        $reference = Flutterwave::generateReference();
        $user = User::find(session('user_id'));

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $amount,
            'email' => $user->email,
            'tx_ref' => $reference,
            'currency' => env('FLW_PAYMENT_CURRENCY_CODE'),
            'redirect_url' => route('flutterwave.callback'),
            'customer' => [
                'email' => $user->email,
                "phone_number" => $user->phone,
                "name" => $user->name
            ],

            "customizations" => [
                "title" => 'Payment',
                "description" => ""
            ]
        ];

        $payment = Flutterwave::initializePayment($data);

        if ($payment['status'] !== 'success') {
            return ( new PaymentController )->payment_failed();
        }

        return redirect($payment['data']['link']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {
        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            try{
                $payment = $data['data'];

                if($payment['status'] == "successful"){
                    return ( new PaymentController )->payment_success($payment);
                }else{
                    return ( new PaymentController )->payment_failed();
                }
            }
            catch(Exception $e){
                return ( new PaymentController )->payment_failed();
            }
        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
            $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
            return redirect($redirect_to);
        }
        //Put desired action/code after transaction has failed here
        $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
        return redirect($redirect_to);
    }
}