<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    use HasFactory;
    public function refundRequestItems()
    {
        return $this->hasMany(RefundRequestItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

}
