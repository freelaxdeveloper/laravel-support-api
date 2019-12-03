<?php

namespace App\Events;

use App\Chat;
use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    /**
     * @var Chat
     */
    private $chat;

    /**
     * Create a new event instance.
     *
     * @param Message $message
     */
    public function __construct($message, Chat $chat)
    {
        $this->message = $message;
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

    /**
     * Set message for event
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            Message::ID => $this->message->id,
            Message::MESSAGE => $this->message->message,
        ];
    }
}
