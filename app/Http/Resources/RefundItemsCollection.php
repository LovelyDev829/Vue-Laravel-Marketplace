<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefundItemsCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = $this->orderDetail->product;
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'product' => [
                'id' => $product ? $product->id : null,
                'name' => $product ? $product->getTranslation('name') : translate('Product has been removed'),
                'thumbnail' => $product? api_asset($product->thumbnail_img) : '',
                'combinations' => $this->orderDetail->variation ? filter_variation_combinations($this->orderDetail->variation->combinations) : [],
            ],
        ];
    }
}
