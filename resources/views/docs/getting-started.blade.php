@extends('user.layout3')

@section('title', 'Getting Started')

@section('meta_description',
    'Mulai gunakan Sitaku dengan panduan singkat ini. Pelajari cara setup awal, konfigurasi
    unit, dan tips cepat untuk menjalankan sistem secara optimal.')

@section('og_description',
    'Panduan lengkap untuk memulai penggunaan Sitaku. Ikuti langkah-langkah mudah untuk mengatur
    akun, unit, dan fitur utama dengan cepat dan efisien.')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h1 class="card-title text-3xl font-bold mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                        </path>
                    </svg>
                    Getting Started
                </h1>

                <div class="alert alert-info mb-6 font-semibold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Ikuti langkah-langkah berikut untuk mulai menggunakan Sitaku secara optimal:</span>
                </div>

                <div class="space-y-4">
                    <!-- Step 1 -->
                    <div class="collapse collapse-arrow bg-base-200">
                        <input type="radio" name="getting-started-accordion" checked="checked" />
                        <div class="collapse-title text-xl font-medium flex items-center gap-3">
                            <div class="badge badge-primary badge-lg">1</div>
                            <strong>Registrasi Akun</strong>
                        </div>
                        <div class="collapse-content">
                            <p class="mb-4 font-semibold">
                                Buka halaman <a href="{{ url('/signup') }}" class="link link-primary font-semibold">Sign
                                    Up</a>
                                dan buat akun baru dengan email dan password yang valid.
                            </p>
                            <div class="flex gap-2">
                                <a href="{{ url('/signup') }}" class="btn btn-primary btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    Daftar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="collapse collapse-arrow bg-base-200">
                        <input type="radio" name="getting-started-accordion" />
                        <div class="collapse-title text-xl font-medium flex items-center gap-3">
                            <div class="badge badge-secondary badge-lg">2</div>
                            <strong>Login ke Sistem</strong>
                        </div>
                        <div class="collapse-content">
                            <p class="mb-4 font-semibold">
                                Setelah berhasil registrasi, masuk melalui halaman
                                <a href="{{ url('/login') }}" class="link link-primary font-semibold">Login</a>.
                            </p>
                            <div class="flex gap-2">
                                <a href="{{ url('/login') }}" class="btn btn-secondary btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Login
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="collapse collapse-arrow bg-base-200">
                        <input type="radio" name="getting-started-accordion" />
                        <div class="collapse-title text-xl font-medium flex items-center gap-3">
                            <div class="badge badge-accent badge-lg">3</div>
                            <strong>Lengkapi Data di Menu Pengaturan</strong>
                        </div>
                        <div class="collapse-content">
                            <p class="mb-4 font-semibold">
                                Buka menu <a href="/setting" class="link link-primary" title="pengaturan">Pengaturan</a>
                                untuk mengisi data
                                unit, token fonnte dan
                                endpoint api untuk pemohon,
                                kemudian isi pegawai pada menu <a href="/pegawai" class="link link-primary"
                                    title="pegawai">Pegawai.</a>
                            </p>
                            <div class="alert alert-warning mb-4 font-semibold">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                <span>
                                    Pengaturan API untuk pemohon dan pegawai bisa dilihat melalui dokumentasi
                                    <a href="/docs/api/pemohon" class="link link-primary font-semibold"
                                        title="api-guide">API
                                        Guide</a>
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <a href="/docs/api/pemohon" class="btn btn-accent btn-sm font-bold"
                                    title="lihat dokumentasi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Lihat Dokumentasi
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="collapse collapse-arrow bg-base-200">
                        <input type="radio" name="getting-started-accordion" />
                        <div class="collapse-title text-xl font-medium flex items-center gap-3">
                            <div class="badge badge-success badge-lg">4</div>
                            <strong>Uji Coba Aplikasi</strong>
                        </div>
                        <div class="collapse-content">
                            <p class="mb-4 font-semibold">
                                Pastikan seluruh pengaturan telah terisi dengan benar.
                                Setelah itu, tunggu proses otomatis oleh server (cronjob).
                                Jika tidak ada notifikasi yang masuk, periksa kembali pengaturan dan pastikan endpoint API
                                pemohon dan data pegawai sudah sesuai.
                            </p>
                            <div class="alert alert-error mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">
                                    Jika tetap tidak ada notifikasi, silakan hubungi
                                    <a href="https://wa.me/6285175112406" target="_blank"
                                        class="link link-primary font-semibold">Support</a>.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support Section -->
                <div class="divider mt-8"></div>

                <div class="card bg-base-200 mt-6">
                    <div class="card-body text-center">
                        <h3 class="card-title justify-center text-xl mb-2">
                            Butuh Bantuan?
                        </h3>
                        <p class="mb-4 font-semibold">Jika mengalami kendala, silakan hubungi tim support kami.</p>
                        <div class="card-actions justify-center">
                            <a href="https://wa.me/6285175112406" target="_blank"
                                class="btn bgc1 text-white lisaa font-semibold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z">
                                    </path>
                                </svg>
                                Hubungi Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
