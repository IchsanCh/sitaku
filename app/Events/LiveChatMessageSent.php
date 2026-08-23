<?php

namespace App\Events;

use App\Models\LiveChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public LiveChatMessage $message)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('live-chat.' . $this->message->live_chat_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        $replyTo = $this->message->replyTo;

        return [
            'id' => $this->message->id,
            'live_chat_id' => $this->message->live_chat_id,
            'sender_type' => $this->message->sender_type,
            'admin_support_name' => $this->message->adminSupport?->name,
            'message' => $this->message->message,
            'media_url' => $this->message->media_url,
            'media_filename' => $this->message->media_filename,
            'media_extension' => $this->message->media_extension,
            'is_image' => $this->message->isImage(),
            'created_at' => $this->message->created_at->toIso8601String(),
            'reply_to' => $replyTo ? [
                'id' => $replyTo->id,
                'sender_type' => $replyTo->sender_type,
                'admin_support_name' => $replyTo->adminSupport?->name,
                'excerpt' => $replyTo->message ?: ($replyTo->media_filename ? '📎 ' . $replyTo->media_filename : '[Media]'),
            ] : null,
        ];
    }
}