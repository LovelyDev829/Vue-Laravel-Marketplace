<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Offer;
use App\Models\Product;

class OfferCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'title' => $data->title,
                    'slug' => $data->slug,
                    'banner' => api_asset($data->banner),
                    'start_date' => $data->start_date,
                    'end_date' => $data->end_date,
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
