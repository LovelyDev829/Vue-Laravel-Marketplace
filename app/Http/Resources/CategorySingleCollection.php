<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategorySingleCollection extends JsonResource
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
            'name' => $this->getTranslation('name'),
            'banner' => api_asset($this->banner),
            'icon' => api_asset($this->icon),
            'slug' => $this->slug,
        ];
    }
}
