<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Razorpay\Api\Api;
use App\Http\Controllers\CustomerPackageController;
use App\Models\CombinedOrder;
use App\Models\User;

class RazorpayPaymentController extends Controller
{
    public function index()
    {
        $user = User::find(session('user_id'));

        $payment_type = session('payment_type');


        switch ($payment_type) {
            case 'cart_payment':
                $title = translate('Cart payment');
                $amount = CombinedOrder::where('code', session('order_code'))->first()->grand_total;
                
                break;
            case 'wallet_payment':
                $title = translate('Wallet payment');
                $amount = session('amount');
                
                break;
            case 'seller_package_payment':
                $title = translate('Seller package payment');
                $amount = session('amount');
                
                break;
            default:
                $title = '';
                $amount = 0;
                
        }

        $data = [
            'amount' => $amount * 100 ,
            'name' => $user->name,
            'email' => $user->email,
            'app_name' => env('APP_NAME'),
            'app_logo' => uploaded_asset(get_setting('header_logo')),
            'payment_title' => $title
        ];

        return view('frontend.payment.razorpay',compact('data'));
    }

    public function payment(Request $request)
    {
        //Input items of form
        $input = $request->all();
        //get API Configuration
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            $payment_detalis = null;
            try {

                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payment_detalis = json_encode(array(
                    'id' => $response['id'],
                    'method' => $response['method'],
                    'amount' => $response['amount'],
                    'currency' => $response['currency']
                ));

            } catch (\Exception $e) {
                return ( new PaymentController )->payment_failed();
            }

            return ( new PaymentController )->payment_success($payment_detalis);
        }
    }
}
