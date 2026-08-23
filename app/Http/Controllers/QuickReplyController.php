<?php

namespace App\Http\Controllers;

use App\Models\QuickReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class QuickReplyController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();

        $quickReplies = QuickReply::where('user_id', $user->id)
            ->orderBy('trigger')
            ->get();

        return view('user.quick-replies.index', compact('quickReplies'));
    }

    public function create()
    {
        return view('user.quick-replies.form', [
            'quickReply' => new QuickReply(),
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('user')->user();
        $validated = $this->validateRequest($request, $user);

        QuickReply::create([
            'user_id' => $user->id,
            ...$validated,
        ]);

        return redirect()->route('quick-reply.index')->with('success', 'Balasan cepat berhasil ditambahkan.');
    }

    public function edit(QuickReply $quickReply)
    {
        $this->authorizeOwnership($quickReply);

        return view('user.quick-replies.form', compact('quickReply'));
    }

    public function update(Request $request, QuickReply $quickReply)
    {
        $user = Auth::guard('user')->user();
        $this->authorizeOwnership($quickReply);

        $validated = $this->validateRequest($request, $user, $quickReply);
        $quickReply->update($validated);

        return redirect()->route('quick-reply.index')->with('success', 'Balasan cepat berhasil diperbarui.');
    }

    public function destroy(QuickReply $quickReply)
    {
        $this->authorizeOwnership($quickReply);
        $quickReply->delete();

        return redirect()->route('quick-reply.index')->with('success', 'Balasan cepat berhasil dihapus.');
    }

    private function authorizeOwnership(QuickReply $quickReply): void
    {
        abort_unless($quickReply->user_id === Auth::guard('user')->id(), 404);
    }

    private function validateRequest(Request $request, $user, ?QuickReply $current = null): array
    {
        // Trigger disimpen tanpa "/" di depan -- itu murni penanda di sisi UI chat admin,
        // biar gak ambigu sama pesan biasa yang kebetulan diawali karakter yang sama.
        $data = $request->validate([
            'trigger' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z0-9_-]+$/',
                Rule::unique('quick_replies', 'trigger')
                    ->where('user_id', $user->id)
                    ->ignore($current?->id),
            ],
            'content' => 'required|string|max:2000',
        ], [
            'trigger.regex' => 'Trigger cuma boleh huruf kecil, angka, - dan _ (tanpa spasi/simbol lain).',
        ]);

        $data['trigger'] = strtolower($data['trigger']);

        return $data;
    }
}