<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
    ];

    public function tiers(): BelongsToMany
    {
        return $this->belongsToMany(Tier::class, 'tier_feature')
            ->withPivot(['value', 'is_unlimited'])
            ->withTimestamps();
    }
}