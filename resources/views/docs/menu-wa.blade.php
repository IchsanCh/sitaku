@extends('user.layout3')

@section('title', 'Menu WA (Alur Layanan)')

@section('meta_description',
    'Pelajari cara kerja Menu WA di Sitaku -- sistem alur otomatis (state machine) yang membalas
    pesan WhatsApp pemohon dan pegawai sesuai trigger yang instansi atur sendiri.')

@section('og_description',
    'Dokumentasi Menu WA Sitaku: trigger, tipe aksi, submenu, dan cara mengatur alur layanan
    WhatsApp otomatis untuk instansi Anda.')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h1 class="card-title text-3xl font-bold mb-4">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                Menu WA (Alur Layanan)
            </h1>

            <div class="alert alert-info mb-6 font-semibold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Menu WA adalah "alur otomatis" (state machine) yang membalas pesan WhatsApp
                    pemohon atau pegawai berdasarkan kata kunci (trigger) yang mereka ketik --
                    tanpa admin harus balas manual.</span>
            </div>

            <h2 class="text-xl font-bold mb-3">Cara Kerjanya</h2>
            <p class="font-semibold mb-4">
                Ketika pemohon atau pegawai mengirim pesan ke nomor WhatsApp instansi, sistem
                mencocokkan isi pesan dengan trigger yang sudah diatur. Kalau cocok, bot langsung
                membalas sesuai tipe aksi (action type) yang dipilih untuk trigger tersebut. Kalau
                gak ada yang cocok, menu yang ditandai <span class="badge badge-ghost badge-sm">Default</span>
                yang akan tampil.
            </p>

            <h2 class="text-xl font-bold mb-3">Audience</h2>
            <p class="font-semibold mb-4">
                Setiap menu bisa dibatasi buat siapa: <span class="badge badge-outline">Pemohon saja</span>,
                <span class="badge badge-outline">Pegawai saja</span>, atau <span class="badge badge-outline">Pemohon & Pegawai</span>.
                Nomor yang sama bisa dapat balasan beda tergantung dia terdaftar sebagai pemohon atau pegawai.
            </p>

            <h2 class="text-xl font-bold mb-3">Tipe Aksi</h2>
            <p class="font-semibold mb-4">Tersedia di semua tier (asal punya feature Menu WA):</p>
            <div class="overflow-x-auto mb-4">
                <table class="table table-sm">
                    <thead>
                        <tr><th>Action Type</th><th>Fungsi</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><code>cek_status</code></td><td>Balas status permohonan terbaru</td></tr>
                        <tr><td><code>riwayat_tahapan</code></td><td>Balas riwayat tahapan permohonan</td></tr>
                        <tr><td><code>antrian_pegawai</code></td><td>Balas info antrian buat pegawai</td></tr>
                        <tr><td><code>info_pegawai</code></td><td>Balas info terkait pegawai</td></tr>
                        <tr><td><code>exit</code></td><td>Keluar dari sesi/alur yang sedang jalan</td></tr>
                    </tbody>
                </table>
            </div>

            <p class="font-semibold mb-2">Butuh feature tambahan (tergantung paket instansi):</p>
            <div class="overflow-x-auto mb-6">
                <table class="table table-sm">
                    <thead>
                        <tr><th>Action Type</th><th>Fungsi</th><th>Feature</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>pesan_custom</code></td>
                            <td>Balas teks custom yang instansi tulis sendiri</td>
                            <td><span class="badge badge-warning badge-sm">Premium</span></td>
                        </tr>
                        <tr>
                            <td><code>submenu</code></td>
                            <td>Bikin menu bertingkat (nested) di bawah trigger ini</td>
                            <td><span class="badge badge-warning badge-sm">Premium</span></td>
                        </tr>
                        <tr>
                            <td><code>live_support</code></td>
                            <td>Alihkan percakapan ke admin manusia (live chat)</td>
                            <td><span class="badge badge-warning badge-sm">Premium</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-success mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm">Trigger dengan <code>live_support</code> yang ngarahin pemohon
                    ke admin manusia. Lihat <a href="/docs/live-support/chat" class="link link-primary font-semibold">dokumentasi Live Support</a>
                    buat detail alur chat-nya.</span>
            </div>

            <h2 class="text-xl font-bold mb-3">Cara Setup</h2>
            <div class="space-y-4">
                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="menu-wa-accordion" checked="checked" />
                    <div class="collapse-title text-lg font-medium flex items-center gap-3">
                        <div class="badge badge-primary badge-lg">1</div>
                        <strong>Buka Menu WA</strong>
                    </div>
                    <div class="collapse-content">
                        <p class="font-semibold">Dari sidebar, klik <strong>Menu WA</strong>. Di sini kelihatan semua
                            trigger yang udah instansi buat, termasuk submenu-nya.</p>
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="menu-wa-accordion" />
                    <div class="collapse-title text-lg font-medium flex items-center gap-3">
                        <div class="badge badge-secondary badge-lg">2</div>
                        <strong>Tambah Trigger Baru</strong>
                    </div>
                    <div class="collapse-content">
                        <p class="font-semibold">Klik "Tambah Menu", isi trigger (kata kunci yang diketik pemohon/pegawai),
                            label (nama tampilan), audience, dan action type. Kalau action type-nya butuh feature premium
                            tapi tier instansi belum punya, opsinya bakal ke-lock.</p>
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="menu-wa-accordion" />
                    <div class="collapse-title text-lg font-medium flex items-center gap-3">
                        <div class="badge badge-accent badge-lg">3</div>
                        <strong>Atur Submenu (Opsional)</strong>
                    </div>
                    <div class="collapse-content">
                        <p class="font-semibold">Kalau action type-nya <code>submenu</code>, trigger itu bisa punya
                            menu anak di bawahnya -- berguna buat alur bertingkat (misal: "Layanan" → "Perizinan" / "Non-Perizinan").</p>
                    </div>
                </div>
            </div>

            <div class="divider mt-8"></div>
            <div class="card bg-base-200 mt-6">
                <div class="card-body text-center">
                    <h3 class="card-title justify-center text-xl mb-2">Butuh Bantuan?</h3>
                    <p class="mb-4 font-semibold">Jika mengalami kendala, silakan hubungi tim support kami.</p>
                    <div class="card-actions justify-center">
                        <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Support"
                            class="btn bgc1 text-white lisaa font-semibold">Hubungi Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection