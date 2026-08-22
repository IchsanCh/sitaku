@extends('support.layout')

@section('title', 'Chat ' . $liveChat->nomor_wa . ' - Support Panel')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <a href="{{ route('support.inbox') }}" class="btn btn-ghost btn-sm mb-4">← Kembali ke Inbox</a>

    <div class="card bg-base-100 shadow-xl border border-base-300">
        <div class="card-body p-0">
            <div class="p-4 border-b border-base-300 flex items-center justify-between">
                <div>
                    <h1 class="font-bold">{{ $liveChat->nomor_wa }}</h1>
                    <span class="badge badge-sm {{ $liveChat->status === 'open' ? 'badge-success' : 'badge-ghost' }}">
                        {{ $liveChat->status === 'open' ? 'Aktif' : 'Selesai' }}
                    </span>
                </div>
            </div>

            <div id="messageList" class="p-4 space-y-3 overflow-y-auto" style="height: 60vh;">
                @foreach ($liveChat->messages as $msg)
                    <div class="flex {{ $msg->sender_type === 'admin_support' ? 'justify-end' : 'justify-start' }}" data-msg-id="{{ $msg->id }}">
                        <div class="max-w-[75%]">
                            <div class="rounded-2xl px-4 py-2 text-sm {{ $msg->sender_type === 'admin_support' ? 'bg-primary text-primary-content rounded-br-md' : 'bg-base-200 rounded-bl-md' }}">
                                {{ $msg->message }}
                            </div>
                            <div class="text-xs text-base-content/40 mt-1 {{ $msg->sender_type === 'admin_support' ? 'text-right' : 'text-left' }}">
                                {{ $msg->sender_type === 'admin_support' ? ($msg->adminSupport?->name ?? 'Admin') : $liveChat->nomor_wa }}
                                · {{ $msg->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <form id="replyForm" class="p-4 border-t border-base-300 flex gap-2">
                @csrf
                <input type="text" name="message" id="messageInput" class="input input-bordered flex-1"
                    placeholder="Tulis balasan..." autocomplete="off" required maxlength="2000">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const liveChatId = {{ $liveChat->id }};
    const messageList = document.getElementById('messageList');
    const replyForm = document.getElementById('replyForm');
    const messageInput = document.getElementById('messageInput');
    const seenIds = new Set([...document.querySelectorAll('[data-msg-id]')].map(el => el.dataset.msgId));

    function scrollToBottom() {
        messageList.scrollTop = messageList.scrollHeight;
    }
    scrollToBottom();

    function appendMessage(data) {
        if (seenIds.has(String(data.id))) return;
        seenIds.add(String(data.id));

        const isAdmin = data.sender_type === 'admin_support';
        const wrap = document.createElement('div');
        wrap.className = `flex ${isAdmin ? 'justify-end' : 'justify-start'}`;
        wrap.dataset.msgId = data.id;

        const time = new Date(data.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        const senderLabel = isAdmin ? (data.admin_support_name || 'Admin') : '{{ $liveChat->nomor_wa }}';

        wrap.innerHTML = `
            <div class="max-w-[75%]">
                <div class="rounded-2xl px-4 py-2 text-sm ${isAdmin ? 'bg-primary text-primary-content rounded-br-md' : 'bg-base-200 rounded-bl-md'}">
                    ${data.message.replace(/</g, '&lt;')}
                </div>
                <div class="text-xs text-base-content/40 mt-1 ${isAdmin ? 'text-right' : 'text-left'}">
                    ${senderLabel} · ${time}
                </div>
            </div>
        `;
        messageList.appendChild(wrap);
        scrollToBottom();
    }

    const pusher = new Pusher('{{ config('broadcasting.connections.reverb.key') }}', {
        wsHost: '{{ config('broadcasting.connections.reverb.options.host') }}',
        wsPort: {{ config('broadcasting.connections.reverb.options.port') }},
        wssPort: {{ config('broadcasting.connections.reverb.options.port') }},
        forceTLS: {{ config('broadcasting.connections.reverb.options.useTLS') ? 'true' : 'false' }},
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        auth: { headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }
    });

    const channel = pusher.subscribe('private-live-chat.' + liveChatId);
    channel.bind('message.sent', function (data) {
        appendMessage(data);
    });

    replyForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        const submitBtn = replyForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;

        try {
            const res = await fetch(`/support/chat/${liveChatId}/reply`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message }),
            });

            if (!res.ok) {
                const body = await res.json().catch(() => ({}));
                showToast('error', body.message || 'Gagal kirim pesan.');
                return;
            }

            const body = await res.json();
            appendMessage(body.data);
            messageInput.value = '';

            if (body.fonnte_sent === false) {
                showToast('error', 'Pesan tersimpan, tapi gagal terkirim ke WhatsApp. Cek token Fonnte instansi.');
            }
        } catch (err) {
            showToast('error', 'Gagal kirim pesan: ' + err.message);
        } finally {
            submitBtn.disabled = false;
            messageInput.focus();
        }
    });
</script>
@endsection