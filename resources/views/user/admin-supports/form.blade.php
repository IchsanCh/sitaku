@extends('user.layout2')

@section('title', $adminSupport->exists ? 'Edit Admin Support' : 'Tambah Admin Support')
@section('meta_description', 'Kelola akun admin support instansi untuk live chat WhatsApp.')
@section('og_description', 'Kelola akun admin support SITAKU sesuai kebutuhan instansi Anda.')

@section('content')
<div class="min-h-screen bg-base-100 py-8">
    <div class="max-w-2xl mx-auto px-6">

        <a href="{{ route('admin-support.index') }}" class="btn btn-ghost btn-sm mb-4">← Kembali</a>

        <div class="card bg-base-100 shadow-2xl border border-base-300">
            <div class="card-body p-8">
                <h1 class="text-2xl font-bold mb-6">
                    {{ $adminSupport->exists ? 'Edit Admin Support' : 'Tambah Admin Support' }}
                </h1>

                <form method="POST"
                    action="{{ $adminSupport->exists ? route('admin-support.update', $adminSupport) : route('admin-support.store') }}"
                    class="space-y-5">
                    @csrf
                    @if ($adminSupport->exists)
                        @method('PUT')
                    @endif

                    <div>
                        <label class="label"><span class="label-text font-medium">Nama</span></label>
                        <input type="text" name="name" value="{{ old('name', $adminSupport->name) }}"
                            class="input input-bordered w-full" required maxlength="255">
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-medium">Email</span></label>
                        <input type="email" name="email" value="{{ old('email', $adminSupport->email) }}"
                            class="input input-bordered w-full" required maxlength="255">
                        <p class="text-xs text-base-content/50 mt-1">Dipakai buat login ke panel live chat -- harus unik.</p>
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-medium">Password</span></label>
                        <input type="password" name="password" class="input input-bordered w-full" minlength="8"
                            {{ $adminSupport->exists ? '' : 'required' }}
                            placeholder="{{ $adminSupport->exists ? 'Kosongin kalau gak mau ganti' : '' }}">
                    </div>

                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-sm"
                            {{ old('is_active', $adminSupport->is_active ?? true) ? 'checked' : '' }}>
                        <span class="label-text">Aktif (bisa login)</span>
                    </label>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('admin-support.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            {{ $adminSupport->exists ? 'Simpan Perubahan' : 'Tambah Admin Support' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showToast('error', "{{ $error }}");
            @endforeach
        @endif
    });
</script>
@endsection