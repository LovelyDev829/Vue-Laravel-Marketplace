<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Rave as Flutterwave;

class FlutterwavePaymentController extends Controller
{
    public function pay(Request $request)
    {
        session()->put('redirect_to', $request->redirect_to);
        session()->put('amount', $request->amount);
        session()->put('payment_method', $request->payment_method);
        session()->put('payment_type', $request->payment_type);
        session()->put('user_id', $request->user_id);
        session()->put('order_code', $request->order_code);

        if ($request->payment_type == 'cart_payment') {
            $order = Order::where('code', session('order_code'))->first();
            return $this->initialize($order->grand_total);
        } elseif ($request->payment_type == 'wallet_payment') {
            return $this->initialize($request->amount);
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
            $redirect_to = session('redirect_to') . "?" . session('payment_type') . "=failed&order_code=" . session('order_code') . "&payment_method=" . session('payment_method');
            return redirect($redirect_to);
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

            try {
                $payment = $data['data'];

                if ($payment['status'] == "successful") {
                    if (session('payment_type') == 'cart_payment') {
                        $order = Order::where('code', session('order_code'))->first();
                        $ordercontroller = new OrderController;
                        $ordercontroller->paymentDone($order, session('payment_method'), json_encode($payment));
                    }

                    if (session('payment_type') == 'wallet_payment') {
                        $payment_data['amount'] = session('amount');
                        $payment_data['user_id'] = session('user_id');
                        $payment_data['payment_method'] = session('payment_method');

                        $walletController = new WalletController;
                        $walletController->wallet_payment_done($payment_data, json_encode($payment));
                    }

                    $redirect_to = session('redirect_to') . "?" . session('payment_type') . "=success&order_code=" . session('order_code');

                    session()->forget('redirect_to');
                    session()->forget('amount');
                    session()->forget('payment_method');
                    session()->forget('payment_type');
                    session()->forget('user_id');
                    session()->forget('order_code');

                    return redirect($redirect_to);
                }
            } catch (Exception $e) {
                $redirect_to = session('redirect_to') . "?" . session('payment_type') . "=failed&order_code=" . session('order_code') . "&payment_method=" . session('payment_method');
                return redirect($redirect_to);
            }
        } elseif ($status ==  'cancelled') {
            //Put desired action/code after transaction has been cancelled here
            $redirect_to = session('redirect_to') . "?" . session('payment_type') . "=failed&order_code=" . session('order_code') . "&payment_method=" . session('payment_method');
            return redirect($redirect_to);
        }
        //Put desired action/code after transaction has failed here
        $redirect_to = session('redirect_to') . "?" . session('payment_type') . "=failed&order_code=" . session('order_code') . "&payment_method=" . session('payment_method');
        return redirect($redirect_to);
    }
}
