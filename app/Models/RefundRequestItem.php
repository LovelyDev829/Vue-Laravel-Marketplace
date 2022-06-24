<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundRequestItem extends Model
{
    use HasFactory;
    public function refundRequest()
    {
        return $this->belongsTo(RefundRequest::class);
    }

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
