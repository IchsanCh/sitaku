<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use App\Models\QuickReply;
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

        $liveChat->load('messages.adminSupport');

        // Buka room ini dianggap "udah dibaca" -- reset badge unread.
        $liveChat->update(['unread_count' => 0]);

        $quickReplies = QuickReply::where('user_id', $agent->user_id)
            ->orderBy('trigger')
            ->get(['trigger', 'content']);

        return view('support.chat', ['liveChat' => $liveChat, 'agent' => $agent, 'quickReplies' => $quickReplies]);
    }

    public function reply(Request $request, LiveChat $liveChat, LiveChatService $liveChatService)
    {
        $agent = Auth::guard('support')->user();
        $this->authorizeRoom($liveChat, $agent);

        $request->validate([
            'message' => 'required_without:media|nullable|string|max:2000',
            'media' => 'nullable|file|max:10240', // 10MB, samain kira-kira sama limit Fonnte
        ]);

        $sent = $liveChatService->handleAdminReply(
            $agent,
            $liveChat,
            (string) $request->input('message', ''),
            $request->file('media'),
        );

        $latest = $liveChat->messages()->latest()->first();

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
        ];
    }
}