<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\Order;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaypalPaymentController extends Controller
{

    public function paypal(Request $request)
    {
        session()->put('redirect_to', $request->redirect_to);
        session()->put('amount', $request->amount);
        session()->put('payment_method', $request->payment_method);
        session()->put('payment_type', $request->payment_type);
        session()->put('user_id', $request->user_id);
        session()->put('order_code', $request->order_code);

        // Creating an environment
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if (get_setting('paypal_sandbox') == 1) {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        }
        else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }
        $client = new PayPalHttpClient($environment);

        if($request->payment_type == 'cart_payment'){
            $order = Order::where('code',session('order_code'))->first();
            $amount = $order->grand_total;
        }
        elseif ($request->payment_type == 'wallet_payment') {
            $amount = $request->amount;
        }

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
                             "intent" => "CAPTURE",
                             "purchase_units" => [[
                                 "reference_id" => rand(000000,999999),
                                 "amount" => [
                                     "value" => number_format($amount, 2, '.', ''),
                                     "currency_code" => \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code
                                 ]
                             ]],
                             "application_context" => [
                                  "cancel_url" => route('paypal.cancel'),
                                  "return_url" => route('paypal.success')
                             ]
                         ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            return Redirect::to($response->result->links[1]->href);
        }catch (HttpException $ex) {
            $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
            return redirect($redirect_to);
        }
    }


    public function cancel(Request $request)
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
        return redirect($redirect_to);
    }

    public function success(Request $request)
    {
        //dd($request->all());
        // Creating an environment
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if (get_setting('paypal_sandbox') == 1) {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        }
        else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }
        $client = new PayPalHttpClient($environment);

        // $response->result->id gives the orderId of the order created above

        $ordersCaptureRequest = new OrdersCaptureRequest($request->token);
        $ordersCaptureRequest->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($ordersCaptureRequest);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            if($request->session()->get('payment_type') == 'cart_payment'){
                $order = Order::where('code',session('order_code'))->first();
                $ordercontroller = new OrderController;
                $ordercontroller->paymentDone($order,session('payment_method'), json_encode($response));
            }
            elseif ($request->session()->get('payment_type') == 'wallet_payment') {
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

        }catch (HttpException $ex) {
            $redirect_to = session('redirect_to')."?".session('payment_type')."=failed&order_code=".session('order_code')."&payment_method=".session('payment_method');
            return redirect($redirect_to);
        }
    }
}
