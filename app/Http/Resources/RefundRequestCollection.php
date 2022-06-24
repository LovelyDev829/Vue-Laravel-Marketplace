<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RefundRequestCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'order_code' => $data->order->combined_order->code,
                    'amount' => $data->amount,
                    'status' => $data->admin_approval,
                    'shop' => $data->shop->name,
                    'refunditems' => RefundItemsCollection::collection($data->refundRequestItems),
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
}
