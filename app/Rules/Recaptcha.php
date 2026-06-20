<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Closure;

class Recaptcha implements ValidationRule
{
    /**
     * Skor minimum reCAPTCHA v3 agar dianggap lolos (0.0 - 1.0).
     * Default Google: 0.5
     */
    protected float $minScore = 0.6;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secretKey = config('services.recaptcha.secret_key');

        // Kalau secret key belum diset (misal saat development), skip validasi
        // biar gak ngeblok kalau lupa konfigurasi.
        if (empty($secretKey)) {
            Log::warning('RECAPTCHA_SECRET_KEY belum diset di .env, validasi reCAPTCHA dilewati.');
            return;
        }

        if (empty($value)) {
            $fail('Verifikasi reCAPTCHA gagal. Silakan muat ulang halaman dan coba lagi.');
            return;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secretKey,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!($result['success'] ?? false)) {
                $fail('Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
                return;
            }

            $score = $result['score'] ?? 0;

            if ($score < $this->minScore) {
                $fail('Aktivitas mencurigakan terdeteksi. Silakan coba lagi.');
                return;
            }
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA verification error: ' . $e->getMessage());
            $fail('Gagal memverifikasi reCAPTCHA. Silakan coba lagi nanti.');
        }
    }
}
