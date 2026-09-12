<?php

namespace App\Console\Commands;

use App\Models\LiveChat;
use App\Models\WhatsappSession;
use App\Services\FonnteService;
use App\Services\LiveChatService;
use Illuminate\Console\Command;

class EnforceLiveSupportTierLimits extends Command
{
    protected $signature = 'live-chat:enforce-tier-limits';

    protected $description = 'Tutup paksa room live chat yang instansinya udah gak eligible lagi (downgrade paket / subscription expired) -- pelengkap cutoff reaktif di webhook, buat kasus yang gak ada pesan masuk baru buat mancing pengecekan.';

    public function handle(LiveChatService $liveChatService, FonnteService $fonnte): int
    {
        $rooms = LiveChat::where('status', 'open')->with('user')->get();
        $cutoffCount = 0;

        foreach ($rooms as $liveChat) {
            $user = $liveChat->user;

            if (! $user) {
                continue; // data yatim, gak ada instansinya lagi -- skip aja
            }

            $eligible = $user->hasActiveSubscription() && $user->hasFeature('menu_action_live_support');

            if ($eligible) {
                continue;
            }

            $session = WhatsappSession::where('user_id', $user->id)
                ->where('nomor_wa', $liveChat->nomor_wa)
                ->first();
            $session?->resetToIdle();

            $liveChatService->closeRoom($liveChat);

            $fonnte->send(
                $user,
                $liveChat->nomor_wa,
                'Sesi live chat diakhiri otomatis karena layanan ini gak lagi tersedia buat instansi ini. Ketik "menu" buat lihat pilihan yang ada.'
            );

            $cutoffCount++;
        }

        if ($cutoffCount > 0) {
            $this->info("Nutup paksa {$cutoffCount} room live chat yang udah gak eligible lagi.");
        }

        return self::SUCCESS;
    }
}