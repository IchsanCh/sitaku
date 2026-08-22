<?php

namespace App\Http\Controllers;

use App\Models\LiveChat;
use App\Models\User;
use App\Models\WhatsappSession;
use App\Services\FonnteService;
use App\Services\LiveChatService;
use App\Services\WhatsappStateMachineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FonnteWebhookController extends Controller
{
    public function handle(
        Request $request,
        string $token,
        WhatsappStateMachineService $stateMachine,
        LiveChatService $liveChatService,
        FonnteService $fonnte
    ) {
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

        $normalizedSender = $stateMachine->normalizePhone((string) $sender);

        $session = WhatsappSession::where('user_id', $user->id)
            ->where('nomor_wa', $normalizedSender)
            ->first();

        // Lagi mode live support -- JANGAN lewat state machine/bot sama sekali,
        // langsung ke room chat. Exit keyword tetap dicek biar pemohon bisa
        // keluar dari live chat kapan aja, pakai kata kunci yang sama kayak bot.
        if ($session && $session->current_state === 'live_support') {
            if ($stateMachine->isExitCommand((string) $message)) {
                $session->resetToIdle();

                $liveChat = LiveChat::where('user_id', $user->id)
                    ->where('nomor_wa', $normalizedSender)
                    ->where('status', 'open')
                    ->first();

                if ($liveChat) {
                    $liveChatService->closeRoom($liveChat);
                }

                $fonnte->send($user, $normalizedSender, 'Sesi live chat diakhiri. Ketik "menu" kapan aja buat mulai lagi.');
            } else {
                $liveChat = LiveChat::firstOrCreate(
                    ['user_id' => $user->id, 'nomor_wa' => $normalizedSender],
                    ['status' => 'open']
                );
                $liveChatService->handleIncomingPemohonMessage($liveChat, (string) $message);
            }

            return response()->json(['status' => 'ok'], 200);
        }

        // Diproses sync dulu (MVP) -- kalau volume udah gede & mulai kerasa lambat,
        // ini kandidat pertama buat dipindah ke queue job.
        $stateMachine->handle($user, (string) $sender, (string) $message);

        return response()->json(['status' => 'ok'], 200);
    }
}