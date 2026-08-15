<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UserDataController extends Controller
{
    public function index()
    {
        // Ambil semua user dengan relasi pegawais + api key yang lagi aktif
        // (ditentukan dari users.active_api_version, lihat User::activeApiKey()).
        $users = User::with(['pegawais:id,user_id,nama,no_hp,posisi', 'activeApiKey'])->get();

        // Filter: akun harus aktif (lolos verifikasi email) + langganan belum
        // kedaluwarsa + minimal salah satu dari notif_pegawai/notif_pemohon aktif.
        // Kalau dua-duanya nonaktif, user gak usah muncul di response sama sekali
        // -- gak ada gunanya buat cron kalau emang gak ada notif yang mau dikirim.
        $filteredUsers = $users->filter(function ($user) {
            $akunAktif = $user->status === 'active' &&
                Carbon::parse($user->subscription_expires_at)->isFuture();

            $adaNotifAktif = $user->notif_pegawai === 'aktif' || $user->notif_pemohon === 'aktif';

            return $akunAktif && $adaNotifAktif;
        });

        // Jika tidak ada user yang valid
        if ($filteredUsers->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada user aktif atau langganan sudah kedaluwarsa.',
                'data' => [],
            ], 404);
        }

        // Format data
        $data = $filteredUsers->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->name,
                'unit_id' => $user->unit_id,
                'api_url' => $user->activeApiKey?->api_url,
                'version' => $user->activeApiKey?->version ?? $user->active_api_version,
                'fonnte_token' => $user->fonnte,
                'avera_token' => $user->activeApiKey?->bearer_token,
                'avera_apikey' => $user->activeApiKey?->apikey,
                'avera_key_uuid' => $user->activeApiKey?->key_uuid,
                'avera_salt_key' => $user->activeApiKey?->salt_key,
                'notif_pegawai' => $user->notif_pegawai,
                'notif_pemohon' => $user->notif_pemohon,
                'pesan_pemohon' => str_replace('\\n', "\n", $user->pesan_pemohon),
                'pesan_penyerahan' => str_replace('\\n', "\n", $user->pesan_penyerahan),
                'pesan_pegawai' => str_replace('\\n', "\n", $user->pesan_pegawai),
                'pegawais' => $user->pegawais->map(function ($pegawai) {
                    return [
                        'nama' => $pegawai->nama,
                        'no_hp' => $pegawai->no_hp,
                        'posisi' => $pegawai->posisi,
                    ];
                })->values(),
            ];
        })->values();

        // Response sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Data user berhasil diambil.',
            'data' => $data,
        ], 200);
    }
}