<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderUpdate extends Model
{
    protected $guarded = [];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
