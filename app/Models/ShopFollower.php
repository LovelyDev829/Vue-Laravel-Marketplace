<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopFollower extends Model
{
    protected $fillable = [
        'user_id', 'shop_id'
    ];
}
