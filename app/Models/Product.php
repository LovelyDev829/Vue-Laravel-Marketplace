<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Product extends Model
{

    protected $guarded = [];

    protected $with = ['product_translations', 'taxes'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $product_translations = $this->product_translations->where('lang', $lang)->first();
        return $product_translations != null ? $product_translations->$field : $this->$field;
    }

    public function product_translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function taxes()
    {
        return $this->hasMany(ProductTax::class);
    }

    public function product_taxes()
    {
        return $this->belongsToMany(Tax::class, 'product_taxes', 'product_id', 'tax_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 1);
    }

    public function reviews_5()
    {
        return $this->hasMany(Review::class)->where('status', 1)->where('rating', 5);
    }

    public function reviews_4()
    {
        return $this->hasMany(Review::class)->where('status', 1)->where('rating', 4);
    }

    public function reviews_3()
    {
        return $this->hasMany(Review::class)->where('status', 1)->where('rating', 3);
    }

    public function reviews_2()
    {
        return $this->hasMany(Review::class)->where('status', 1)->where('rating', 2);
    }

    public function reviews_1()
    {
        return $this->hasMany(Review::class)->where('status', 1)->where('rating', 1);
    }

    public function offers()
    {
        return $this->hasMany(OfferProduct::class);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function attribute_values()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    public function variation_combinations()
    {
        return $this->hasMany(ProductVariationCombination::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
