<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WhatsappStateMachineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FonnteWebhookController extends Controller
{
    public function handle(Request $request, string $token, WhatsappStateMachineService $stateMachine)
    {
        $user = User::where('webhook_token', $token)->first();

        if (! $user) {
            // Sengaja balikin 404 generik -- jangan kasih tau token ini valid/nggak
            // biar gak jadi celah enumerasi token orang lain.
            abort(404);
        }

        // Payload Fonnte -- nama field bisa aja beda dikit tergantung versi/setting
        // device-nya, makanya di-log dulu mentahnya biar gampang di-cross check pas
        // testing pertama kali. Sesuaikan key di bawah kalau ternyata beda.
        Log::info("[FonnteWebhook] user_id={$user->id} payload: " . $request->getContent());

        $sender = $request->input('sender') ?? $request->input('from') ?? $request->input('phone');
        $message = $request->input('message') ?? $request->input('text') ?? $request->input('body');

        if (! $sender || $message === null || $message === '') {
            Log::warning("[FonnteWebhook] user_id={$user->id} payload gak punya sender/message yang dikenali, di-skip.");
            return response()->json(['status' => 'ignored'], 200);
        }

        // Diproses sync dulu (MVP) -- kalau volume udah gede & mulai kerasa lambat,
        // ini kandidat pertama buat dipindah ke queue job.
        $stateMachine->handle($user, (string) $sender, (string) $message);

        return response()->json(['status' => 'ok'], 200);
    }
}