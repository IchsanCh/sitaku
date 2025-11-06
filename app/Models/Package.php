<?php

namespace App\Models;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['name', 'description', 'price', 'duration_days', 'visible'];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
