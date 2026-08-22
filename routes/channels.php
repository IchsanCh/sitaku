<?php

use App\Models\LiveChat;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Auth di sini jalan lewat guard 'support' (di-set global di bootstrap/app.php
| ->withBroadcasting(..., ['middleware' => ['auth:support']])), jadi $agent
| di bawah ini otomatis instance AdminSupport, bukan User biasa.
|
*/

Broadcast::channel('live-chat.{liveChatId}', function ($agent, int $liveChatId) {
    $liveChat = LiveChat::find($liveChatId);

    if (! $liveChat) {
        return false;
    }

    // Cuma admin support yang instansinya (user_id) sama yang boleh denger
    // channel room ini -- gak peduli siapa yang lagi "replying", semua admin
    // di instansi yang sama boleh gabung (shared inbox).
    return $liveChat->user_id === $agent->user_id;
});

// Channel per-instansi buat notifikasi ringan (misal: ada room baru masuk,
// biar inbox list ke-refresh) -- semua admin support di instansi itu subscribe.
Broadcast::channel('instansi.{userId}.live-chats', function ($agent, int $userId) {
    return $agent->user_id === $userId;
});