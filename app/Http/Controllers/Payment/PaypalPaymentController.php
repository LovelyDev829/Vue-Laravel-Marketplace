<?php

namespace App\Http\Controllers\Payment;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Http\Controllers\Controller;
use App\Models\CombinedOrder;
use PayPalHttp\HttpException;
use Illuminate\Http\Request;
use Redirect;

class PaypalPaymentController extends Controller
{

    public function index()
    {
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

        if(session('payment_type') == 'cart_payment'){
            $order = CombinedOrder::where('code',session('order_code'))->first();
            $amount = $order->grand_total;
        }
        elseif (session('payment_type') == 'wallet_payment' || session('payment_type') == 'seller_package_payment') {
            $amount = session('amount');
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

            return ( new PaymentController )->payment_failed();
        }
    }


    public function cancel(Request $request)
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        return ( new PaymentController )->payment_failed();
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
            return ( new PaymentController )->payment_success($response);

        }catch (HttpException $ex) {
            return ( new PaymentController )->payment_failed();
        }
    }
}
