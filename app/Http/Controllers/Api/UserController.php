<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\UserCollection;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Upload;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $total_order_products = OrderDetail::distinct()
                                        ->whereIn('order_id', Order::where('user_id', auth('api')->user()->id)->pluck('id')->toArray());

        $recent_purchased_products = Product::whereIn('id',$total_order_products->pluck('product_id')->toArray())->limit(10)->get();
        $last_recharge = Wallet::where('user_id',auth('api')->user()->id)->latest()->first();

        return response()->json([
            'success' => true,
            'last_recharge' => [
                'amount' => $last_recharge ? $last_recharge->amount : 0.00,
                'date' => $last_recharge ? $last_recharge->created_at->format('d.m.Y') : '',
            ],
            'total_order_products' => $total_order_products->count('product_variation_id'),
            'recent_purchased_products' => new ProductCollection($recent_purchased_products)
        ]);
    }
    public function info()
    {
        $user = User::find(auth('api')->user()->id);

        return response()->json([
            'success' => true,
            'user' => new UserCollection($user),
            'followed_shops' => $user->followed_shops->pluck('id')->toArray()
        ]);
    }

    public function updateInfo(Request $request)
    {
        $user = User::find(auth('api')->user()->id);
        if (Hash::check($request->oldPassword, $user->password)) {
            
            if($request->hasFile('avatar')){
                $upload = new Upload;
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('avatar')->getClientOriginalName());

                for($i=0; $i < count($arr)-1; $i++){
                    if($i == 0){
                        $upload->file_original_name .= $arr[$i];
                    }
                    else{
                        $upload->file_original_name .= ".".$arr[$i];
                    }
                }

                $upload->file_name = $request->file('avatar')->store('uploads/all');
                $upload->user_id = $user->id;
                $upload->extension = $request->file('avatar')->getClientOriginalExtension();
                $upload->type = 'image';
                $upload->file_size = $request->file('avatar')->getSize();
                $upload->save();

                $user->update([
                    'avatar' => $upload->id,
                ]);
            }
            $user->update([
                'name' => $request->name,
                // 'phone' => $request->phone
            ]);
            
            if($request->password){
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => translate('Profile information has been updated successfully'),
                'user' => new UserCollection($user)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => translate('The old password you have entered is incorrect')
            ]);
        }
    }
}
