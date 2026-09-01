@extends('user.layout3')

@section('title', 'Menu WA (Alur Layanan)')

@section('meta_description',
    'Pelajari cara kerja Menu WA di Exavro, sistem alur otomatis (state machine) yang membalas
    pesan WhatsApp pemohon dan pegawai sesuai trigger yang diatur oleh instansi.')

@section('og_description',
    'Dokumentasi Menu WA Exavro: trigger, tipe aksi, submenu, dan cara mengatur alur layanan
    WhatsApp otomatis untuk instansi Anda.')

@section('content')
    <h1 class="xv-display text-3xl font-bold mb-4" style="color: var(--xv-text);">Menu WA (Alur Layanan)</h1>

    <div class="xv-callout xv-callout--info mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Menu WA merupakan alur otomatis (state machine) yang membalas pesan WhatsApp
            dari pemohon maupun pegawai berdasarkan kata kunci (trigger) yang mereka ketik,
            tanpa perlu dibalas secara manual oleh admin.</span>
    </div>

    <h2 class="text-xl font-bold mb-3">Cara Kerja</h2>
    <p class="mb-6">
        Ketika pemohon atau pegawai mengirim pesan ke nomor WhatsApp instansi, sistem akan
        mencocokkan isi pesan tersebut dengan trigger yang telah diatur. Apabila cocok, bot
        akan langsung membalas sesuai tipe aksi (action type) yang dipilih untuk trigger
        tersebut. Apabila tidak ada trigger yang cocok, menu yang ditandai
        <span class="xv-tag xv-tag--neutral">Default</span> yang akan ditampilkan.
    </p>

    <h2 class="text-xl font-bold mb-3">Audiens</h2>
    <p class="mb-6">
        Setiap menu dapat dibatasi berdasarkan audiensnya: <span class="xv-tag xv-tag--neutral">Pemohon saja</span>,
        <span class="xv-tag xv-tag--neutral">Pegawai saja</span>, atau <span class="xv-tag xv-tag--neutral">Pemohon &amp; Pegawai</span>.
        Nomor yang sama dapat menerima balasan yang berbeda, tergantung apakah nomor tersebut
        terdaftar sebagai pemohon atau sebagai pegawai.
    </p>

    <h2 class="text-xl font-bold mb-3">Tipe Aksi</h2>
    <p class="mb-3">Tersedia pada seluruh tier, selama instansi memiliki feature Menu WA:</p>
    <div class="overflow-x-auto mb-6 xv-docs-card">
        <table class="xv-docs-table">
            <thead><tr><th>Action Type</th><th>Fungsi</th></tr></thead>
            <tbody>
                <tr><td><code>cek_status</code></td><td>Membalas status permohonan terbaru</td></tr>
                <tr><td><code>riwayat_tahapan</code></td><td>Membalas riwayat tahapan permohonan</td></tr>
                <tr><td><code>antrian_pegawai</code></td><td>Membalas informasi antrean untuk pegawai</td></tr>
                <tr><td><code>info_pegawai</code></td><td>Membalas informasi terkait pegawai</td></tr>
                <tr><td><code>exit</code></td><td>Mengakhiri sesi atau alur yang sedang berjalan</td></tr>
            </tbody>
        </table>
    </div>

    <p class="mb-3">Membutuhkan feature tambahan, tergantung paket yang dimiliki instansi:</p>
    <div class="overflow-x-auto mb-8 xv-docs-card">
        <table class="xv-docs-table">
            <thead><tr><th>Action Type</th><th>Fungsi</th><th>Feature</th></tr></thead>
            <tbody>
                <tr>
                    <td><code>pesan_custom</code></td>
                    <td>Membalas teks khusus yang ditulis sendiri oleh instansi</td>
                    <td><span class="xv-tag" style="background: var(--xv-warning-bg); color: var(--xv-warning);">Premium</span></td>
                </tr>
                <tr>
                    <td><code>submenu</code></td>
                    <td>Membuat menu bertingkat (nested) di bawah trigger ini</td>
                    <td><span class="xv-tag" style="background: var(--xv-warning-bg); color: var(--xv-warning);">Premium</span></td>
                </tr>
                <tr>
                    <td><code>live_support</code></td>
                    <td>Mengalihkan percakapan kepada admin manusia (live chat)</td>
                    <td><span class="xv-tag" style="background: var(--xv-warning-bg); color: var(--xv-warning);">Premium</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="xv-callout xv-callout--success mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Trigger dengan tipe aksi <code>live_support</code> akan mengarahkan
            pemohon kepada admin manusia. Silakan lihat <a href="/docs/live-support/chat">dokumentasi Live Support</a>
            untuk mempelajari alur percakapannya lebih lanjut.</span>
    </div>

    <h2 class="text-xl font-bold mb-3">Cara Pengaturan</h2>
    <div class="xv-step-list mb-10">
        <div class="xv-step">
            <div class="xv-step-num">1</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Membuka Menu WA</h3>
                <p>Pada sidebar, klik <strong>Menu WA</strong>. Halaman ini menampilkan
                    seluruh trigger yang telah dibuat oleh instansi, termasuk submenu di dalamnya.</p>
            </div>
        </div>
        <div class="xv-step">
            <div class="xv-step-num">2</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Menambahkan Trigger Baru</h3>
                <p>Klik "Tambah Menu", kemudian isi trigger (kata kunci yang akan
                    diketik oleh pemohon atau pegawai), label (nama tampilan), audiens, dan tipe aksi. Apabila
                    tipe aksi yang dipilih membutuhkan feature premium yang belum dimiliki oleh tier instansi,
                    opsi tersebut akan terkunci.</p>
            </div>
        </div>
        <div class="xv-step">
            <div class="xv-step-num">3</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Mengatur Submenu (Opsional)</h3>
                <p>Apabila tipe aksi yang dipilih adalah <code>submenu</code>, trigger
                    tersebut dapat memiliki menu turunan di bawahnya. Fitur ini berguna untuk membangun alur
                    bertingkat, misalnya menu "Layanan" yang bercabang menjadi "Perizinan" dan "Non-Perizinan".</p>
            </div>
        </div>
    </div>

    <div class="xv-docs-card p-8 text-center">
        <h3 class="xv-display text-xl font-bold mb-2" style="color: var(--xv-text);">Butuh Bantuan?</h3>
        <p class="mb-4">Jika mengalami kendala, silakan hubungi tim support kami.</p>
        <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Support" class="xv-btn xv-btn-accent">Hubungi Support</a>
    </div>
@endsection