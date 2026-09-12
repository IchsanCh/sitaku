@extends('user.layout2')

@section('title', 'Akun Admin Support')
@section('meta_description', 'Kelola akun admin support instansi untuk live chat WhatsApp.')
@section('og_description', 'Kelola akun admin support SITAKU sesuai kebutuhan instansi Anda.')

@section('content')
<div class="min-h-screen bg-base-100 py-8">
    <div class="bg-base-100 borderbc1">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-base-content">Akun Admin Support</h1>
                    <p class="text-base-content/70">Kelola siapa aja yang bisa login ke panel live chat instansi Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 mt-6">
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin-support.create') }}" class="btn btn-primary btn-sm">+ Tambah Admin Support</a>
        </div>

        @if ($adminSupports->isEmpty())
            <div class="card bg-base-100 shadow border border-base-300">
                <div class="card-body text-center py-10 text-base-content/60">
                    Belum ada akun admin support. Klik "Tambah Admin Support" buat mulai.
                </div>
            </div>
        @else
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-right">Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adminSupports as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @if ($admin->is_active)
                                            <span class="badge badge-success badge-sm">Aktif</span>
                                        @else
                                            <span class="badge badge-ghost badge-sm">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-right space-x-1">
                                        <a href="{{ route('admin-support.edit', $admin) }}" class="btn btn-xs btn-outline">Edit</a>
                                        <form action="{{ route('admin-support.destroy', $admin) }}" method="POST" class="inline js-confirm-submit"
                                            data-confirm-message="Yakin hapus akun admin support ini? Dia gak bisa login lagi.">
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