<?php

namespace App\Models;

use App\Models\Subscription;
use App\Models\Tier;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['tier_id', 'name', 'description', 'price', 'duration_days', 'visible'];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }
}