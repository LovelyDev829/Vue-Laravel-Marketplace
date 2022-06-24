<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
        Subscriber::updateOrCreate([
            'email' => $request->email,
        ]);
        return response()->json([
            'success' => true,
            'message' => translate('You have subscribed successfully.'),
        ]);
    }
}