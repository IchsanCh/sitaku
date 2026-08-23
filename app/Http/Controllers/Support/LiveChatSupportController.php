<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use App\Services\LiveChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveChatSupportController extends Controller
{
    public function index()
    {
        $agent = Auth::guard('support')->user();

        $rooms = LiveChat::where('user_id', $agent->user_id)
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('support.inbox', ['rooms' => $rooms, 'agent' => $agent]);
    }

    public function show(LiveChat $liveChat)
    {
        $agent = Auth::guard('support')->user();
        $this->authorizeRoom($liveChat, $agent);

        $liveChat->load('messages.adminSupport', 'messages.replyTo.adminSupport');

        // Buka room ini dianggap "udah dibaca" -- reset badge unread.
        $liveChat->update(['unread_count' => 0]);

        return view('support.chat', ['liveChat' => $liveChat, 'agent' => $agent]);
    }

    public function reply(Request $request, LiveChat $liveChat, LiveChatService $liveChatService)
    {
        $agent = Auth::guard('support')->user();
        $this->authorizeRoom($liveChat, $agent);

        $request->validate([
            'message' => 'required_without:media|nullable|string|max:2000',
            'media' => 'nullable|file|max:10240', // 10MB, samain kira-kira sama limit Fonnte
            'reply_to_message_id' => 'nullable|integer|exists:live_chat_messages,id',
        ]);

        $replyTo = null;
        if ($request->filled('reply_to_message_id')) {
            $replyTo = $liveChat->messages()->find($request->input('reply_to_message_id'));
        }

        $sent = $liveChatService->handleAdminReply(
            $agent,
            $liveChat,
            (string) $request->input('message', ''),
            $request->file('media'),
            $replyTo,
        );

        $latest = $liveChat->messages()->with('replyTo.adminSupport')->latest()->first();

        return response()->json([
            'data' => $this->formatMessage($latest, $agent->name),
            'fonnte_sent' => $sent,
        ]);
    }

    public function endSession(LiveChat $liveChat, LiveChatService $liveChatService)
    {
        $agent = Auth::guard('support')->user();
        $this->authorizeRoom($liveChat, $agent);

        if ($liveChat->status !== 'open') {
            return response()->json(['message' => 'Room ini udah gak aktif.'], 422);
        }

        $sent = $liveChatService->endSessionByAdmin($liveChat);

        return response()->json(['fonnte_sent' => $sent]);
    }

    private function authorizeRoom(LiveChat $liveChat, $agent): void
    {
        abort_unless($liveChat->user_id === $agent->user_id, 404);
    }

    private function formatMessage($msg, ?string $adminName = null): array
    {
        return [
            'id' => $msg->id,
            'sender_type' => $msg->sender_type,
            'admin_support_name' => $adminName ?? $msg->adminSupport?->name,
            'message' => $msg->message,
            'media_url' => $msg->media_url,
            'media_filename' => $msg->media_filename,
            'media_extension' => $msg->media_extension,
            'is_image' => $msg->isImage(),
            'created_at' => $msg->created_at->toIso8601String(),
            'reply_to' => $msg->replyTo ? [
                'id' => $msg->replyTo->id,
                'sender_type' => $msg->replyTo->sender_type,
                'admin_support_name' => $msg->replyTo->adminSupport?->name,
                'excerpt' => $msg->replyTo->message ?: ($msg->replyTo->media_filename ? '📎 ' . $msg->replyTo->media_filename : '[Media]'),
            ] : null,
        ];
    }
}