@extends('user.layout2')

@section('title', $menuItem->exists ? 'Edit Menu Item' : 'Tambah Menu Item')
@section('meta_description', 'Atur menu interaktif WhatsApp untuk pemohon dan pegawai.')
@section('og_description', 'Kelola custom menu WhatsApp SITAKU sesuai kebutuhan instansi Anda.')

@section('content')
<div class="min-h-screen bg-base-100 py-8">
    <div class="max-w-5xl mx-auto px-6">

        <a href="{{ route('menu.index', ['parent' => $menuItem->parent_id]) }}" class="btn btn-ghost btn-sm mb-4">
            ← Kembali
        </a>

        <div class="grid lg:grid-cols-2 gap-6 items-start">
            <!-- Form -->
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
                            <input type="text" id="label_input" name="label" value="{{ old('label', $menuItem->label) }}"
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
                                            'antrian_pegawai' => 'Antrian Saya (Pegawai)',
                                            'info_pegawai' => 'Info Saya (Pegawai)',
                                            'pesan_custom' => 'Kirim Pesan Custom',
                                            'submenu' => 'Buka Submenu',
                                            'exit' => 'Keluar / Selesai',
                                            default => $action,
                                        } }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="template_field" class="hidden">
                            <div class="flex justify-between items-baseline">
                                <label class="label"><span class="label-text font-medium">Template Pesan</span></label>
                                <span class="text-xs text-base-content/50"><span id="charCount">0</span>/1500</span>
                            </div>
                            <textarea name="template" id="template_input" rows="6" class="textarea textarea-bordered w-full font-mono text-sm"
                                maxlength="1500" placeholder="Tulis template pesan kamu di sini...">{{ old('template', $menuItem->action_config['template'] ?? $menuItem->action_config['pesan'] ?? '') }}</textarea>

                            <div id="var_hint_pesan_custom" class="hidden text-xs text-base-content/50 mt-2">
                                Pesan statis, tampil apa adanya -- gak ada data pemohon di titik ini (belum lewat validasi), jadi gak ada variabel yang bisa dipakai.
                            </div>
                            <div id="var_hint_status" class="hidden text-xs text-base-content/50 mt-2">
                                Variabel yang bisa dipakai: <code>{nama}</code> <code>{no_permohonan}</code> <code>{nama_izin}</code> <code>{tahapan}</code> <code>{status}</code> <code>{link_izin}</code> <code>{no_hp}</code>
                                <br>Contoh: <em>"Halo {nama}, permohonan {no_permohonan} Anda saat ini: {tahapan}."</em>
                            </div>
                            <div id="var_hint_riwayat" class="hidden text-xs text-base-content/50 mt-2">
                                Ini teks PEMBUKA doang (baris riwayatnya tetap format baku di bawahnya). Variabel: <code>{nama}</code> <code>{no_permohonan}</code>
                                <br>Kosongin buat pakai default: <em>"Riwayat notifikasi permohonan {no_permohonan}:"</em>
                            </div>
                            <div id="var_hint_antrian" class="hidden text-xs text-base-content/50 mt-2">
                                Khusus pegawai -- identitas otomatis kedeteksi dari nomor WA-nya, gak perlu validasi apa-apa. Ini teks PEMBUKA doang (daftar antriannya tetap format baku di bawahnya). Variabel: <code>{nama_pegawai}</code> <code>{posisi_pegawai}</code> <code>{jumlah}</code>
                            </div>
                            <div id="var_hint_info" class="hidden text-xs text-base-content/50 mt-2">
                                Khusus pegawai -- identitas otomatis kedeteksi dari nomor WA-nya. Variabel: <code>{nama_pegawai}</code> <code>{posisi_pegawai}</code> <code>{no_hp_pegawai}</code>
                            </div>
                            <p class="text-xs text-base-content/50 mt-1">Ini teks bawaan sistem -- edit sesuka kamu. Kosongin lagi kalau mau balik pakai default (otomatis ikut update kalau sistemnya nanti direvisi). Bisa pakai *bold*, _italic_, ```monospace```.</p>
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

            <!-- WhatsApp Preview Section -->
            <div class="card bg-base-100 shadow-2xl border border-base-300" id="preview_column">
                <div class="card-body p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-success/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-success" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold">Preview WhatsApp</h2>
                    </div>

                    <div class="bg-gradient-to-b from-green-400 to-green-600 rounded-3xl p-1 shadow-2xl">
                        <div class="bg-green-50 rounded-3xl overflow-hidden">
                            <div class="bg-green-500 text-white px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold" id="preview-contact-name">SITAKU Official</h3>
                                        <p class="text-xs font-semibold">online</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 min-h-80 p-4 space-y-4"
                                style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%221%22 fill=%22%23ffffff%22 opacity=%220.1%22/></svg>'); background-size: 20px;">
                                <div class="flex justify-start">
                                    <div class="w-full">
                                        <div class="bg-white rounded-2xl rounded-tl-md p-4 shadow-md border border-gray-100">
                                            <div id="whatsapp-preview" class="text-sm text-gray-800 leading-relaxed whitespace-pre-wrap">
                                                <em class="text-gray-500">Pilih jenis aksi & isi template buat lihat pratinjau...</em>
                                            </div>
                                            <div class="flex justify-end mt-2">
                                                <span class="text-xs text-black" id="preview-time">12:34</span>
                                            </div>
                                        </div>
                                        <div class="text-xs text-center mt-1 text-gray-500">SITAKU Official</div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-200 p-3 flex items-center gap-3">
                                <div class="flex-1 bg-white rounded-full px-4 py-2">
                                    <span class="text-gray-800 text-sm">Ketik pesan...</span>
                                </div>
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-info/10 border border-info/20 rounded-xl">
                        <h4 class="font-semibold text-sm flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            Data Contoh
                        </h4>
                        <div class="text-md space-y-1">
                            <div>Nama: <strong>Budi Santoso</strong></div>
                            <div>No. Permohonan: <strong>REG-2026-001</strong></div>
                            <div>Jenis Izin: <strong>Izin Reklame</strong></div>
                            <div>Tahapan: <strong>Verifikasi Dokumen</strong></div>
                            <div>Status: <strong>proses</strong></div>
                            <div>No. HP: <strong>08123456789</strong></div>
                        </div>
                    </div>

                    <div id="menu_list_note" class="hidden mt-4 text-xs text-base-content/50">
                        Item ini muncul sebagai satu baris di daftar menu (bukan pesan tersendiri) -- lihat contoh format daftar menu di halaman utama Custom Menu WA.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast toast-top toast-end z-50" id="toastContainer"></div>

<script>
    const DEFAULT_TEMPLATES = {
        cek_status: 'Status permohonan {no_permohonan}:\nTahapan: {tahapan}\nStatus: {status}',
        riwayat_tahapan: 'Riwayat notifikasi permohonan {no_permohonan}:',
        antrian_pegawai: 'Antrian di posisi {posisi_pegawai} ({jumlah} permohonan):',
        info_pegawai: 'Nama: {nama_pegawai}\nPosisi: {posisi_pegawai}\nNo. HP: {no_hp_pegawai}',
    };

    function toggleActionFields() {
        const type = document.getElementById('action_type').value;
        const needsTemplate = ['cek_status', 'riwayat_tahapan', 'pesan_custom', 'antrian_pegawai', 'info_pegawai'].includes(type);
        const templateInput = document.getElementById('template_input');

        document.getElementById('template_field').classList.toggle('hidden', !needsTemplate);
        document.getElementById('submenu_hint').classList.toggle('hidden', type !== 'submenu');
        document.getElementById('menu_list_note').classList.toggle('hidden', needsTemplate);

        document.getElementById('var_hint_pesan_custom').classList.toggle('hidden', type !== 'pesan_custom');
        document.getElementById('var_hint_status').classList.toggle('hidden', type !== 'cek_status');
        document.getElementById('var_hint_riwayat').classList.toggle('hidden', type !== 'riwayat_tahapan');
        document.getElementById('var_hint_antrian').classList.toggle('hidden', type !== 'antrian_pegawai');
        document.getElementById('var_hint_info').classList.toggle('hidden', type !== 'info_pegawai');

        // Kalau textarea-nya kosong (belum pernah di-custom), tampilin langsung
        // teks bawaan sistem sebagai isi awal -- biar user liat & tinggal edit,
        // bukan nebak-nebak dari placeholder doang.
        if (templateInput.value.trim() === '' && DEFAULT_TEMPLATES[type]) {
            templateInput.value = DEFAULT_TEMPLATES[type];
        }

        updatePreview();
    }

    function updatePreview() {
        const type = document.getElementById('action_type').value;
        const preview = document.getElementById('whatsapp-preview');
        const templateInput = document.getElementById('template_input');
        const charCount = document.getElementById('charCount');

        let text = templateInput.value.trim();
        charCount.textContent = templateInput.value.length;

        if (!text) {
            if (type === 'riwayat_tahapan') {
                text = 'Riwayat notifikasi permohonan {no_permohonan}:\n- 10 Agu 2026 10:00: Verifikasi Dokumen\n- 11 Agu 2026 14:20: Cetak Izin';
            } else if (type === 'cek_status') {
                text = 'Status permohonan {no_permohonan}:\nTahapan: {tahapan}\nStatus: {status}';
            } else {
                preview.innerHTML = '<em class="text-gray-500">Pilih jenis aksi & isi template buat lihat pratinjau...</em>';
                return;
            }
        }

        text = text.replace(/\{nama\}/g, 'Budi Santoso');
        text = text.replace(/\{no_permohonan\}/g, 'REG-2026-001');
        text = text.replace(/\{nama_izin\}/g, 'Izin Reklame');
        text = text.replace(/\{tahapan\}/g, 'Verifikasi Dokumen');
        text = text.replace(/\{status\}/g, 'proses');
        text = text.replace(/\{link_izin\}/g, 'https://sitaku.test/dok/xyz');
        text = text.replace(/\{no_hp\}/g, '08123456789');
        text = text.replace(/\{nama_pegawai\}/g, 'Siti Aminah');
        text = text.replace(/\{posisi_pegawai\}/g, 'Verifikasi');
        text = text.replace(/\{no_hp_pegawai\}/g, '081234567890');
        text = text.replace(/\{jumlah\}/g, '3');

        if (type === 'riwayat_tahapan' && !templateInput.value.trim().includes('\n')) {
            text += '\n- 10 Agu 2026 10:00: Verifikasi Dokumen\n- 11 Agu 2026 14:20: Cetak Izin';
        }
        if (type === 'antrian_pegawai' && !templateInput.value.trim().includes('\n')) {
            text += '\n- REG-2026-001 | Budi Santoso\n- REG-2026-002 | Siti Rahayu';
        }

        text = text.replace(/\n/g, '<br>');
        text = text.replace(/\*_(.*?)_\*/g, '<strong><em>$1</em></strong>');
        text = text.replace(/\*(.*?)\*/g, '<strong>$1</strong>');
        text = text.replace(/_(.*?)_/g, '<em>$1</em>');
        text = text.replace(/```(.*?)```/gs, '<code>$1</code>');

        preview.innerHTML = text;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const now = new Date();
        document.getElementById('preview-time').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

        toggleActionFields();

        document.getElementById('template_input').addEventListener('input', updatePreview);

        @if (session('error'))
            showToast('error', "{{ session('error') }}");
        @endif
        @if (session('success'))
            showToast('success', "{{ session('success') }}");
        @endif
    });
</script>
@endsection