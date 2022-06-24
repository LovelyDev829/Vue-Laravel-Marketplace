<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'code' => $data->code,
                    'user' => [
                        'name' => $data->user->name,
                        'email' => $data->user->email,
                        'phone' => $data->user->phone,
                        'avatar' => api_asset($data->user->avatar),
                    ],
                    'shipping_address' => json_decode($data->shipping_address),
                    'billing_address' => json_decode($data->billing_address),
                    'grand_total' => (double) $data->grand_total,
                    'orders' => OrderResource::collection($data->orders),
                    'date' => $data->created_at->toFormattedDateString()
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
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
