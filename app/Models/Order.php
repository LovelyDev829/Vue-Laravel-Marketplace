<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{

    protected $guarded = [];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function combined_order()
    {
        return $this->belongsTo(CombinedOrder::class);
    }

    public function commission_histories()
    {
        return $this->hasMany(CommissionHistory::class);
    }

    public function order_udpates()
    {
        return $this->hasMany(OrderUpdate::class)->latest();
    }

    public function refundRequests()
    {
        return $this->hasMany(RefundRequest::class);
    }

}
