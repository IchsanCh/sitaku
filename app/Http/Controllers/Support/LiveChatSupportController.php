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
            ->with('latestMessage')
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('support.inbox', ['rooms' => $rooms, 'agent' => $agent]);
    }

    public function show(LiveChat $liveChat)
    {
        $agent = Auth::guard('support')->user();
        $this->authorizeRoom($liveChat, $agent);

        // Cuma load 30 pesan TERAKHIR di awal -- sisanya (kalau ada) di-fetch
        // belakangan lewat olderMessages() pas admin scroll ke atas. Room yang
        // udah punya ratusan/ribuan pesan gak bakal nge-query & ngerender semuanya
        // sekaligus pas halaman dibuka.
        $messages = $liveChat->messages()
            ->with('adminSupport', 'replyTo.adminSupport')
            ->latest()
            ->limit(30)
            ->get()
            ->reverse()
            ->values();

        $hasMoreMessages = $messages->isNotEmpty()
            && $liveChat->messages()->where('id', '<', $messages->first()->id)->exists();

        // Buka room ini dianggap "udah dibaca" -- reset badge unread.
        $liveChat->update(['unread_count' => 0]);

        $quickReplies = QuickReply::where('user_id', $agent->user_id)
            ->orderBy('trigger')
            ->get(['trigger', 'content']);

        return view('support.chat', [
            'liveChat' => $liveChat,
            'agent' => $agent,
            'quickReplies' => $quickReplies,
            'initialMessages' => $messages->map(fn ($m) => $this->formatMessage($m))->all(),
            'hasMoreMessages' => $hasMoreMessages,
        ]);
    }

    /**
     * Fetch 30 pesan lebih lama SEBELUM before_id -- dipanggil dari JS pas
     * admin scroll ke atas mendekati pesan paling lama yang lagi ke-load.
     */
    public function olderMessages(Request $request, LiveChat $liveChat)
    {
        $agent = Auth::guard('support')->user();
        $this->authorizeRoom($liveChat, $agent);

        $request->validate(['before_id' => 'required|integer']);
        $beforeId = (int) $request->query('before_id');

        $messages = $liveChat->messages()
            ->with('adminSupport', 'replyTo.adminSupport')
            ->where('id', '<', $beforeId)
            ->latest()
            ->limit(30)
            ->get()
            ->reverse()
            ->values();

        $hasMore = $messages->isNotEmpty()
            && $liveChat->messages()->where('id', '<', $messages->first()->id)->exists();

        return response()->json([
            'data' => $messages->map(fn ($m) => $this->formatMessage($m))->all(),
            'has_more' => $hasMore,
        ]);
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
                'excerpt' => $msg->replyTo->excerpt(),
            ] : null,
        ];
    }
}