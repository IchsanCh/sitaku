<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    private const SEND_URL = 'https://api.fonnte.com/send';

    /**
     * Kirim pesan WA lewat device Fonnte milik $user (pakai token di kolom users.fonnte).
     * Return true kalau Fonnte konfirmasi terkirim, false kalau gagal (network/token salah/dll).
     * Gagal kirim TIDAK melempar exception -- caller (state machine) tetap lanjut proses
     * session-nya, cuma balasannya aja yang gak nyampe.
     */
    public function send(User $user, string $target, string $message): bool
    {
        if (empty($user->fonnte)) {
            Log::warning("[FonnteService] user_id={$user->id} belum punya token Fonnte, skip kirim.");
            return false;
        }

        try {
            $response = Http::withHeaders(['Authorization' => $user->fonnte])
                ->timeout(15)
                ->asForm()
                ->post(self::SEND_URL, [
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => '62',
                ]);

            $ok = $response->successful() && data_get($response->json(), 'status') == true;

            if (! $ok) {
                Log::warning("[FonnteService] gagal kirim ke {$target} (user_id={$user->id}): " . $response->body());
            }

            return $ok;
        } catch (\Throwable $e) {
            Log::error("[FonnteService] exception kirim ke {$target} (user_id={$user->id}): " . $e->getMessage());
            return false;
        }
    }
}