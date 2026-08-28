@extends('support.layout')

@section('title', 'Chat ' . $liveChat->nomor_wa . ' - Support Panel')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <a href="{{ route('support.inbox') }}" class="btn btn-ghost btn-sm gap-1.5 mb-4 -ml-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
        Inbox
    </a>

    <div class="card bg-base-100 border border-base-300 shadow-sm">
        <div class="card-body p-0">

            <div class="p-4 border-b border-base-300 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="room-card-avatar">{{ substr($liveChat->nomor_wa, -2) }}</div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h1 class="font-semibold font-mono text-sm truncate">{{ $liveChat->nomor_wa }}</h1>
                            <span class="ticket-tag">T-{{ str_pad($liveChat->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <span id="statusBadge" class="badge badge-sm mt-0.5 {{ $liveChat->status === 'open' ? 'badge-success badge-outline' : 'badge-ghost' }}">
                            {{ $liveChat->status === 'open' ? 'Aktif' : 'Selesai' }}
                        </span>
                    </div>
                </div>
                <button id="endSessionBtn" type="button" class="btn btn-outline btn-error btn-sm shrink-0" {{ $liveChat->status === 'open' ? '' : 'hidden' }}>
                    Akhiri Sesi
                </button>
            </div>

            <div id="messageList" class="p-4 space-y-3 overflow-y-auto bg-base-200/40" style="height: 60vh;">
                @foreach ($liveChat->messages as $msg)
                    @php
                        $excerpt = $msg->excerpt();
                        $replySenderLabel = $msg->replyTo && $msg->replyTo->sender_type === 'admin_support'
                            ? ($msg->replyTo->adminSupport?->name ?? 'Admin')
                            : $liveChat->nomor_wa;
                        $isAdmin = $msg->sender_type === 'admin_support';
                    @endphp
                    <div class="flex {{ $isAdmin ? 'justify-end' : 'justify-start' }}"
                        data-msg-id="{{ $msg->id }}"
                        data-sender-label="{{ $isAdmin ? ($msg->adminSupport?->name ?? 'Admin') : $liveChat->nomor_wa }}"
                        data-excerpt="{{ $excerpt }}">
                        <div class="max-w-[75%] swipe-wrap">
                            @if ($msg->replyTo)
                                <div class="rounded-lg px-3 py-1.5 mb-1 text-xs bg-base-300/60 border-l-2 border-primary/40 truncate">
                                    <span class="font-semibold">{{ $replySenderLabel }}</span> · {{ $msg->replyTo->excerpt(60) }}
                                </div>
                            @endif
                            <div class="px-3.5 py-2 text-sm {{ $isAdmin ? 'bubble-out' : 'bubble-in' }}">
                                @if ($msg->media_url)
                                    @if ($msg->isImage())
                                        <a href="{{ $msg->media_url }}" target="_blank" rel="noopener">
                                            <img src="{{ $msg->media_url }}" alt="{{ $msg->media_filename }}" class="rounded-lg max-w-full max-h-64 mb-1" loading="lazy">
                                        </a>
                                    @else
                                        <a href="{{ $msg->media_url }}" target="_blank" rel="noopener" class="flex items-center gap-2 underline mb-1">
                                            📎 {{ $msg->media_filename ?? 'File' }}
                                        </a>
                                    @endif
                                @endif
                                @if ($msg->message)
                                    <div class="leading-relaxed">{{ $msg->message }}</div>
                                @endif
                            </div>
                            <div class="text-[0.68rem] text-base-content/40 mt-1 {{ $isAdmin ? 'text-right' : 'text-left' }}">
                                {{ $isAdmin ? ($msg->adminSupport?->name ?? 'Admin') : $liveChat->nomor_wa }}
                                · {{ $msg->created_at->format('H:i') }}
                            </div>
                        </div>
                        <div class="swipe-reply-icon">↩</div>
                    </div>
                @endforeach
            </div>

            <div id="replyPreview" class="px-4 pt-2 border-t border-base-300" hidden>
                <div class="flex items-center justify-between bg-base-200 rounded-lg px-3 py-2 text-sm border-l-2 border-primary">
                    <div class="truncate">
                        Balas <span id="replyPreviewLabel" class="font-semibold"></span>: <span id="replyPreviewExcerpt" class="text-base-content/55"></span>
                    </div>
                    <button type="button" id="cancelReplyBtn" class="btn btn-ghost btn-xs btn-circle">✕</button>
                </div>
            </div>

            <div id="mediaPreview" class="px-4 pt-2 border-t border-base-300" hidden>
                <div class="flex items-center justify-between bg-base-200 rounded-lg px-3 py-2 text-sm">
                    <div class="truncate">📎 <span id="mediaPreviewName"></span></div>
                    <button type="button" id="cancelMediaBtn" class="btn btn-ghost btn-xs btn-circle">✕</button>
                </div>
            </div>

            <form id="replyForm" class="p-3.5 border-t border-base-300 flex gap-2 items-center relative">
                @csrf
                <input type="file" id="mediaInput" name="media" class="hidden" @disabled($liveChat->status !== 'open')>
                <button type="button" id="attachBtn" class="btn btn-ghost btn-sm btn-circle" @disabled($liveChat->status !== 'open')>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" /></svg>
                </button>

                <div class="relative flex-1">
                    <ul id="quickReplyDropdown" class="menu bg-base-100 rounded-lg shadow-lg border border-base-300 p-1 flex-nowrap" hidden></ul>
                    <input type="text" name="message" id="messageInput" class="input input-bordered w-full"
                        placeholder="Tulis balasan... (ketik / buat balasan cepat)" autocomplete="off" maxlength="2000"
                        @disabled($liveChat->status !== 'open')>
                </div>

                <button type="submit" class="btn btn-primary btn-circle btn-sm" @disabled($liveChat->status !== 'open')>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" /></svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const liveChatId = {{ $liveChat->id }};
    const nomorWa = '{{ $liveChat->nomor_wa }}';
    const messageList = document.getElementById('messageList');
    const replyForm = document.getElementById('replyForm');
    const messageInput = document.getElementById('messageInput');
    const statusBadge = document.getElementById('statusBadge');
    const endSessionBtn = document.getElementById('endSessionBtn');
    const attachBtn = document.getElementById('attachBtn');
    const mediaInput = document.getElementById('mediaInput');
    const mediaPreview = document.getElementById('mediaPreview');
    const mediaPreviewName = document.getElementById('mediaPreviewName');
    const cancelMediaBtn = document.getElementById('cancelMediaBtn');
    const replyPreview = document.getElementById('replyPreview');
    const replyPreviewLabel = document.getElementById('replyPreviewLabel');
    const replyPreviewExcerpt = document.getElementById('replyPreviewExcerpt');
    const cancelReplyBtn = document.getElementById('cancelReplyBtn');
    const seenIds = new Set([...document.querySelectorAll('[data-msg-id]')].map(el => el.dataset.msgId));

    let replyTarget = null;

    function setReplyTarget(id, label, excerpt) {
        replyTarget = { id, label, excerpt };
        replyPreviewLabel.textContent = label;
        replyPreviewExcerpt.textContent = excerpt;
        replyPreview.hidden = false;
        messageInput.focus();
    }

    function clearReplyTarget() {
        replyTarget = null;
        replyPreview.hidden = true;
    }

    cancelReplyBtn.addEventListener('click', clearReplyTarget);

    attachBtn.addEventListener('click', () => mediaInput.click());

    mediaInput.addEventListener('change', function () {
        if (mediaInput.files.length) {
            mediaPreviewName.textContent = mediaInput.files[0].name;
            mediaPreview.hidden = false;
        } else {
            mediaPreview.hidden = true;
        }
    });

    cancelMediaBtn.addEventListener('click', function () {
        mediaInput.value = '';
        mediaPreview.hidden = true;
    });

    function attachSwipeHandler(wrapEl) {
        const swipeEl = wrapEl.querySelector('.swipe-wrap');
        const iconEl = wrapEl.querySelector('.swipe-reply-icon');
        if (!swipeEl || swipeEl.dataset.swipeBound) return;
        swipeEl.dataset.swipeBound = '1';

        const THRESHOLD = 55;
        let startX = 0, startY = 0, dx = 0, dragging = false, locked = null;

        swipeEl.addEventListener('pointerdown', function (e) {
            startX = e.clientX;
            startY = e.clientY;
            dx = 0;
            dragging = true;
            locked = null;
            swipeEl.style.transition = 'none';
        });

        swipeEl.addEventListener('pointermove', function (e) {
            if (!dragging) return;
            const rawDx = e.clientX - startX;
            const rawDy = e.clientY - startY;

            if (locked === null) {
                if (Math.abs(rawDx) < 6 && Math.abs(rawDy) < 6) return;
                locked = Math.abs(rawDx) > Math.abs(rawDy) ? 'x' : 'y';
            }
            if (locked !== 'x') return;

            dx = Math.max(0, Math.min(rawDx, 70));
            swipeEl.style.transform = `translateX(${dx}px)`;
            iconEl.style.opacity = String(Math.min(dx / THRESHOLD, 1));
        });

        function endSwipe() {
            if (!dragging) return;
            dragging = false;
            swipeEl.style.transition = 'transform 0.15s ease-out';
            swipeEl.style.transform = 'translateX(0)';
            iconEl.style.opacity = '0';

            if (dx >= THRESHOLD) {
                setReplyTarget(wrapEl.dataset.msgId, wrapEl.dataset.senderLabel, wrapEl.dataset.excerpt);
            }
            dx = 0;
        }

        swipeEl.addEventListener('pointerup', endSwipe);
        swipeEl.addEventListener('pointercancel', endSwipe);
        swipeEl.addEventListener('pointerleave', function () { if (dragging) endSwipe(); });
    }

    document.querySelectorAll('#messageList [data-msg-id]').forEach(attachSwipeHandler);

    const quickReplies = @json($quickReplies->map(fn ($qr) => ['trigger' => $qr->trigger, 'content' => $qr->content]));
    const qrDropdown = document.getElementById('quickReplyDropdown');
    let qrMatches = [];
    let qrActiveIndex = -1;

    function closeQrDropdown() {
        qrDropdown.hidden = true;
        qrDropdown.innerHTML = '';
        qrMatches = [];
        qrActiveIndex = -1;
    }

    function renderQrDropdown() {
        qrDropdown.innerHTML = qrMatches.map((qr, i) => `
            <li>
                <a data-index="${i}" aria-selected="${i === qrActiveIndex}" class="flex-col items-start gap-0 py-1.5">
                    <span class="font-mono text-xs font-semibold text-primary">/${qr.trigger}</span>
                    <span class="text-xs text-base-content/50 truncate w-full">${qr.content}</span>
                </a>
            </li>
        `).join('');
        qrDropdown.hidden = qrMatches.length === 0;
    }

    function pickQuickReply(qr) {
        messageInput.value = qr.content;
        closeQrDropdown();
        messageInput.focus();
    }

    qrDropdown.addEventListener('mousedown', function (e) {
        e.preventDefault();
        const a = e.target.closest('a[data-index]');
        if (a) pickQuickReply(qrMatches[Number(a.dataset.index)]);
    });

    if (quickReplies.length) {
        messageInput.addEventListener('input', function () {
            const val = messageInput.value;
            if (!val.startsWith('/')) {
                closeQrDropdown();
                return;
            }
            const term = val.slice(1).toLowerCase();
            qrMatches = quickReplies.filter(qr => qr.trigger.startsWith(term));
            qrActiveIndex = qrMatches.length ? 0 : -1;
            renderQrDropdown();
        });

        messageInput.addEventListener('keydown', function (e) {
            if (qrDropdown.hidden) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                qrActiveIndex = Math.min(qrActiveIndex + 1, qrMatches.length - 1);
                renderQrDropdown();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                qrActiveIndex = Math.max(qrActiveIndex - 1, 0);
                renderQrDropdown();
            } else if (e.key === 'Enter' || e.key === 'Tab') {
                if (qrActiveIndex >= 0) {
                    e.preventDefault();
                    pickQuickReply(qrMatches[qrActiveIndex]);
                }
            } else if (e.key === 'Escape') {
                closeQrDropdown();
            }
        });

        messageInput.addEventListener('blur', function () {
            setTimeout(closeQrDropdown, 100);
        });
    }

    function setClosedState() {
        statusBadge.textContent = 'Selesai';
        statusBadge.classList.remove('badge-success', 'badge-outline');
        statusBadge.classList.add('badge-ghost');
        endSessionBtn.hidden = true;
        messageInput.disabled = true;
        replyForm.querySelector('button[type="submit"]').disabled = true;
    }

    endSessionBtn.addEventListener('click', async function () {
        if (!confirm('Akhiri sesi live chat ini? Pemohon bakal dibalikin ke menu bot lagi.')) return;

        endSessionBtn.disabled = true;
        try {
            const res = await fetch(`/support/chat/${liveChatId}/end`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            });

            if (!res.ok) {
                const body = await res.json().catch(() => ({}));
                showToast('error', body.message || 'Gagal ngakhirin sesi.');
                endSessionBtn.disabled = false;
                return;
            }

            const body = await res.json();
            setClosedState();

            if (body.fonnte_sent === false) {
                showToast('error', 'Sesi ditutup, tapi notif ke WhatsApp gagal terkirim. Cek token Fonnte instansi.');
            }
        } catch (err) {
            showToast('error', 'Gagal ngakhirin sesi: ' + err.message);
            endSessionBtn.disabled = false;
        }
    });

    function scrollToBottom() {
        messageList.scrollTop = messageList.scrollHeight;
    }
    scrollToBottom();

    function escapeHtml(str) {
        return (str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function appendMessage(data) {
        if (seenIds.has(String(data.id))) return;
        seenIds.add(String(data.id));

        const isAdmin = data.sender_type === 'admin_support';
        const wrap = document.createElement('div');
        wrap.className = `flex ${isAdmin ? 'justify-end' : 'justify-start'}`;
        wrap.dataset.msgId = data.id;

        const time = new Date(data.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        const senderLabel = isAdmin ? (data.admin_support_name || 'Admin') : nomorWa;
        wrap.dataset.senderLabel = senderLabel;
        wrap.dataset.excerpt = data.message || (data.media_filename ? '📎 ' + data.media_filename : '[Media]');

        let mediaHtml = '';
        if (data.media_url) {
            if (data.is_image) {
                mediaHtml = `<a href="${data.media_url}" target="_blank" rel="noopener">
                    <img src="${data.media_url}" alt="${escapeHtml(data.media_filename)}" class="rounded-lg max-w-full max-h-64 mb-1" loading="lazy">
                </a>`;
            } else {
                mediaHtml = `<a href="${data.media_url}" target="_blank" rel="noopener" class="flex items-center gap-2 underline mb-1">
                    📎 ${escapeHtml(data.media_filename || 'File')}
                </a>`;
            }
        }

        let replyHtml = '';
        if (data.reply_to) {
            const replyLabel = data.reply_to.sender_type === 'admin_support' ? (data.reply_to.admin_support_name || 'Admin') : nomorWa;
            replyHtml = `<div class="rounded-lg px-3 py-1.5 mb-1 text-xs bg-base-300/60 border-l-2 border-primary/40 truncate">
                <span class="font-semibold">${escapeHtml(replyLabel)}</span> · ${escapeHtml(data.reply_to.excerpt)}
            </div>`;
        }

        wrap.innerHTML = `
            <div class="max-w-[75%] swipe-wrap">
                ${replyHtml}
                <div class="px-3.5 py-2 text-sm ${isAdmin ? 'bubble-out' : 'bubble-in'}">
                    ${mediaHtml}
                    ${data.message ? `<div class="leading-relaxed">${escapeHtml(data.message)}</div>` : ''}
                </div>
                <div class="text-[0.68rem] text-base-content/40 mt-1 ${isAdmin ? 'text-right' : 'text-left'}">
                    ${senderLabel} · ${time}
                </div>
            </div>
            <div class="swipe-reply-icon">↩</div>
        `;
        messageList.appendChild(wrap);
        attachSwipeHandler(wrap);
        scrollToBottom();
    }

    const pusher = new Pusher('{{ config('broadcasting.connections.reverb.key') }}', {
        cluster: '',
        wsHost: '{{ config('broadcasting.connections.reverb.options.host') }}',
        wsPort: {{ config('broadcasting.connections.reverb.options.port') }},
        wssPort: {{ config('broadcasting.connections.reverb.options.port') }},
        forceTLS: {{ config('broadcasting.connections.reverb.options.useTLS') ? 'true' : 'false' }},
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        auth: { headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }
    });

    pusher.connection.bind('connected', () => setConnectionStatus(true));
    pusher.connection.bind('unavailable', () => setConnectionStatus(false));
    pusher.connection.bind('failed', () => setConnectionStatus(false));
    pusher.connection.bind('disconnected', () => setConnectionStatus(false));

    const channel = pusher.subscribe('private-live-chat.' + liveChatId);
    channel.bind('message.sent', function (data) {
        appendMessage(data);
    });

    replyForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        const hasMedia = mediaInput.files.length > 0;
        if (!message && !hasMedia) return;

        closeQrDropdown();
        const submitBtn = replyForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;

        const formData = new FormData();
        formData.append('message', message);
        if (hasMedia) formData.append('media', mediaInput.files[0]);
        if (replyTarget) formData.append('reply_to_message_id', replyTarget.id);

        try {
            const res = await fetch(`/support/chat/${liveChatId}/reply`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            if (!res.ok) {
                const body = await res.json().catch(() => ({}));
                showToast('error', body.message || 'Gagal kirim pesan.');
                return;
            }

            const body = await res.json();
            appendMessage(body.data);
            messageInput.value = '';
            mediaInput.value = '';
            mediaPreview.hidden = true;
            clearReplyTarget();

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
});
</script>
@endsection