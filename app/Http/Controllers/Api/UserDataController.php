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
        // Ambil semua user dengan relasi pegawais
        $users = User::with(['pegawais:id,user_id,nama,no_hp,posisi'])->get();

        // Filter hanya user yang aktif dan langganannya belum kedaluwarsa
        $filteredUsers = $users->filter(function ($user) {
            return $user->status === 'active' &&
                Carbon::parse($user->subscription_expires_at)->isFuture();
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
                'unit_id' => $user->unit_id,
                'api_url' => $user->api_url,
                'fonnte_token' => $user->fonnte,
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
