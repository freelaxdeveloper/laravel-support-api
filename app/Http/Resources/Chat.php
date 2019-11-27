<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Chat as ChatModel;

class Chat extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            ChatModel::ID => $this->{ChatModel::ID},
            ChatModel::MESSAGES => new MessageCollection($this->{ChatModel::MESSAGES}),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
