<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifPegawai extends Model
{
    protected $fillable = ['user_id', 'nomor_hp', 'nama', 'posisi', 'pesan'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
