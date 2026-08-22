<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $live_chat_id
 * @property string $sender_type
 * @property int|null $admin_support_id
 * @property string $message
 * @property string|null $fonnte_message_id
 */
class LiveChatMessage extends Model
{
    protected $fillable = [
        'live_chat_id',
        'sender_type',
        'admin_support_id',
        'message',
        'fonnte_message_id',
    ];

    public function liveChat()
    {
        return $this->belongsTo(LiveChat::class);
    }

    public function adminSupport()
    {
        return $this->belongsTo(AdminSupport::class);
    }
}