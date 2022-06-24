<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WalletCollection;
use App\Models\User;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function walletRechargeHistory()
    {
        return new WalletCollection(Wallet::where('user_id', auth('api')->user()->id)->latest()->paginate(12));
    }

    public function wallet_payment_done($payment_data, $payment_details)
    {
        $user = User::find($payment_data['user_id']);
        $user->balance = $user->balance + $payment_data['amount'];
        $user->save();

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->amount = $payment_data['amount'];
        $wallet->payment_method = $payment_data['payment_method'];
        $wallet->payment_details = $payment_details;
        $wallet->details = 'Recharge';
        $wallet->save();
    }
}
