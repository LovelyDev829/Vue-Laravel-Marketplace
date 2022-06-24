<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShopCollection extends ResourceCollection
{
    private $top_3_products;

    public function __construct($resource, $top_3_products = false)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;

        $this->top_3_products = $top_3_products;
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'slug' => $data->slug,
                    'name' => $data->name,
                    'logo' => api_asset($data->logo),
                    'banner' => api_asset(explode(',', $data->banners)[0]),
                    'rating' => (double) $data->rating,
                    'min_order' => (double) $data->min_order,
                    'categories' => new CategoryCollection($data->categories),
                    'top_3_products' => $this->top_3_products ? new ProductCollection($data->top_3_products) : [],
                    'reviews_count' => $data->reviews_count,
                    'products_count' => $data->products_count,
                    'since' => $data->created_at->format('d M, Y')
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
