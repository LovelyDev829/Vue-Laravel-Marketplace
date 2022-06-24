<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function offer_products()
    {
        return $this->hasMany(OfferProduct::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'offer_products');
    }
}
