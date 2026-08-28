<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $nomor_wa
 * @property string $status
 * @property int|null $replying_admin_id
 * @property \Illuminate\Support\Carbon|null $replying_at
 * @property \Illuminate\Support\Carbon|null $last_message_at
 * @property int $unread_count
 */
class LiveChat extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_wa',
        'status',
        'replying_admin_id',
        'replying_at',
        'last_message_at',
        'unread_count',
    ];

    protected $casts = [
        'replying_at' => 'datetime',
        'last_message_at' => 'datetime',
    ];

    // Indikator "lagi dibales" dianggap basi kalau lebih dari ini -- admin lain
    // boleh anggap kosong lagi (misal yang bales lupa nutup tab).
    private const REPLYING_STALE_MINUTES = 3;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replyingAdmin()
    {
        return $this->belongsTo(AdminSupport::class, 'replying_admin_id');
    }

    public function messages()
    {
        return $this->hasMany(LiveChatMessage::class)->orderBy('created_at');
    }

    // Buat preview "pesan terakhir" di inbox -- 1 query per halaman (bukan
    // N+1) selama dipanggil lewat ->with('latestMessage') di controller.
    public function latestMessage()
    {
        return $this->hasOne(LiveChatMessage::class)->latestOfMany();
    }

    public function isBeingRepliedByOther(?int $currentAdminId): bool
    {
        if (! $this->replying_admin_id || $this->replying_admin_id === $currentAdminId) {
            return false;
        }

        return $this->replying_at && $this->replying_at->gt(now()->subMinutes(self::REPLYING_STALE_MINUTES));
    }
}