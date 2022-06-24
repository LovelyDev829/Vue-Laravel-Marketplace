<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'slug' => encrypt($this->id),
            'sender_id' => $this->sender_id,
            'sender_name' => $this->sender->name,
            'sender_image' => uploaded_asset($this->sender->avatar),
            'receiver_id' => $this->receiver_id,
            'receiver_name' => $this->receiver->name,
            'receiver_image' => uploaded_asset($this->receiver->avatar),
            'title' => $this->title,
            'sender_viewed' => (int) $this->sender_viewed,
            'receiver_viewed' => (int) $this->receiver_viewed,
            'latest_message' => $this->messages()->latest()->first(),
            'latest_message_time' => date('h:i:m d-m-Y', strtotime($this->messages()->latest()->first()->created_at)),
        ];
    }
}
