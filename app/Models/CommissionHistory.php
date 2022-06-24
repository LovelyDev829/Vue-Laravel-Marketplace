<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionHistory extends Model
{
    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }
}
