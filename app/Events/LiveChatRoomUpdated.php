<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class LiveChatRoomUpdated implements ShouldBroadcast
{
    use Dispatchable;

    public function __construct(public int $userId)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('instansi.' . $this->userId . '.live-chats'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'room.updated';
    }
}