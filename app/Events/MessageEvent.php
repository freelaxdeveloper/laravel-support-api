<?php

namespace App\Events;

use App\Chat;
use App\Http\Resources\Message as MessageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Message as ModelMessage;
use App\Http\Resources\Message as ResourceMessage;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $chat;

    /**
     * Create a new event instance.
     *
     * @param MessageResource $messageResource
     * @param Chat $chat
     */
    public function __construct(MessageResource $messageResource, Chat $chat)
    {
        $this->message = $messageResource;
        $this->chat = $chat;

        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("chat.{$this->chat->slug}");
    }
}
