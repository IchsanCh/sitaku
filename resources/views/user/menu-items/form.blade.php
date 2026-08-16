@extends('user.layout2')

@section('title', $menuItem->exists ? 'Edit Menu Item' : 'Tambah Menu Item')
@section('meta_description', 'Atur menu interaktif WhatsApp untuk pemohon dan pegawai.')
@section('og_description', 'Kelola custom menu WhatsApp SITAKU sesuai kebutuhan instansi Anda.')

@section('content')
<div class="min-h-screen bg-base-100 py-8">
    <div class="max-w-2xl mx-auto px-6">

        <a href="{{ route('menu.index', ['parent' => $menuItem->parent_id]) }}" class="btn btn-ghost btn-sm mb-4">
            ← Kembali
        </a>

        <div class="card bg-base-100 shadow-2xl border border-base-300">
            <div class="card-body p-8">
                <h1 class="text-2xl font-bold mb-1">
                    {{ $menuItem->exists ? 'Edit Menu Item' : 'Tambah Menu Item' }}
                </h1>
                @if ($parent)
                    <p class="text-base-content/60 mb-6">Submenu dari: <span class="font-medium">{{ $parent->label }}</span></p>
                @else
                    <p class="text-base-content/60 mb-6">Di menu utama</p>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error mb-6">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                    action="{{ $menuItem->exists ? route('menu.update', $menuItem) : route('menu.store') }}"
                    class="space-y-5">
                    @csrf
                    @if ($menuItem->exists)
                        @method('PUT')
                    @endif

                    <input type="hidden" name="parent_id" value="{{ $menuItem->parent_id }}">

                    <div>
                        <label class="label"><span class="label-text font-medium">Trigger</span></label>
                        <input type="text" name="trigger" value="{{ old('trigger', $menuItem->trigger) }}"
                            class="input input-bordered w-full" placeholder="misal: 1, atau 'status'" required maxlength="50">
                        <p class="text-xs text-base-content/50 mt-1">Kata/angka yang diketik user WA buat pilih menu ini. Harus unik di level menu yang sama.</p>
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-medium">Label</span></label>
                        <input type="text" name="label" value="{{ old('label', $menuItem->label) }}"
                            class="input input-bordered w-full" placeholder="misal: Cek Status Permohonan" required maxlength="255">
                        <p class="text-xs text-base-content/50 mt-1">Teks yang ditampilkan ke user di daftar menu WA.</p>
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-medium">Untuk Siapa</span></label>
                        <select name="audience" class="select select-bordered w-full" required>
                            <option value="both" {{ old('audience', $menuItem->audience ?? 'both') === 'both' ? 'selected' : '' }}>Pemohon & Pegawai</option>
                            <option value="pemohon" {{ old('audience', $menuItem->audience ?? '') === 'pemohon' ? 'selected' : '' }}>Pemohon saja</option>
                            <option value="pegawai" {{ old('audience', $menuItem->audience ?? '') === 'pegawai' ? 'selected' : '' }}>Pegawai saja</option>
                        </select>
                        <p class="text-xs text-base-content/50 mt-1">Menu ini cuma muncul buat peran yang dipilih pas mereka chat WA.</p>
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-medium">Jenis Aksi</span></label>
                        <select name="action_type" id="action_type" class="select select-bordered w-full" required onchange="toggleActionFields()">
                            <option value="">-- Pilih jenis aksi --</option>
                            @foreach ($allowedActions as $action)
                                <option value="{{ $action }}" {{ old('action_type', $menuItem->action_type) === $action ? 'selected' : '' }}>
                                    {{ match($action) {
                                        'cek_status' => 'Cek Status Permohonan',
                                        'riwayat_tahapan' => 'Riwayat Tahapan',
                                        'pesan_custom' => 'Kirim Pesan Custom',
                                        'submenu' => 'Buka Submenu',
                                        'exit' => 'Keluar / Selesai',
                                        default => $action,
                                    } }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="pesan_custom_field" class="hidden">
                        <label class="label"><span class="label-text font-medium">Isi Pesan</span></label>
                        <textarea name="pesan_custom" rows="4" class="textarea textarea-bordered w-full"
                            maxlength="1000" placeholder="Isi pesan yang mau dikirim kalau menu ini dipilih...">{{ old('pesan_custom', $menuItem->action_config['pesan'] ?? '') }}</textarea>
                    </div>

                    <div id="submenu_hint" class="hidden">
                        <div class="alert alert-info text-sm">
                            <span>Setelah disimpan, kamu bisa isi submenu-nya dari halaman daftar menu (tombol "Kelola Submenu").</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label"><span class="label-text font-medium">Urutan Tampil</span></label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $menuItem->sort_order ?? 0) }}"
                                class="input input-bordered w-full" min="0">
                        </div>
                        <div class="flex items-end pb-3">
                            <label class="label cursor-pointer gap-3">
                                <input type="checkbox" name="is_active" value="1" class="toggle toggle-primary"
                                    {{ old('is_active', $menuItem->exists ? $menuItem->is_active : true) ? 'checked' : '' }}>
                                <span class="label-text font-medium">Aktif</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn btn-primary flex-1">
                            {{ $menuItem->exists ? 'Simpan Perubahan' : 'Tambah Menu Item' }}
                        </button>
                        <a href="{{ route('menu.index', ['parent' => $menuItem->parent_id]) }}" class="btn btn-ghost">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleActionFields() {
        const type = document.getElementById('action_type').value;
        document.getElementById('pesan_custom_field').classList.toggle('hidden', type !== 'pesan_custom');
        document.getElementById('submenu_hint').classList.toggle('hidden', type !== 'submenu');
    }
    document.addEventListener('DOMContentLoaded', toggleActionFields);
</script>
@endsection