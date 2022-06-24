<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'shop' => [
                'name' => $this->shop->name ?? translate('Shop not found'),
                'slug' => $this->shop->slug ?? '',
            ],
            'payment_type' => $this->payment_type,
            'delivery_type' => $this->delivery_type,
            'delivery_status' => $this->delivery_status,
            'payment_status' => $this->payment_status,
            'coupon_discount' => (double) $this->coupon_discount,
            'shipping_cost' => (double) $this->shipping_cost,
            'grand_total' => (double) $this->grand_total,
            'subtotal' => (double) $this->orderDetails->sum('total') - $this->calculateTotalTax($this->orderDetails),
            'tax' => (double) $this->calculateTotalTax($this->orderDetails),
            'products' => new OrderProductCollection($this->orderDetails),
            'created_at' => strtotime($this->created_at),
            'has_refund_request' => $this->refundRequests->count() > 0 ? true : false, 
            'courier_name' => $this->courier_name, 
            'tracking_number' => $this->tracking_number, 
            'tracking_url' => $this->tracking_url, 
        ];
    }

    protected function calculateTotalTax($orderDetails){
        $tax = 0;
        foreach($orderDetails as $item){
            $tax += $item->tax*$item->quantity;
        }
        return $tax;
    }
}
