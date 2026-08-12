<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tier extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'tier_feature')
            ->withPivot(['value', 'is_unlimited'])
            ->withTimestamps();
    }

    /**
     * Cek apakah tier ini punya fitur (toggle) nyala, ATAU punya fitur (limit)
     * yang di-attach (terlepas dari nilainya). Berguna buat guard sederhana:
     * if (!$tier->hasFeature('api_access')) abort(403);
     */
    public function hasFeature(string $slug): bool
    {
        $pivot = $this->features()->where('slug', $slug)->first()?->pivot;

        if (! $pivot) {
            return false;
        }

        if ($pivot->is_unlimited) {
            return true;
        }

        return (bool) $pivot->value;
    }

    /**
     * Ambil limit angka buat feature bertipe `limit`.
     * Return null kalau unlimited, atau kalau fitur ga di-attach ke tier ini
     * (artinya default-nya 0 / ga eksplisit diizinkan — dicek eksplisit di sisi caller).
     */
    public function featureLimit(string $slug): ?int
    {
        $pivot = $this->features()->where('slug', $slug)->first()?->pivot;

        if (! $pivot || $pivot->is_unlimited) {
            return $pivot?->is_unlimited ? null : 0;
        }

        return (int) $pivot->value;
    }
}