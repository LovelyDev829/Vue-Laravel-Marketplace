<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function combinations()
    {
        return $this->hasMany(ProductVariationCombination::class);
    }
}
