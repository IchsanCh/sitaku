@extends('support.layout')

@section('title', 'Inbox - Support Panel')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-1">Inbox Live Chat</h1>
    <p class="text-sm text-base-content/60 mb-6">Semua room di sini bisa dibales admin manapun di instansi ini (shared inbox).</p>

    <div class="space-y-2" id="roomList">
        @forelse ($rooms as $room)
            <a href="{{ route('support.chat.show', $room) }}" data-room-id="{{ $room->id }}"
                class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow border border-base-300 block">
                <div class="card-body py-4 flex-row items-center justify-between">
                    <div>
                        <div class="font-semibold flex items-center gap-2">
                            <span class="js-nomor-wa">{{ $room->nomor_wa }}</span>
                            <span class="js-status-badge badge badge-ghost badge-sm" {{ $room->status === 'closed' ? '' : 'hidden' }}>Selesai</span>
                            <span class="js-replying-badge badge badge-warning badge-sm" {{ $room->isBeingRepliedByOther($agent->id) ? '' : 'hidden' }}>Sedang dibales {{ $room->replyingAdmin?->name }}</span>
                        </div>
                        <div class="text-xs text-base-content/50">
                            Update terakhir: <span class="js-last-update">{{ $room->last_message_at?->diffForHumans() ?? '-' }}</span>
                        </div>
                    </div>
                    <span class="js-unread-badge badge badge-primary" {{ $room->unread_count > 0 ? '' : 'hidden' }}>{{ $room->unread_count }}</span>
                </div>
            </a>
        @empty
            <div class="text-center py-16 text-base-content/50" id="emptyState">
                Belum ada percakapan live chat masuk.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $rooms->links() }}
    </div>
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

    const currentAdminId = {{ $agent->id }};
    const roomList = document.getElementById('roomList');

    // Kira-kira aja waktu relatifnya (gak sepresisi Carbon::diffForHumans(),
    // tapi cukup deket buat tampilan live -- direfresh beneran pas reload).
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

    function buildRoomCard(data) {
        const a = document.createElement('a');
        a.dataset.roomId = data.id;
        a.className = 'card bg-base-100 shadow-sm hover:shadow-md transition-shadow border border-base-300 block';
        a.innerHTML = `
            <div class="card-body py-4 flex-row items-center justify-between">
                <div>
                    <div class="font-semibold flex items-center gap-2">
                        <span class="js-nomor-wa"></span>
                        <span class="js-status-badge badge badge-ghost badge-sm" hidden>Selesai</span>
                        <span class="js-replying-badge badge badge-warning badge-sm" hidden></span>
                    </div>
                    <div class="text-xs text-base-content/50">
                        Update terakhir: <span class="js-last-update"></span>
                    </div>
                </div>
                <span class="js-unread-badge badge badge-primary" hidden></span>
            </div>
        `;
        return a;
    }

    function upsertRoomCard(data) {
        let card = roomList.querySelector(`[data-room-id="${data.id}"]`);
        if (!card) {
            card = buildRoomCard(data);
            document.getElementById('emptyState')?.remove();
        }

        card.href = data.chat_url;

        card.querySelector('.js-nomor-wa').textContent = data.nomor_wa;
        card.querySelector('.js-status-badge').hidden = data.status !== 'closed';

        const replyingBadge = card.querySelector('.js-replying-badge');
        if (isBeingRepliedByOther(data)) {
            replyingBadge.hidden = false;
            replyingBadge.textContent = 'Sedang dibales ' + (data.replying_admin_name || '');
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

        // Room yang baru keupdate paling relevan -- majuin ke paling atas
        // (list-nya emang di-order by last_message_at desc).
        roomList.prepend(card);
    }

    const channel = pusher.subscribe('private-instansi.{{ $agent->user_id }}.live-chats');
    channel.bind('room.updated', function (data) {
        upsertRoomCard(data);
    });
});
</script>
@endsection