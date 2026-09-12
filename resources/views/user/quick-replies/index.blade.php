@extends('user.layout2')

@section('title', 'Balasan Cepat')
@section('meta_description', 'Atur balasan cepat (quick reply) buat admin support di live chat WhatsApp.')
@section('og_description', 'Kelola template balasan cepat SITAKU sesuai kebutuhan instansi Anda.')

@section('content')
<div class="min-h-screen bg-base-100 py-8">
    <div class="bg-base-100 borderbc1">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-base-content">Balasan Cepat</h1>
                    <p class="text-base-content/70">Template balasan yang bisa dipanggil admin support di live chat pakai "/trigger"</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 mt-6">
        <div class="flex justify-between items-center mb-4">
            <p class="text-sm text-base-content/60">
                {{ $quickReplies->count() }} balasan cepat tersimpan. Admin support ketik "/" di kotak chat buat manggil.
            </p>
            <a href="{{ route('quick-reply.create') }}" class="btn btn-primary btn-sm">+ Tambah Balasan Cepat</a>
        </div>

        @if ($quickReplies->isEmpty())
            <div class="card bg-base-100 shadow border border-base-300">
                <div class="card-body text-center py-10 text-base-content/60">
                    Belum ada balasan cepat. Klik "Tambah Balasan Cepat" buat mulai.
                </div>
            </div>
        @else
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Trigger</th>
                                <th>Isi</th>
                                <th class="text-right">Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quickReplies as $qr)
                                <tr>
                                    <td><span class="badge badge-neutral">/{{ $qr->trigger }}</span></td>
                                    <td class="max-w-md truncate text-base-content/70">{{ $qr->content }}</td>
                                    <td class="text-right space-x-1">
                                        <a href="{{ route('quick-reply.edit', $qr) }}" class="btn btn-xs btn-outline">Edit</a>
                                        <form action="{{ route('quick-reply.destroy', $qr) }}" method="POST" class="inline js-confirm-submit"
                                            data-confirm-message="Yakin hapus balasan cepat ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-error btn-outline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="toast toast-top toast-end z-50" id="toastContainer"></div>

<script>
    function showToast(type, message) {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const alertClass = type === 'error' ? 'alert-error' : 'alert-success';
        const icon = type === 'error' ?
            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

        const toast = document.createElement('div');
        toast.className = `alert ${alertClass} shadow-lg mb-4`;
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                ${icon}
                <span>${message}</span>
                <button class="btn btn-ghost btn-xs" onclick="this.parentElement.parentElement.remove()">✕</button>
            </div>
        `;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 4000);
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            showToast('success', "{{ session('success') }}");
        @endif
        @if (session('error'))
            showToast('error', "{{ session('error') }}");
        @endif
    });
</script>
@endsection