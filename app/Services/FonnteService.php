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
     *
     * $options (semua opsional):
     * - url: string -- kirim media lewat link yang udah publicly accessible
     * - file: ['contents' => binary, 'filename' => string] -- upload langsung (multipart),
     *   gak butuh file-nya publicly accessible duluan
     * - filename: string -- nama file custom (dipasangin kalau pake 'url')
     * - inboxid: string -- quote/reply ke pesan masuk tertentu (butuh fitur inbox aktif
     *   di dashboard Fonnte)
     */
    public function send(User $user, string $target, string $message, array $options = []): bool
    {
        if (empty($user->fonnte)) {
            Log::warning("[FonnteService] user_id={$user->id} belum punya token Fonnte, skip kirim.");
            return false;
        }

        try {
            $payload = [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62',
            ];

            if (! empty($options['url'])) {
                $payload['url'] = $options['url'];
            }
            if (! empty($options['filename'])) {
                $payload['filename'] = $options['filename'];
            }
            if (! empty($options['inboxid'])) {
                $payload['inboxid'] = $options['inboxid'];
            }

            $request = Http::withHeaders(['Authorization' => $user->fonnte])->timeout(30);

            if (! empty($options['file'])) {
                // Upload langsung (multipart) -- gak bisa asForm() bareng attach().
                $response = $request->attach(
                    'file',
                    $options['file']['contents'],
                    $options['file']['filename']
                )->post(self::SEND_URL, $payload);
            } else {
                $response = $request->asForm()->post(self::SEND_URL, $payload);
            }

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