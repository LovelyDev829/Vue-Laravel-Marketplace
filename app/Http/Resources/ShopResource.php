<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'logo' => api_asset($this->logo),
            'banners' => $this->convertBanners(),
            'products_banners' => get_banners($this->products_banners),
            'categories' => new CategoryCollection($this->categories),
            'rating' => (double) $this->rating,
            'reviews_count' => $this->reviews_count,
        ];
    }


    protected function convertBanners()
    {
        $result = array();
        foreach (explode(',', $this->banners) as $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
