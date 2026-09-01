@extends('user.layout3')

@section('title', 'Getting Started')

@section('meta_description',
    'Mulai gunakan Exavro dengan panduan singkat ini. Pelajari cara setup awal, konfigurasi
    unit, dan tips cepat untuk menjalankan sistem secara optimal.')

@section('og_description',
    'Panduan lengkap untuk memulai penggunaan Exavro. Ikuti langkah-langkah mudah untuk mengatur
    akun, unit, dan fitur utama dengan cepat dan efisien.')

@section('content')
    <h1 class="xv-display text-3xl font-bold mb-4" style="color: var(--xv-text);">Getting Started</h1>

    <div class="xv-callout xv-callout--info mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Ikuti langkah-langkah berikut untuk mulai menggunakan Exavro secara optimal:</span>
    </div>

    <div class="xv-step-list mb-10">
        <!-- Step 1 -->
        <div class="xv-step">
            <div class="xv-step-num">1</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Registrasi Akun</h3>
                <p class="mb-3">
                    Buka halaman <a href="{{ url('/signup') }}" title="Sign Up">Sign Up</a>
                    dan buat akun baru dengan email dan password yang valid.
                </p>
                <a href="{{ url('/signup') }}" title="Sign Up" class="xv-btn xv-btn-ink xv-btn-sm">Daftar Sekarang</a>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="xv-step">
            <div class="xv-step-num">2</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Login ke Sistem</h3>
                <p class="mb-3">
                    Setelah berhasil registrasi, masuk melalui halaman <a href="{{ url('/login') }}" title="Login">Login</a>.
                </p>
                <a href="{{ url('/login') }}" title="Login" class="xv-btn xv-btn-ink xv-btn-sm">Login</a>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="xv-step">
            <div class="xv-step-num">3</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Lengkapi Data di Menu Pengaturan</h3>
                <p class="mb-3">
                    Buka menu <a href="{{ route('setting.user') }}" title="pengaturan">Pengaturan</a>
                    untuk mengisi data unit dan token fonnte, kemudian isi pegawai pada menu
                    <a href="{{ route('user.pegawai') }}" title="pegawai">Pegawai</a>.
                </p>
                <div class="xv-callout xv-callout--info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Endpoint API pemohon kini dikonfigurasi secara terpusat oleh tim Exavro,
                        sehingga instansi tidak perlu melakukan pengaturan secara manual.</span>
                </div>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="xv-step">
            <div class="xv-step-num">4</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Hubungkan Webhook Fonnte</h3>
                <p class="mb-3">
                    Langkah ini paling sering terlewat, padahal tanpa langkah ini pesan
                    WhatsApp tidak akan pernah sampai ke Exavro.
                </p>
                <ol class="list-decimal list-inside space-y-2 mb-4">
                    <li>
                        Buka menu <a href="{{ route('setting.user') }}" title="pengaturan">Pengaturan</a>, kemudian salin URL pada kartu
                        "Webhook URL" melalui tombol Copy.
                    </li>
                    <li>
                        Masuk ke <a href="https://fonnte.com" target="_blank" rel="noopener">dashboard Fonnte</a>, lalu buka menu
                        <strong>Device &rarr; Edit</strong> pada device WhatsApp instansi Anda.
                    </li>
                    <li>Tempelkan URL yang telah disalin ke kolom Webhook. Setelah ditempel, webhook akan aktif secara otomatis.</li>
                    <li>Pastikan <strong>Autoread</strong> berada pada posisi <span class="xv-tag xv-tag--on">On</span>.</li>
                    <li>Atur dropdown <strong>Response Source</strong> ke <span class="xv-tag xv-tag--neutral">Autoreply</span>.</li>
                </ol>
                <div class="xv-callout xv-callout--warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span>Silent Read bersifat opsional. <strong>Inbox</strong> juga
                        opsional, namun wajib berada pada posisi <span class="xv-tag xv-tag--on">On</span>
                        apabila instansi hendak menggunakan fitur kutip/balas pesan pada Live Support,
                        sebab tanpa itu Fonnte tidak akan mengirimkan <code>inboxid</code> yang
                        dibutuhkan untuk mengutip pesan pemohon. Pengaturan ini dapat disesuaikan
                        dengan kebutuhan masing-masing instansi.</span>
                </div>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="xv-step">
            <div class="xv-step-num">5</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Uji Coba Aplikasi</h3>
                <p class="mb-3">
                    Pastikan seluruh pengaturan telah terisi dengan benar.
                    Setelah itu, tunggu proses otomatis oleh server (cronjob).
                    Jika tidak ada notifikasi yang masuk, periksa kembali pengaturan dan pastikan endpoint API
                    pemohon dan data pegawai sudah sesuai.
                </p>
                <div class="xv-callout xv-callout--danger">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Jika tetap tidak ada notifikasi, silakan hubungi
                        <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Support">Support</a>.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="xv-docs-card p-8 text-center">
        <h3 class="xv-display text-xl font-bold mb-2" style="color: var(--xv-text);">Butuh Bantuan?</h3>
        <p class="mb-4">Jika mengalami kendala, silakan hubungi tim support kami.</p>
        <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Support" class="xv-btn xv-btn-accent">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z" />
            </svg>
            Hubungi Support
        </a>
    </div>
@endsection