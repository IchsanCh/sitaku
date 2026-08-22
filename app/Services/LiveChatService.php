<?php

namespace App\Services;

use App\Events\LiveChatMessageSent;
use App\Events\LiveChatRoomUpdated;
use App\Models\AdminSupport;
use App\Models\LiveChat;
use App\Models\LiveChatMessage;
use App\Models\User;

class LiveChatService
{
    public function __construct(private FonnteService $fonnte)
    {
    }

    /**
     * Buka (atau reuse kalau udah ada & masih 'open') room chat buat nomor ini.
     * Dipanggil pas pemohon/pegawai pilih menu action_type live_support.
     */
    public function openRoom(User $user, string $normalizedSender): LiveChat
    {
        $liveChat = LiveChat::firstOrNew([
            'user_id' => $user->id,
            'nomor_wa' => $normalizedSender,
        ]);

        $liveChat->status = 'open';
        $liveChat->last_message_at = now();
        $liveChat->save();

        return $liveChat;
    }

    public function handleIncomingPemohonMessage(LiveChat $liveChat, string $message): void
    {
        $chatMessage = LiveChatMessage::create([
            'live_chat_id' => $liveChat->id,
            'sender_type' => 'pemohon',
            'message' => $message,
        ]);

        $liveChat->update([
            'last_message_at' => now(),
            'unread_count' => $liveChat->unread_count + 1,
        ]);

        broadcast(new LiveChatMessageSent($chatMessage));
        broadcast(new LiveChatRoomUpdated($liveChat->user_id));
    }

    /**
     * Balasan dari admin support -- disimpen ke DB DAN dikirim beneran ke WA
     * lewat Fonnte, pakai token milik instansi (bukan token pribadi admin).
     */
    public function handleAdminReply(AdminSupport $agent, LiveChat $liveChat, string $message): bool
    {
        $sent = $this->fonnte->send($liveChat->user, $liveChat->nomor_wa, $message);

        $chatMessage = LiveChatMessage::create([
            'live_chat_id' => $liveChat->id,
            'sender_type' => 'admin_support',
            'admin_support_id' => $agent->id,
            'message' => $message,
        ]);

        $liveChat->update([
            'last_message_at' => now(),
            'unread_count' => 0,
            'replying_admin_id' => $agent->id,
            'replying_at' => now(),
        ]);

        broadcast(new LiveChatMessageSent($chatMessage));

        return $sent;
    }

    public function closeRoom(LiveChat $liveChat): void
    {
        $liveChat->update([
            'status' => 'closed',
            'replying_admin_id' => null,
            'replying_at' => null,
        ]);
    }
}