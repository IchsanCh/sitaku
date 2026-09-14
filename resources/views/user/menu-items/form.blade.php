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
                            <select id="audience_select" class="select select-bordered w-full" required>
                                <option value="both" {{ old('audience', $menuItem->audience ?? 'both') === 'both' ? 'selected' : '' }}>Pemohon & Pegawai</option>
                                <option value="pemohon" {{ old('audience', $menuItem->audience ?? '') === 'pemohon' ? 'selected' : '' }}>Pemohon saja</option>
                                <option value="pegawai" {{ old('audience', $menuItem->audience ?? '') === 'pegawai' ? 'selected' : '' }}>Pegawai saja</option>
                            </select>
                            <input type="hidden" name="audience" id="audience_hidden" value="{{ old('audience', $menuItem->audience ?? 'both') }}">
                            <p class="text-xs text-base-content/50 mt-1" id="audience_hint">Menu ini cuma muncul buat peran yang dipilih pas mereka chat WA.</p>
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
                                Belum ada data pemohon di titik ini (belum lewat validasi), tapi bisa pakai variabel umum: <code>{username}</code> <code>{tanggal}</code> <code>{jam}</code>.
                                Kalau menu ini ditujukan buat pegawai, variabel pegawai juga otomatis kedeteksi dari nomor WA-nya: <code>{nama_pegawai}</code> <code>{posisi_pegawai}</code> <code>{no_hp_pegawai}</code>.
                            </div>
                            <div id="var_hint_status" class="hidden text-xs text-base-content/50 mt-2">
                                Variabel yang bisa dipakai (klik "+ Sisipkan Variable" buat lihat semuanya): <code>{nama}</code> <code>{no_permohonan}</code> <code>{nama_izin}</code> <code>{tahapan}</code> <code>{status}</code> <code>{link_izin}</code> <code>{no_hp}</code> <code>{tgl_pengajuan}</code> <code>{username}</code> <code>{tanggal}</code> <code>{jam}</code>
                                <br>Contoh: <em>"Halo {nama}, permohonan {no_permohonan} Anda saat ini: {tahapan}."</em>
                            </div>
                            <div id="var_hint_riwayat" class="hidden text-xs text-base-content/50 mt-2">
                                Ini teks PEMBUKA doang (baris riwayatnya tetap format baku di bawahnya, otomatis diambil dari log notifikasi). Variabel yang sama kayak Cek Status juga bisa dipakai di sini.
                                <br>Kosongin buat pakai default: <em>"Riwayat notifikasi permohonan {no_permohonan}:"</em>
                            </div>
                            <div id="var_hint_antrian" class="hidden text-xs text-base-content/50 mt-2">
                                Khusus pegawai -- identitas otomatis kedeteksi dari nomor WA-nya, gak perlu validasi apa-apa. Antrian dihitung dari permohonan yang tahapannya cocok sama posisi pegawai ini DAN statusnya masih "proses" (yang udah selesai/sudah gak dihitung). Ini teks PEMBUKA doang -- format tiap baris antriannya diatur terpisah di bawah.
                            </div>
                            <div id="var_hint_info" class="hidden text-xs text-base-content/50 mt-2">
                                Khusus pegawai -- identitas otomatis kedeteksi dari nomor WA-nya. Variabel: <code>{nama_pegawai}</code> <code>{posisi_pegawai}</code> <code>{no_hp_pegawai}</code> <code>{username}</code> <code>{tanggal}</code> <code>{jam}</code>
                            </div>

                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-base-content/50">Ini teks bawaan sistem -- edit sesuka kamu. Kosongin lagi kalau mau balik pakai default. Bisa pakai *bold*, _italic_, ```monospace```.</p>
                                <div class="dropdown dropdown-end shrink-0 ml-2" id="var_picker_template">
                                    <div tabindex="0" role="button" class="btn btn-xs btn-outline">+ Sisipkan Variable</div>
                                    <ul tabindex="0" class="dropdown-content menu menu-sm bg-base-100 rounded-box z-10 w-56 p-2 shadow border border-base-300"></ul>
                                </div>
                            </div>
                        </div>

                        <div id="row_template_field" class="hidden mt-4">
                            <div class="flex justify-between items-baseline">
                                <label class="label"><span class="label-text font-medium">Format Baris Antrian</span></label>
                                <span class="text-xs text-base-content/50"><span id="rowCharCount">0</span>/300</span>
                            </div>
                            <textarea name="row_template" id="row_template_input" rows="2" class="textarea textarea-bordered w-full font-mono text-sm"
                                maxlength="300" placeholder="- {no_permohonan} | {nama}">{{ old('row_template', $menuItem->action_config['row_template'] ?? '') }}</textarea>

                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-base-content/50">
                                    Ini format 1 BARIS, diulang buat tiap permohonan yang lagi ngantri. Variabel bebas dipilih dari data permohonan (nomor, tahapan, status, tanggal pengajuan, dll) -- gak kaku kayak sebelumnya. Kosongin buat pakai default: <code>- {no_permohonan} | {nama}</code>
                                </p>
                                <div class="dropdown dropdown-end shrink-0 ml-2" id="var_picker_row_template">
                                    <div tabindex="0" role="button" class="btn btn-xs btn-outline">+ Sisipkan Variable</div>
                                    <ul tabindex="0" class="dropdown-content menu menu-sm bg-base-100 rounded-box z-10 w-56 p-2 shadow border border-base-300"></ul>
                                </div>
                            </div>
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
    // Ternyata file ini manggil showToast() di bawah tapi gak pernah define-nya
    // sendiri (beda dari kebanyakan halaman lain yang masing-masing punya definisi
    // lokal) -- makanya toast error/success gak pernah muncul. Ditambahin di sini,
    // pola yang sama kayak di halaman lain.
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

    const DEFAULT_TEMPLATES = {
        cek_status: 'Status permohonan {no_permohonan}:\nTahapan: {tahapan}\nStatus: {status}',
        riwayat_tahapan: 'Riwayat notifikasi permohonan {no_permohonan}:',
        antrian_pegawai: 'Antrian di posisi {posisi_pegawai} ({jumlah} permohonan):',
        info_pegawai: 'Nama: {nama_pegawai}\nPosisi: {posisi_pegawai}\nNo. HP: {no_hp_pegawai}',
    };
    const DEFAULT_ROW_TEMPLATE = '- {no_permohonan} | {nama}';

    // Kosakata variabel, dipecah per konteks data -- satu-satunya tempat buat
    // nambah variabel baru di sisi tampilan (harus sinkron sama
    // generalVariables()/pemohonVariables()/pegawaiVariables() di
    // WhatsappStateMachineService.php). Tinggal nambah 1 baris di sini,
    // otomatis kepilih di semua jenis aksi yang makai kelompok itu.
    const GENERAL_VARS = [
        ['{username}', 'Nama Instansi'], ['{tanggal}', 'Tanggal'], ['{jam}', 'Jam'],
    ];
    const PEMOHON_VARS = [
        ['{nama}', 'Nama Pemohon'], ['{no_permohonan}', 'No. Permohonan'], ['{nama_izin}', 'Nama Izin'],
        ['{tahapan}', 'Tahapan'], ['{status}', 'Status'], ['{link_izin}', 'Link Izin'],
        ['{no_hp}', 'No. HP Pemohon'], ['{tgl_pengajuan}', 'Tanggal Pengajuan'],
    ];
    const PEGAWAI_VARS = [
        ['{nama_pegawai}', 'Nama Pegawai'], ['{posisi_pegawai}', 'Posisi Pegawai'], ['{no_hp_pegawai}', 'No. HP Pegawai'],
    ];

    const VARIABLE_SETS = {
        cek_status: { template: [...GENERAL_VARS, ...PEMOHON_VARS] },
        riwayat_tahapan: { template: [...GENERAL_VARS, ...PEMOHON_VARS] },
        info_pegawai: { template: [...GENERAL_VARS, ...PEGAWAI_VARS] },
        pesan_custom: { template: [...GENERAL_VARS, ...PEGAWAI_VARS] },
        antrian_pegawai: {
            template: [...GENERAL_VARS, ...PEGAWAI_VARS, ['{jumlah}', 'Jumlah Antrian']],
            row_template: [...PEMOHON_VARS],
        },
    };

    function insertAtCursor(textarea, text) {
        const start = textarea.selectionStart ?? textarea.value.length;
        const end = textarea.selectionEnd ?? textarea.value.length;
        textarea.value = textarea.value.slice(0, start) + text + textarea.value.slice(end);
        const newPos = start + text.length;
        textarea.focus();
        textarea.setSelectionRange(newPos, newPos);
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
    }

    // Isi ulang isi dropdown "+ Sisipkan Variable" sesuai action_type yang
    // lagi dipilih. pickerId = id div.dropdown, textareaId = target textarea,
    // fieldKey = 'template' atau 'row_template' (buat nentuin pool mana dari VARIABLE_SETS).
    function populateVariablePicker(pickerId, textareaId, fieldKey, type) {
        const picker = document.getElementById(pickerId);
        const list = picker.querySelector('.dropdown-content');
        const variables = (VARIABLE_SETS[type] && VARIABLE_SETS[type][fieldKey]) || [];

        list.innerHTML = '';
        if (variables.length === 0) {
            picker.classList.add('hidden');
            return;
        }
        picker.classList.remove('hidden');

        variables.forEach(([tag, label]) => {
            const li = document.createElement('li');
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'flex justify-between gap-2';
            btn.innerHTML = `<span>${label}</span><code class="text-xs opacity-60">${tag}</code>`;
            btn.addEventListener('mousedown', (e) => e.preventDefault()); // biar cursor position di textarea gak ilang
            btn.addEventListener('click', () => {
                insertAtCursor(document.getElementById(textareaId), tag);
                document.activeElement.blur(); // nutup dropdown-nya (daisyUI dropdown = focus-based)
            });
            li.appendChild(btn);
            list.appendChild(li);
        });
    }

    // Action_type yang audience-nya WAJIB nilai tertentu -- gak boleh dipilih bebas.
    // Sinkron sama MenuItem::ROLE_LOCKED_ACTIONS di backend (yang tetap validasi ulang,
    // ini cuma layer UI biar gak ngasal milih di awal).
    const ROLE_LOCKED_ACTIONS = @json($roleLockedActions ?? []);

    const audienceSelect = document.getElementById('audience_select');
    const audienceHidden = document.getElementById('audience_hidden');
    const audienceHint = document.getElementById('audience_hint');
    const audienceLabels = { pemohon: 'Pemohon saja', pegawai: 'Pegawai saja', both: 'Pemohon & Pegawai' };

    audienceSelect.addEventListener('change', function () {
        audienceHidden.value = audienceSelect.value;
    });

    function applyAudienceLock(type) {
        const lockedTo = ROLE_LOCKED_ACTIONS[type];

        if (lockedTo) {
            audienceSelect.value = lockedTo;
            audienceHidden.value = lockedTo;
            audienceSelect.disabled = true;
            audienceHint.textContent = `Aksi ini khusus buat "${audienceLabels[lockedTo]}" -- audience dikunci otomatis, gak bisa diganti.`;
        } else {
            audienceSelect.disabled = false;
            audienceHidden.value = audienceSelect.value;
            audienceHint.textContent = 'Menu ini cuma muncul buat peran yang dipilih pas mereka chat WA.';
        }
    }

    function toggleActionFields() {
        const type = document.getElementById('action_type').value;
        const needsTemplate = ['cek_status', 'riwayat_tahapan', 'pesan_custom', 'antrian_pegawai', 'info_pegawai'].includes(type);
        const templateInput = document.getElementById('template_input');
        const rowTemplateInput = document.getElementById('row_template_input');

        applyAudienceLock(type);

        document.getElementById('template_field').classList.toggle('hidden', !needsTemplate);
        document.getElementById('row_template_field').classList.toggle('hidden', type !== 'antrian_pegawai');
        document.getElementById('submenu_hint').classList.toggle('hidden', type !== 'submenu');
        document.getElementById('menu_list_note').classList.toggle('hidden', needsTemplate);

        document.getElementById('var_hint_pesan_custom').classList.toggle('hidden', type !== 'pesan_custom');
        document.getElementById('var_hint_status').classList.toggle('hidden', type !== 'cek_status');
        document.getElementById('var_hint_riwayat').classList.toggle('hidden', type !== 'riwayat_tahapan');
        document.getElementById('var_hint_antrian').classList.toggle('hidden', type !== 'antrian_pegawai');
        document.getElementById('var_hint_info').classList.toggle('hidden', type !== 'info_pegawai');

        populateVariablePicker('var_picker_template', 'template_input', 'template', type);
        populateVariablePicker('var_picker_row_template', 'row_template_input', 'row_template', type);

        // Kalau textarea-nya kosong (belum pernah di-custom), tampilin langsung
        // teks bawaan sistem sebagai isi awal -- biar user liat & tinggal edit,
        // bukan nebak-nebak dari placeholder doang.
        if (templateInput.value.trim() === '' && DEFAULT_TEMPLATES[type]) {
            templateInput.value = DEFAULT_TEMPLATES[type];
        }
        if (type === 'antrian_pegawai' && rowTemplateInput.value.trim() === '') {
            rowTemplateInput.value = DEFAULT_ROW_TEMPLATE;
        }

        updatePreview();
    }

    function updatePreview() {
        const type = document.getElementById('action_type').value;
        const preview = document.getElementById('whatsapp-preview');
        const templateInput = document.getElementById('template_input');
        const rowTemplateInput = document.getElementById('row_template_input');
        const charCount = document.getElementById('charCount');
        const rowCharCount = document.getElementById('rowCharCount');

        let text = templateInput.value.trim();
        charCount.textContent = templateInput.value.length;
        rowCharCount.textContent = rowTemplateInput.value.length;

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
        text = text.replace(/\{link_izin\}/g, 'https://exavro.test/dok/xyz');
        text = text.replace(/\{no_hp\}/g, '08123456789');
        text = text.replace(/\{tgl_pengajuan\}/g, '10 Agu 2026');
        text = text.replace(/\{nama_pegawai\}/g, 'Siti Aminah');
        text = text.replace(/\{posisi_pegawai\}/g, 'Verifikasi');
        text = text.replace(/\{no_hp_pegawai\}/g, '081234567890');
        text = text.replace(/\{jumlah\}/g, '3');
        text = text.replace(/\{username\}/g, '{{ addslashes($user->name ?? "Instansi Contoh") }}');
        text = text.replace(/\{tanggal\}/g, new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }));
        text = text.replace(/\{jam\}/g, new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }));

        if (type === 'riwayat_tahapan' && !templateInput.value.trim().includes('\n')) {
            text += '\n- 10 Agu 2026 10:00: Verifikasi Dokumen\n- 11 Agu 2026 14:20: Cetak Izin';
        }
        if (type === 'antrian_pegawai') {
            const rowTemplate = rowTemplateInput.value.trim() || DEFAULT_ROW_TEMPLATE;
            const sampleRows = [
                { '{no_permohonan}': 'REG-2026-001', '{nama}': 'Budi Santoso', '{nama_izin}': 'Izin Reklame', '{tahapan}': 'Verifikasi Dokumen', '{status}': 'proses', '{link_izin}': 'https://exavro.test/dok/abc', '{no_hp}': '08123456789', '{tgl_pengajuan}': '10 Agu 2026' },
                { '{no_permohonan}': 'REG-2026-002', '{nama}': 'Siti Rahayu', '{nama_izin}': 'Izin Usaha', '{tahapan}': 'Verifikasi Dokumen', '{status}': 'proses', '{link_izin}': 'https://exavro.test/dok/xyz', '{no_hp}': '08129876543', '{tgl_pengajuan}': '12 Agu 2026' },
            ];
            const rows = sampleRows.map((sample) => {
                let rowText = rowTemplate;
                Object.entries(sample).forEach(([tag, value]) => {
                    rowText = rowText.split(tag).join(value);
                });
                return rowText;
            });
            text += '\n' + rows.join('\n');
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
        document.getElementById('row_template_input').addEventListener('input', updatePreview);

        @if (session('error'))
            showToast('error', "{{ session('error') }}");
        @endif
        @if (session('success'))
            showToast('success', "{{ session('success') }}");
        @endif
    });
</script>
@endsection