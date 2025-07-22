<?php

namespace App\Models;

use App\Models\Pesan;
use Illuminate\Database\Eloquent\Model;

class Pemohon extends Model
{
    protected $fillable = ['external_id', 'user_id', 'nama', 'no_permohonan', 'nama_izin', 'tahapan', 'status', 'payload_hash', 'created_at', 'last_notified_tahapan', 'notified_at', 'updated_at'];

    public function pesan()
    {
        return $this->hasMany(Pesan::class);
    }
}
