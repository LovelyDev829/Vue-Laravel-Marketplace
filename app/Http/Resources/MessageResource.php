<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'user_image' => uploaded_asset($this->user->avatar),
            'message' => $this->message,
            'created_at' => date('h:i:m d-m-Y', strtotime($this->created_at)),
        ];
    }
}
