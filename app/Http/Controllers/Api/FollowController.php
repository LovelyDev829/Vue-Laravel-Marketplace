<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopCollection;
use App\Models\ShopFollower;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function index()
    {
        return new ShopCollection(auth('api')->user()->followed_shops);
    }

    public function store(Request $request)
    {
        ShopFollower::updateOrCreate([
            'user_id' => auth('api')->user()->id,
            'shop_id' => $request->shop_id
        ]);
        return response()->json([
            'success' => true,
            'message' => translate('This Shop is successfully added to your following list.'),
        ], 200);
    }

    public function destroy($shop_id)
    {
        ShopFollower::where('user_id',auth('api')->user()->id)->where('shop_id',$shop_id)->delete();
        return response()->json([
            'success' => true,
            'message' => translate('This Shop is successfully removed from your following list.')
        ], 200);
    }
}
