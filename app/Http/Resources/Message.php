<?php

namespace App\Http\Resources;

use App\Enum\MessageTypes;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Message AS MessageModel;

/**
 * @property mixed file_info
 */
class Message extends JsonResource
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
            MessageModel::ID => $this->{MessageModel::ID},
            MessageModel::TYPE => $this->{MessageModel::TYPE},
            MessageModel::AUTHOR => $this->{MessageModel::AUTHOR},
            'isEdited' => $this->{MessageModel::IS_EDITED},
            'liked' => $this->{MessageModel::IS_LIKE},
            'data' => [
                MessageTypes::TEXT => $this->{MessageModel::MESSAGE},
                MessageTypes::EMOJI => $this->{MessageModel::MESSAGE},
                'meta' => null,
                'suggestions' => [],
                MessageModel::FILE => (new FileService($this->{MessageModel::FILE}))->toArray(),
            ],
            'user' => $this->{MessageModel::GUEST},
            MessageModel::CREATED_AT => $this->{MessageModel::CREATED_AT},
            MessageModel::UPDATED_AT => $this->{MessageModel::UPDATED_AT},
        ];
    }
}
