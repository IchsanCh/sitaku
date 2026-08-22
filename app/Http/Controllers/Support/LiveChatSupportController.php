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

        $liveChat->load('messages.adminSupport');

        // Buka room ini dianggap "udah dibaca" -- reset badge unread.
        $liveChat->update(['unread_count' => 0]);

        return view('support.chat', ['liveChat' => $liveChat, 'agent' => $agent]);
    }

    public function reply(Request $request, LiveChat $liveChat, LiveChatService $liveChatService)
    {
        $agent = Auth::guard('support')->user();
        $this->authorizeRoom($liveChat, $agent);

        $request->validate(['message' => 'required|string|max:2000']);

        $sent = $liveChatService->handleAdminReply($agent, $liveChat, $request->input('message'));

        $latest = $liveChat->messages()->latest()->first();

        return response()->json([
            'data' => [
                'id' => $latest->id,
                'sender_type' => $latest->sender_type,
                'admin_support_name' => $agent->name,
                'message' => $latest->message,
                'created_at' => $latest->created_at->toIso8601String(),
            ],
            'fonnte_sent' => $sent,
        ]);
    }

    private function authorizeRoom(LiveChat $liveChat, $agent): void
    {
        abort_unless($liveChat->user_id === $agent->user_id, 404);
    }
}