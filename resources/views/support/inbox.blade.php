@extends('support.layout')

@section('title', 'Inbox - Support Panel')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="flex items-end justify-between mb-1">
        <h1 class="font-display font-semibold text-2xl">Inbox</h1>
        <span class="text-xs text-base-content/40 font-mono">{{ $rooms->total() }} percakapan</span>
    </div>
    <p class="text-sm text-base-content/55 mb-5">Semua room bisa dibales admin manapun di instansi ini.</p>

    <div class="flex items-center gap-2 mb-4">
        <label class="input input-bordered flex items-center gap-2 flex-1 h-10">
            <svg class="w-4 h-4 text-base-content/35" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            <input type="text" id="roomSearchInput" placeholder="Cari nomor WA..." class="grow text-sm">
        </label>
        <div class="join">
            <button type="button" class="join-item btn btn-sm filter-chip filter-chip-active btn-primary" data-filter="all">Semua</button>
            <button type="button" class="join-item btn btn-sm filter-chip" data-filter="unread">Belum Dibalas</button>
            <button type="button" class="join-item btn btn-sm filter-chip" data-filter="closed">Selesai</button>
        </div>
    </div>

    <div class="space-y-2" id="roomList">
        @forelse ($rooms as $room)
            @php
                $ticketCode = 'T-' . str_pad($room->id, 3, '0', STR_PAD_LEFT);
                $preview = $room->latestMessage
                    ? ($room->latestMessage->sender_type === 'admin_support' ? 'Anda: ' : '') . $room->latestMessage->excerpt(70)
                    : 'Belum ada pesan';
            @endphp
            <a href="{{ route('support.chat.show', $room) }}" data-room-id="{{ $room->id }}"
                data-status="{{ $room->status }}" data-unread="{{ $room->unread_count }}"
                class="room-card">
                <div class="room-card-avatar">{{ substr($room->nomor_wa, -2) }}</div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="js-nomor-wa font-semibold text-sm font-mono truncate">{{ $room->nomor_wa }}</span>
                        <span class="ticket-tag shrink-0">{{ $ticketCode }}</span>
                        <span class="js-status-badge badge badge-ghost badge-xs shrink-0" {{ $room->status === 'closed' ? '' : 'hidden' }}>Selesai</span>
                        <span class="js-replying-badge badge badge-warning badge-xs shrink-0" {{ $room->isBeingRepliedByOther($agent->id) ? '' : 'hidden' }}>Dibales {{ $room->replyingAdmin?->name }}</span>
                    </div>
                    <div class="js-last-message text-sm text-base-content/55 truncate">{{ $preview }}</div>
                    <div class="text-xs text-base-content/35 mt-0.5">
                        <span class="js-last-update">{{ $room->last_message_at?->diffForHumans() ?? '-' }}</span>
                    </div>
                </div>
                <span class="js-unread-badge badge badge-primary shrink-0" {{ $room->unread_count > 0 ? '' : 'hidden' }}>{{ $room->unread_count }}</span>
            </a>
        @empty
            <div class="text-center py-20" id="emptyState">
                <div class="empty-stamp w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8m-8 4h4m-9 4h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14l3-2Z" /></svg>
                </div>
                <p class="text-sm text-base-content/45">Belum ada percakapan live chat masuk.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6" id="roomPagination">
        {{ $rooms->links() }}
    </div>

    <p id="noResultsState" class="text-center text-sm text-base-content/40 py-10" hidden>Gak ada room yang cocok sama pencarian/filter itu.</p>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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

    const currentAdminId = {{ $agent->id }};
    const roomList = document.getElementById('roomList');

    function relativeTime(isoString) {
        if (!isoString) return '-';
        const diffMs = Date.now() - new Date(isoString).getTime();
        const diffMin = Math.round(diffMs / 60000);
        if (diffMin < 1) return 'baru saja';
        if (diffMin < 60) return diffMin + ' menit yang lalu';
        const diffHour = Math.round(diffMin / 60);
        if (diffHour < 24) return diffHour + ' jam yang lalu';
        return Math.round(diffHour / 24) + ' hari yang lalu';
    }

    function isBeingRepliedByOther(data) {
        if (!data.replying_admin_id || data.replying_admin_id === currentAdminId) return false;
        if (!data.replying_at) return false;
        return (Date.now() - new Date(data.replying_at).getTime()) < 3 * 60 * 1000;
    }

    function ticketCode(id) {
        return 'T-' + String(id).padStart(3, '0');
    }

    function buildRoomCard(data) {
        const a = document.createElement('a');
        a.dataset.roomId = data.id;
        a.className = 'room-card';
        a.innerHTML = `
            <div class="room-card-avatar"></div>
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="js-nomor-wa font-semibold text-sm font-mono truncate"></span>
                    <span class="ticket-tag shrink-0">${ticketCode(data.id)}</span>
                    <span class="js-status-badge badge badge-ghost badge-xs shrink-0" hidden>Selesai</span>
                    <span class="js-replying-badge badge badge-warning badge-xs shrink-0" hidden></span>
                </div>
                <div class="js-last-message text-sm text-base-content/55 truncate"></div>
                <div class="text-xs text-base-content/35 mt-0.5">
                    <span class="js-last-update"></span>
                </div>
            </div>
            <span class="js-unread-badge badge badge-primary shrink-0" hidden></span>
        `;
        return a;
    }

    function applyFilterAndSearch() {
        const query = (document.getElementById('roomSearchInput').value || '').toLowerCase().trim();
        const activeFilter = document.querySelector('.filter-chip-active')?.dataset.filter || 'all';
        let visibleCount = 0;

        roomList.querySelectorAll('[data-room-id]').forEach(card => {
            const matchesQuery = !query || card.querySelector('.js-nomor-wa').textContent.toLowerCase().includes(query);
            const isClosed = card.dataset.status === 'closed';
            const isUnread = parseInt(card.dataset.unread || '0', 10) > 0;

            let matchesFilter = true;
            if (activeFilter === 'unread') matchesFilter = isUnread && !isClosed;
            if (activeFilter === 'closed') matchesFilter = isClosed;

            const visible = matchesQuery && matchesFilter;
            card.hidden = !visible;
            if (visible) visibleCount++;
        });

        document.getElementById('noResultsState').hidden = visibleCount > 0;
        document.getElementById('roomPagination').hidden = query !== '' || activeFilter !== 'all';
    }

    document.getElementById('roomSearchInput').addEventListener('input', applyFilterAndSearch);
    document.querySelectorAll('.filter-chip').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-chip').forEach(b => b.classList.remove('filter-chip-active', 'btn-primary'));
            this.classList.add('filter-chip-active', 'btn-primary');
            applyFilterAndSearch();
        });
    });

    function upsertRoomCard(data) {
        let card = roomList.querySelector(`[data-room-id="${data.id}"]`);
        if (!card) {
            card = buildRoomCard(data);
            document.getElementById('emptyState')?.remove();
        }

        card.href = data.chat_url;
        card.dataset.status = data.status;
        card.dataset.unread = data.unread_count;

        card.querySelector('.room-card-avatar').textContent = data.nomor_wa.slice(-2);
        card.querySelector('.js-nomor-wa').textContent = data.nomor_wa;
        card.querySelector('.js-status-badge').hidden = data.status !== 'closed';

        const preview = (data.last_message_sender_type === 'admin_support' ? 'Anda: ' : '') + (data.last_message_preview || 'Belum ada pesan');
        card.querySelector('.js-last-message').textContent = preview;

        const replyingBadge = card.querySelector('.js-replying-badge');
        if (isBeingRepliedByOther(data)) {
            replyingBadge.hidden = false;
            replyingBadge.textContent = 'Dibales ' + (data.replying_admin_name || '');
        } else {
            replyingBadge.hidden = true;
        }

        card.querySelector('.js-last-update').textContent = relativeTime(data.last_message_at);

        const unreadBadge = card.querySelector('.js-unread-badge');
        if (data.unread_count > 0) {
            unreadBadge.hidden = false;
            unreadBadge.textContent = data.unread_count;
        } else {
            unreadBadge.hidden = true;
        }

        roomList.prepend(card);
        applyFilterAndSearch();
    }

    const channel = pusher.subscribe('private-instansi.{{ $agent->user_id }}.live-chats');
    channel.bind('room.updated', function (data) {
        upsertRoomCard(data);
    });
});
</script>
@endsection