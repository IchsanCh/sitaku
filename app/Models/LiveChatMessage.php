<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $live_chat_id
 * @property string $sender_type
 * @property int|null $admin_support_id
 * @property string $message
 * @property string|null $media_url
 * @property string|null $media_filename
 * @property string|null $media_extension
 * @property string|null $fonnte_message_id
 * @property string|null $fonnte_inbox_id
 * @property int|null $reply_to_message_id
 */
class LiveChatMessage extends Model
{
    protected $fillable = [
        'live_chat_id',
        'sender_type',
        'admin_support_id',
        'message',
        'media_url',
        'media_filename',
        'media_extension',
        'fonnte_message_id',
        'fonnte_inbox_id',
        'reply_to_message_id',
    ];

    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    public function liveChat()
    {
        return $this->belongsTo(LiveChat::class);
    }

    public function adminSupport()
    {
        return $this->belongsTo(AdminSupport::class);
    }

    public function replyTo()
    {
        return $this->belongsTo(LiveChatMessage::class, 'reply_to_message_id');
    }

    public function isImage(): bool
    {
        return $this->media_extension && in_array(strtolower($this->media_extension), self::IMAGE_EXTENSIONS);
    }
}