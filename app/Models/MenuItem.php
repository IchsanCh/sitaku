<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $audience
 * @property int|null $parent_id
 * @property string $trigger
 * @property string $label
 * @property string $action_type
 * @property array|null $action_config
 * @property int $sort_order
 * @property bool $is_active
 * @property bool $is_default
 */
class MenuItem extends Model
{
    protected $fillable = [
        'user_id',
        'audience',
        'parent_id',
        'trigger',
        'label',
        'action_type',
        'action_config',
        'sort_order',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'action_config' => 'array',
        'is_active' => 'boolean',
    ];

    // Action type yang tersedia di base tier (Standard/Premium ke atas, asal
    // punya feature 'menu_builder'). Gak butuh feature check tambahan.
    public const BASE_ACTIONS = ['cek_status', 'riwayat_tahapan', 'antrian_pegawai', 'info_pegawai', 'exit'];

    // Action type yang baru kebuka kalau tier punya feature spesifik ini.
    // Key = action_type, value = slug feature yang di-cek lewat hasFeature().
    public const PREMIUM_ACTIONS = [
        'pesan_custom' => 'menu_action_pesan_custom',
        'submenu' => 'menu_action_submenu',
        'live_support' => 'menu_action_live_support',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->orderBy('sort_order');
    }
}