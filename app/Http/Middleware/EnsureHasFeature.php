<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasFeature
{
    /**
     * Block route kalau tier aktif user gak punya fitur (toggle) ini nyala.
     * Pasang di route pakai alias 'feature:<slug>', misal:
     *   Route::middleware('feature:custom_pesan')->group(...)
     *
     * Ini pengecekan SERVER-SIDE -- tetep jalan walau tombol/link di UI
     * udah di-disable/dikunci di sisi Blade/JS (itu cuma UX, bukan security).
     */
    public function handle(Request $request, Closure $next, string $slug): Response
    {
        $user = Auth::guard('user')->user();

        if (! $user || ! $user->hasFeature($slug)) {
            return redirect()->route('user.billing')
                ->with('error', 'Fitur ini tidak tersedia di paket Anda saat ini. Silakan upgrade paket untuk mengaksesnya.');
        }

        return $next($request);
    }
}