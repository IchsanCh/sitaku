<?php

namespace App\Models;

use App\Models\User;
use App\Models\Package;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'package_id',
        'status',
        'total',
        'start_date',
        'end_date',
        'payment_token',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
