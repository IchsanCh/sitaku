<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pemohon;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = ['pemohon_id', 'user_id', 'pesan', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Pemohon
    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class);
    }
}
