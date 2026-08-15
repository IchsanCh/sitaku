<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiKey extends Model
{
    protected $fillable = [
        'user_id',
        'api_url',
        'bearer_token',
        'apikey',
        'key_uuid',
        'salt_key',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}