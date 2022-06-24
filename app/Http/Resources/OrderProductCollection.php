<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->product ? $data->product->id : null,
                    'name' => $data->product ? $data->product->getTranslation('name') : translate('Product has been removed'),
                    'thumbnail' => $data->product ? api_asset($data->product->thumbnail_img) : '',
                    'combinations' => $data->variation ? filter_variation_combinations($data->variation->combinations) : [],
                    'price' => $data->price,
                    'tax' => $data->tax,
                    'total' => $data->total,
                    'quantity' => $data->quantity,
                    'order_detail_id' => $data->id,
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
