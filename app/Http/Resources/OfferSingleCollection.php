<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferSingleCollection extends JsonResource
{   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'banner' => api_asset($this->banner),
            'start_date' => $this->start_date,
            'end_date' => Carbon::createFromTimestamp($this->end_date)->toDateTimeString(),
            'products' => new ProductCollection(filter_products($this->products)),
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
