<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WishlistCollection;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function index()
    {
        return new WishlistCollection(Wishlist::with('product.variations')->where('user_id', auth('api')->user()->id)->latest()->get());
    }

    public function store(Request $request)
    {
        Wishlist::updateOrCreate([
            'user_id' => auth('api')->user()->id,
            'product_id' => $request->product_id
        ]);
        $product = Product::with('variations')->find($request->product_id);
        return response()->json([
            'success' => true,
            'message' => translate('Product is successfully added to your wishlist'),
            'product' => [
                'id' => (integer) $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'thumbnail_image' => api_asset($product->thumbnail_img),
                'base_price' => (double) product_base_price($product),
                'base_discounted_price' => (double) product_discounted_base_price($product),
                'stock' => $product->stock,
                'unit' => $product->unit,
                'min_qty' => $product->min_qty,
                'max_qty' => $product->max_qty,
                'rating' => (double) $product->rating,
                'is_variant' => (int) $product->is_variant,
                'variations' => $product->variations,
            ]
        ], 200);
    }

    public function destroy($product_id)
    {
        Wishlist::where('user_id',auth('api')->user()->id)->where('product_id',$product_id)->delete();
        return response()->json([
            'success' => true,
            'message' => translate('Product is successfully removed from your wishlist')
        ], 200);
    }
}
