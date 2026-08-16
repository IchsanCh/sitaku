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
        // Ambil semua user dengan relasi pegawais + SEMUA api key (bukan cuma yang
        // aktif) -- versi yang lagi aktif difilter di PHP lewat User::activeApiKey(),
        // soalnya relasi yang constraint-nya gantung ke kolom user (active_api_version)
        // gak aman di-eager-load langsung (lihat komentar di User::activeApiKey()).
        // 'activePackage.tier.features' di-eager-load sekalian biar hasFeature() di
        // bawah gak nembak query baru per-user (N+1).
        $users = User::with([
            'pegawais:id,user_id,nama,no_hp,posisi',
            'apiKeys',
            'activePackage.tier.features',
        ])->get();

        // Filter: akun harus aktif (lolos verifikasi email) + langganan belum
        // kedaluwarsa + tier-nya punya akses fitur "api_access" (paket Basic gak
        // dapet integrasi otomatis) + minimal salah satu dari notif_pegawai/
        // notif_pemohon aktif. Kalau salah satu syarat gak kepenuhi, user gak
        // usah muncul di response sama sekali.
        $filteredUsers = $users->filter(function ($user) {
            $akunAktif = $user->status === 'active' &&
                Carbon::parse($user->subscription_expires_at)->isFuture();

            $adaAksesApi = $user->hasFeature('api_access');

            $adaNotifAktif = $user->notif_pegawai === 'aktif' || $user->notif_pemohon === 'aktif';

            return $akunAktif && $adaAksesApi && $adaNotifAktif;
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
            $apiKey = $user->activeApiKey();

            return [
                'id' => $user->id,
                'username' => $user->name,
                'unit_id' => $user->unit_id,
                'api_url' => $apiKey?->api_url,
                'version' => $apiKey?->version ?? $user->active_api_version,
                'fonnte_token' => $user->fonnte,
                'avera_token' => $apiKey?->bearer_token,
                'avera_apikey' => $apiKey?->apikey,
                'avera_key_uuid' => $apiKey?->key_uuid,
                'avera_salt_key' => $apiKey?->salt_key,
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