@extends('support.layout')

@section('title', 'Inbox - Support Panel')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-1">Inbox Live Chat</h1>
    <p class="text-sm text-base-content/60 mb-6">Semua room di sini bisa dibales admin manapun di instansi ini (shared inbox).</p>

    <div class="space-y-2" id="roomList">
        @forelse ($rooms as $room)
            <a href="{{ route('support.chat.show', $room) }}"
                class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow border border-base-300 block">
                <div class="card-body py-4 flex-row items-center justify-between">
                    <div>
                        <div class="font-semibold flex items-center gap-2">
                            {{ $room->nomor_wa }}
                            @if ($room->status === 'closed')
                                <span class="badge badge-ghost badge-sm">Selesai</span>
                            @endif
                            @if ($room->isBeingRepliedByOther($agent->id))
                                <span class="badge badge-warning badge-sm">Sedang dibales {{ $room->replyingAdmin?->name }}</span>
                            @endif
                        </div>
                        <div class="text-xs text-base-content/50">
                            Update terakhir: {{ $room->last_message_at?->diffForHumans() ?? '-' }}
                        </div>
                    </div>
                    @if ($room->unread_count > 0)
                        <span class="badge badge-primary">{{ $room->unread_count }}</span>
                    @endif
                </div>
            </a>
        @empty
            <div class="text-center py-16 text-base-content/50">
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
    const pusher = new Pusher('{{ config('broadcasting.connections.reverb.key') }}', {
        wsHost: '{{ config('broadcasting.connections.reverb.options.host') }}',
        wsPort: {{ config('broadcasting.connections.reverb.options.port') }},
        wssPort: {{ config('broadcasting.connections.reverb.options.port') }},
        forceTLS: {{ config('broadcasting.connections.reverb.options.useTLS') ? 'true' : 'false' }},
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        auth: { headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }
    });

    // Denger notifikasi ringan "ada pesan baru masuk" buat instansi ini --
    // begitu ada, reload aja list-nya biar simpel (bukan patch DOM manual).
    const channel = pusher.subscribe('private-instansi.{{ $agent->user_id }}.live-chats');
    channel.bind('room.updated', function () {
        window.location.reload();
    });
</script>
@endsection