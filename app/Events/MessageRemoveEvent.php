<?php

namespace App\Events;

use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRemoveEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message_id;

    /**
     * Create a new event instance.
     *
     * @param int $message_id
     */
    public function __construct(int $message_id)
    {
        $this->message_id = $message_id;

        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }


    /**
     * Set message for event
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            Message::ID => $this->message_id,
            Message::TYPE => 'system',
            Message::MESSAGE => 'This message has been removed',
        ];
    }

}
