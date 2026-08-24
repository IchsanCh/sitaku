@extends('support.layout')

@section('title', 'Chat ' . $liveChat->nomor_wa . ' - Support Panel')

@section('content')
<style>
    #quickReplyDropdown { position: absolute; bottom: 100%; left: 0; right: 0; margin-bottom: 4px; max-height: 220px; overflow-y: auto; z-index: 20; }
    #quickReplyDropdown li[aria-selected="true"] { background-color: hsl(var(--b2, var(--b3))); }
    .swipe-wrap { touch-action: pan-y; will-change: transform; transition: transform 0.15s ease-out; position: relative; z-index: 1; }
    .swipe-reply-icon {
        position: absolute; top: 50%; left: 8px; transform: translateY(-50%);
        opacity: 0; transition: opacity 0.15s ease-out; font-size: 1.1rem; pointer-events: none;
    }
</style>
<div class="max-w-2xl mx-auto px-4 py-6">
    <a href="{{ route('support.inbox') }}" class="btn btn-ghost btn-sm mb-4">← Kembali ke Inbox</a>

    <div class="card bg-base-100 shadow-xl border border-base-300">
        <div class="card-body p-0">
            <div class="p-4 border-b border-base-300 flex items-center justify-between">
                <div>
                    <h1 class="font-bold">{{ $liveChat->nomor_wa }}</h1>
                    <span id="statusBadge" class="badge badge-sm {{ $liveChat->status === 'open' ? 'badge-success' : 'badge-ghost' }}">
                        {{ $liveChat->status === 'open' ? 'Aktif' : 'Selesai' }}
                    </span>
                </div>
                <button id="endSessionBtn" type="button" class="btn btn-outline btn-error btn-sm" {{ $liveChat->status === 'open' ? '' : 'hidden' }}>
                    Akhiri Sesi
                </button>
            </div>

            <div id="messageList" class="p-4 space-y-3 overflow-y-auto" style="height: 60vh;">
                @foreach ($liveChat->messages as $msg)
                    @php
                        $excerpt = $msg->message ?: ($msg->media_filename ? '📎 ' . $msg->media_filename : '[Media]');
                        $replySenderLabel = $msg->replyTo && $msg->replyTo->sender_type === 'admin_support'
                            ? ($msg->replyTo->adminSupport?->name ?? 'Admin')
                            : $liveChat->nomor_wa;
                    @endphp
                    <div class="flex {{ $msg->sender_type === 'admin_support' ? 'justify-end' : 'justify-start' }}"
                        data-msg-id="{{ $msg->id }}"
                        data-sender-label="{{ $msg->sender_type === 'admin_support' ? ($msg->adminSupport?->name ?? 'Admin') : $liveChat->nomor_wa }}"
                        data-excerpt="{{ $excerpt }}">
                        <div class="max-w-[75%] swipe-wrap">
                            @if ($msg->replyTo)
                                <div class="rounded-lg px-3 py-1 mb-1 text-xs bg-base-300/60 border-l-4 border-base-content/20 truncate">
                                    <span class="font-semibold">{{ $replySenderLabel }}</span> · {{ Str::limit($msg->replyTo->message ?: ($msg->replyTo->media_filename ? '📎 ' . $msg->replyTo->media_filename : '[Media]'), 60) }}
                                </div>
                            @endif
                            <div class="rounded-2xl px-4 py-2 text-sm {{ $msg->sender_type === 'admin_support' ? 'bg-primary text-primary-content rounded-br-md' : 'bg-base-200 rounded-bl-md' }}">
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
                                    <div>{{ $msg->message }}</div>
                                @endif
                            </div>
                            <div class="text-xs text-base-content/40 mt-1 {{ $msg->sender_type === 'admin_support' ? 'text-right' : 'text-left' }}">
                                {{ $msg->sender_type === 'admin_support' ? ($msg->adminSupport?->name ?? 'Admin') : $liveChat->nomor_wa }}
                                · {{ $msg->created_at->format('H:i') }}
                            </div>
                        </div>
                        <div class="swipe-reply-icon">↩</div>
                    </div>
                @endforeach
            </div>

            <div id="replyPreview" class="px-4 pt-2 border-t border-base-300" hidden>
                <div class="flex items-center justify-between bg-base-200 rounded-lg px-3 py-2 text-sm">
                    <div class="truncate">
                        Balas <span id="replyPreviewLabel" class="font-semibold"></span>: <span id="replyPreviewExcerpt" class="text-base-content/60"></span>
                    </div>
                    <button type="button" id="cancelReplyBtn" class="btn btn-ghost btn-xs">✕</button>
                </div>
            </div>

            <div id="mediaPreview" class="px-4 pt-2 border-t border-base-300" hidden>
                <div class="flex items-center justify-between bg-base-200 rounded-lg px-3 py-2 text-sm">
                    <div class="truncate">📎 <span id="mediaPreviewName"></span></div>
                    <button type="button" id="cancelMediaBtn" class="btn btn-ghost btn-xs">✕</button>
                </div>
            </div>

            <form id="replyForm" class="p-4 border-t border-base-300 flex gap-2 items-center relative">
                @csrf
                <input type="file" id="mediaInput" name="media" class="hidden" @disabled($liveChat->status !== 'open')>
                <button type="button" id="attachBtn" class="btn btn-ghost btn-sm" @disabled($liveChat->status !== 'open')>📎</button>

                <div class="relative flex-1">
                    <ul id="quickReplyDropdown" class="menu bg-base-100 rounded-lg shadow-lg border border-base-300 p-1 flex-nowrap" hidden></ul>
                    <input type="text" name="message" id="messageInput" class="input input-bordered w-full"
                        placeholder="Tulis balasan... (ketik / buat balasan cepat)" autocomplete="off" maxlength="2000"
                        @disabled($liveChat->status !== 'open')>
                </div>

                <button type="submit" class="btn btn-primary" @disabled($liveChat->status !== 'open')>Kirim</button>
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

    let replyTarget = null; // { id, label, excerpt }

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

    // ---- Swipe-to-reply --------------------------------------------------
    // Geser bubble pesan ke kanan buat set target reply. Pointer events biar
    // jalan di touch maupun mouse sekaligus.
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
    // ------------------------------------------------------------------------

    // ---- Balasan cepat ("/trigger") ----------------------------------
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
                    <span class="font-mono text-xs font-semibold">/${qr.trigger}</span>
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
    // --------------------------------------------------------------------

    function setClosedState() {
        statusBadge.textContent = 'Selesai';
        statusBadge.classList.remove('badge-success');
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
            replyHtml = `<div class="rounded-lg px-3 py-1 mb-1 text-xs bg-base-300/60 border-l-4 border-base-content/20 truncate">
                <span class="font-semibold">${escapeHtml(replyLabel)}</span> · ${escapeHtml(data.reply_to.excerpt)}
            </div>`;
        }

        wrap.innerHTML = `
            <div class="max-w-[75%] swipe-wrap">
                ${replyHtml}
                <div class="rounded-2xl px-4 py-2 text-sm ${isAdmin ? 'bg-primary text-primary-content rounded-br-md' : 'bg-base-200 rounded-bl-md'}">
                    ${mediaHtml}
                    ${data.message ? `<div>${escapeHtml(data.message)}</div>` : ''}
                </div>
                <div class="text-xs text-base-content/40 mt-1 ${isAdmin ? 'text-right' : 'text-left'}">
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