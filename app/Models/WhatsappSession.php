<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $nomor_wa
 * @property string $current_state
 * @property int|null $current_menu_id
 * @property array|null $context_data
 * @property \Illuminate\Support\Carbon|null $state_expires_at
 */
class WhatsappSession extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_wa',
        'current_state',
        'current_menu_id',
        'context_data',
        'state_expires_at',
    ];

    protected $casts = [
        'context_data' => 'array',
        'state_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentMenu()
    {
        return $this->belongsTo(MenuItem::class, 'current_menu_id');
    }

    /**
     * Buang balik ke idle -- state, context, dan posisi menu direset total.
     * Dipanggil pas exit command, atau pas state_expires_at kelewat.
     */
    public function resetToIdle(): void
    {
        $this->update([
            'current_state' => 'idle',
            'current_menu_id' => null,
            'context_data' => null,
            'state_expires_at' => null,
        ]);
    }

    public function isExpired(): bool
    {
        return $this->state_expires_at !== null && $this->state_expires_at->isPast();
    }
}