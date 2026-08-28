<?php

namespace App\Services;

use App\Events\LiveChatMessageSent;
use App\Events\LiveChatRoomUpdated;
use App\Models\AdminSupport;
use App\Models\LiveChat;
use App\Models\LiveChatMessage;
use App\Models\User;
use App\Models\WhatsappSession;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    /**
     * $mediaUrl/$mediaFilename/$mediaExtension: field attachment dari payload webhook Fonnte
     * (cuma ada kalau device-nya paket "all feature" & pesannya emang ada lampirannya).
     * $fonnteInboxId: field `inboxid` dari payload -- disimpen biar bisa dipake admin buat
     * quote/reply ke pesan spesifik ini nanti.
     */
    public function handleIncomingPemohonMessage(
        LiveChat $liveChat,
        string $message,
        ?string $mediaUrl = null,
        ?string $mediaFilename = null,
        ?string $mediaExtension = null,
        ?string $fonnteInboxId = null,
    ): void {
        $chatMessage = LiveChatMessage::create([
            'live_chat_id' => $liveChat->id,
            'sender_type' => 'pemohon',
            'message' => $message,
            'media_url' => $mediaUrl,
            'media_filename' => $mediaFilename,
            'media_extension' => $mediaExtension,
            'fonnte_inbox_id' => $fonnteInboxId,
        ]);

        $liveChat->update([
            'last_message_at' => now(),
            'unread_count' => $liveChat->unread_count + 1,
        ]);

        broadcast(new LiveChatMessageSent($chatMessage));
        broadcast(new LiveChatRoomUpdated($liveChat));
    }

    /**
     * Balasan dari admin support -- disimpen ke DB DAN dikirim beneran ke WA
     * lewat Fonnte, pakai token milik instansi (bukan token pribadi admin).
     *
     * $media: file upload dari admin (opsional) -- disimpen ke storage publik kita sendiri
     * (beda kebijakan sama attachment masuk, karena di sini kita emang pegang byte-nya
     * langsung, bukan nge-download ulang dari URL luar).
     * $replyTo: pesan yang di-quote (opsional, dari gesture swipe). Kalau pesan yang
     * di-quote itu punya fonnte_inbox_id (artinya dari pemohon), kita pass ke Fonnte biar
     * WA-nya nampilin bubble reply beneran. Quote ke pesan admin lain cuma keliatan di UI
     * kita aja, gak ke WA-nya (keterbatasan API Fonnte).
     */
    public function handleAdminReply(
        AdminSupport $agent,
        LiveChat $liveChat,
        string $message,
        ?UploadedFile $media = null,
        ?LiveChatMessage $replyTo = null,
    ): bool {
        $mediaUrl = null;
        $mediaFilename = null;
        $mediaExtension = null;
        $sendOptions = [];

        if ($media) {
            $mediaFilename = $media->getClientOriginalName();
            $mediaExtension = strtolower($media->getClientOriginalExtension());
            $path = $media->store('live-chat-media', 'public');
            $mediaUrl = Storage::disk('public')->url($path);

            $sendOptions['file'] = [
                'contents' => file_get_contents($media->getRealPath()),
                'filename' => $mediaFilename,
            ];
            $sendOptions['filename'] = $mediaFilename;
        }

        if ($replyTo?->fonnte_inbox_id) {
            $sendOptions['inboxid'] = $replyTo->fonnte_inbox_id;
        }

        $sent = $this->fonnte->send($liveChat->user, $liveChat->nomor_wa, $message, $sendOptions);

        $chatMessage = LiveChatMessage::create([
            'live_chat_id' => $liveChat->id,
            'sender_type' => 'admin_support',
            'admin_support_id' => $agent->id,
            'message' => $message,
            'media_url' => $mediaUrl,
            'media_filename' => $mediaFilename,
            'media_extension' => $mediaExtension,
            'reply_to_message_id' => $replyTo?->id,
        ]);

        $liveChat->update([
            'last_message_at' => now(),
            'unread_count' => 0,
            'replying_admin_id' => $agent->id,
            'replying_at' => now(),
        ]);

        broadcast(new LiveChatMessageSent($chatMessage));
        broadcast(new LiveChatRoomUpdated($liveChat));

        return $sent;
    }

    public function closeRoom(LiveChat $liveChat): void
    {
        $liveChat->update([
            'status' => 'closed',
            'replying_admin_id' => null,
            'replying_at' => null,
        ]);

        // Biar inbox admin lain langsung keliatan room ini "Selesai" tanpa reload.
        broadcast(new LiveChatRoomUpdated($liveChat));
    }

    /**
     * Dipicu admin dari tombol "Akhiri Sesi" di halaman chat -- beda sama
     * exit command dari pemohon sendiri (FonnteWebhookController), tapi
     * hasil akhirnya sama: state machine balik idle & room ditutup.
     */
    public function endSessionByAdmin(LiveChat $liveChat): bool
    {
        WhatsappSession::where('user_id', $liveChat->user_id)
            ->where('nomor_wa', $liveChat->nomor_wa)
            ->first()
            ?->resetToIdle();

        $this->closeRoom($liveChat);

        return $this->fonnte->send(
            $liveChat->user,
            $liveChat->nomor_wa,
            'Sesi live chat diakhiri oleh admin. Ketik "menu" kapan aja buat mulai lagi.'
        );
    }
}