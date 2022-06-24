<?php

namespace App\Utility;

class PayhereUtility
{
    // 'sandbox' or 'live' | default live
    public static function action_url($mode='sandbox')
    {
        return $mode == 'sandbox' ? 'https://sandbox.payhere.lk/pay/checkout' :'https://www.payhere.lk/pay/checkout';
    }

    // 'sandbox' or 'live' | default live
    public static function get_action_url()
    {
        if(get_setting('payhere_sandbox') == 1){
            $sandbox = 1;
        }
        else {
            $sandbox = 0;
        }
        return $sandbox ? PayhereUtility::action_url('sandbox') : PayhereUtility::action_url('live');
    }

    public static  function create_checkout_form($order_id, $amount, $first_name, $last_name, $phone, $email,$address,$city)
    {
        return view('frontend.payhere.checkout_form', compact('order_id', 'amount', 'first_name', 'last_name', 'phone', 'email','address','city'));
    }

    public static  function create_wallet_form($user_id,$order_id, $amount, $first_name, $last_name, $phone, $email,$address,$city)
    {
        return view('frontend.payhere.wallet_form', compact('user_id','order_id', 'amount', 'first_name', 'last_name', 'phone', 'email','address','city'));
    }

    public static function getHash($order_id, $payhere_amount)
    {
        $hash = strtoupper (md5 ( env('PAYHERE_MERCHANT_ID') . $order_id . $payhere_amount . env('PAYHERE_CURRENCY') . strtoupper(md5(env('PAYHERE_SECRET'))) ) );
        return $hash;
    }





}
