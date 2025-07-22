<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserTokenDataController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->get('authenticated_user');

        $formattedDate = $user->subscription_expires_at
            ? $user->subscription_expires_at->locale('id')->translatedFormat('d F Y H:i')
            : null;

        $pegawais = $user->pegawais()->get(['id', 'nama', 'no_hp', 'posisi']);

        return response()->json([
            'status' => 'success',
            'message' => 'Data user berhasil diambil.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'unit_id' => $user->unit_id,
                'api_url' => $user->api_url,
                'status' => $user->status,
                'subscription_expires_at' => $formattedDate,
                'pegawais' => $pegawais,
            ],
        ]);
    }
}
