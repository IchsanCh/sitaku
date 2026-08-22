<?php

namespace App\Events;

use App\Models\LiveChat;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveChatRoomUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(public LiveChat $liveChat)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('instansi.' . $this->liveChat->user_id . '.live-chats'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'room.updated';
    }

    // Data selengkap yang dibutuhin inbox buat update/nambah card room-nya
    // tanpa reload -- ditambahin di sini (bukan cuma userId kayak sebelumnya).
    public function broadcastWith(): array
    {
        return [
            'id' => $this->liveChat->id,
            'nomor_wa' => $this->liveChat->nomor_wa,
            'status' => $this->liveChat->status,
            'unread_count' => $this->liveChat->unread_count,
            'last_message_at' => $this->liveChat->last_message_at?->toIso8601String(),
            'replying_admin_id' => $this->liveChat->replying_admin_id,
            'replying_admin_name' => $this->liveChat->replyingAdmin?->name,
            'replying_at' => $this->liveChat->replying_at?->toIso8601String(),
            'chat_url' => route('support.chat.show', $this->liveChat),
        ];
    }
}