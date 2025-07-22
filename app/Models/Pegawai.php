<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = ['nama', 'user_id', 'no_hp', 'posisi'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
