@extends('user.layout3')

@section('title', 'API Pemohon')

@section('meta_description',
    'Pelajari format API pemohon yang dibutuhkan Sitaku. Siapkan endpoint dan respons JSON
    sesuai standar agar sistem dapat berjalan otomatis tanpa integrasi tambahan.')

@section('og_description',
    'Dokumentasi teknis API Pemohon untuk Sitaku. Cukup siapkan endpoint sesuai format JSON
    berikut agar sistem terhubung otomatis dan langsung siap digunakan.')

@section('content')
    <div class="container mx-auto px-4 py-6 space-y-8">
        {{-- 1. Pendahuluan --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">
                    <svg class="w-6 h-6 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tentang API Pemohon
                </h2>
                <div class="alert alert-info">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Integrasi Tanpa Ribet!</p>
                        <p class="text-sm font-semibold">Sitaku membutuhkan akses ke data pemohon dari sistem eksternal
                            Anda. Untuk itu,
                            Anda cukup menyiapkan satu endpoint API yang dapat diakses oleh sistem kami secara otomatis.
                            Tidak diperlukan integrasi tambahan atau autentikasi khusus.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Alur Singkat --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">
                    <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Alur Integrasi Singkat
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="step-item">
                        <div class="flex items-center gap-3 p-4 bg-primary text-primary-content rounded-lg">
                            <div class="badge badge-secondary badge-lg">1</div>
                            <span class="font-medium">Siapkan endpoint URL API yang dapat diakses secara publik (tanpa
                                autentikasi).</span>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="flex items-center gap-3 p-4 bg-secondary text-secondary-content rounded-lg">
                            <div class="badge badge-accent badge-lg">2</div>
                            <span class="font-medium">Pastikan format respons JSON sesuai dengan struktur yang dijelaskan di
                                bawah.</span>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="flex items-center gap-3 p-4 bg-accent text-accent-content rounded-lg">
                            <div class="badge badge-primary badge-lg">3</div>
                            <span class="font-medium">Masukkan URL endpoint tersebut di menu <strong>Pengaturan</strong>
                                pada aplikasi Sitaku.</span>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="flex items-center gap-3 p-4 bg-success text-success-content rounded-lg">
                            <div class="badge badge-warning badge-lg">4</div>
                            <span class="font-medium">Selesai. Sistem akan mengambil data pemohon secara otomatis.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Format Respons JSON --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">
                    <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    Format Respons JSON
                </h2>
                <p class="text-base-content font-semibold">
                    Berikut adalah contoh struktur JSON yang harus dikembalikan dari endpoint Anda:
                </p>
                <div class="mockup-code text-sm">
                    <pre data-prefix="$"><code>curl -X GET https://example.com/api/v1/pemohon</code></pre>
                    <pre data-prefix=">" class="text-warning"><code>Response:</code></pre>
                    <pre data-prefix="1"><code>{</code></pre>
                    <pre data-prefix="2"><code><span class="invisible">__</span>"message": "Success",</code></pre>
                    <pre data-prefix="3"><code><span class="invisible">__</span>"data": [</code></pre>
                    <pre data-prefix="4"><code><span class="invisible">____</span>{</code></pre>
                    <pre data-prefix="5"><code><span class="invisible">______</span>"id": 1,</code></pre>
                    <pre data-prefix="6"><code><span class="invisible">______</span>"nama": "Dia Orangnya",</code></pre>
                    <pre data-prefix="7"><code><span class="invisible">______</span>"no_hp": "08xxxxxxx",</code></pre>
                    <pre data-prefix="8"><code><span class="invisible">______</span>"no_permohonan": "siimutdia123",</code></pre>
                    <pre data-prefix="9"><code><span class="invisible">______</span>"jenis_izin": "Izin Melupakan Dia",</code></pre>
                    <pre data-prefix="10"><code><span class="invisible">______</span>"nama_proses": "Blokir Nomor Dia",</code></pre>
                    <pre data-prefix="11"><code><span class="invisible">______</span>"status": "proses",</code></pre>
                    <pre data-prefix="12"><code><span class="invisible">______</span>"tgl_pengajuan": "2025-07-21 14:30:00"</code></pre>
                    <pre data-prefix="13"><code><span class="invisible">____</span>},</code></pre>
                    <pre data-prefix="13"><code><span class="invisible">____</span>// other applicant data...</code></pre>
                    <pre data-prefix="14"><code><span class="invisible">__</span>]</code></pre>
                    <pre data-prefix="15"><code>}</code></pre>
                </div>
                <p class="text-base-content font-semibold mt-4">
                    Contoh struktur JSON yang lain sebagai berikut:
                </p>
                <div class="mockup-code text-sm overflow-x-auto">
                    <pre data-prefix="$"><code>curl -X GET https://example.com/api/v2/pemohon</code></pre>
                    <pre data-prefix=">" class="text-warning"><code>Response:</code></pre>
                    <pre data-prefix="1"><code>{</code></pre>
                    <pre data-prefix="2"><code>  "data": {</code></pre>
                    <pre data-prefix="3"><code>    "data": [</code></pre>
                    <pre data-prefix="4"><code>      {</code></pre>
                    <pre data-prefix="5"><code>        "id": 2,</code></pre>
                    <pre data-prefix="6"><code>        "nama": "Dia orang istimewa",</code></pre>
                    <pre data-prefix="7"><code>        "no_hp": "08xxxxxxxxx",</code></pre>
                    <pre data-prefix="8"><code>        "no_permohonan": "siimutdia124",</code></pre>
                    <pre data-prefix="9"><code>        "jenis_izin": "Izin Shutdown Koneksi Hati",</code></pre>
                    <pre data-prefix="10"><code>        "nama_proses": "waiting for ACK... but it never came",</code></pre>
                    <pre data-prefix="11"><code>        "status": "proses",</code></pre>
                    <pre data-prefix="12"><code>        "tgl_pengajuan": "2025-06-15T03:07:33+00:00",</code></pre>
                    <pre data-prefix="13"><code>        "alamat": "Jalan Kenangan No. 404",</code></pre>
                    <pre data-prefix="14"><code>        "email": example@ex.com,</code></pre>
                    <pre data-prefix="15"><code>        "end_date": "2025-06-15T03:07:33+00:00"</code></pre>
                    <pre data-prefix="16"><code>      },</code></pre>
                    <pre data-prefix="17"><code>      // other applicant data...</code></pre>
                    <pre data-prefix="18"><code>    ]</code></pre>
                    <pre data-prefix="19"><code>  },</code></pre>
                    <pre data-prefix="20"><code>  "message": "Berhasil",</code></pre>
                    <pre data-prefix="21"><code>  "success": true,</code></pre>
                    <pre data-prefix="22"><code>  "code": 200</code></pre>
                    <pre data-prefix="23"><code>}</code></pre>
                </div>
            </div>
        </div>
        {{-- 4. Penjelasan Parameter --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Penjelasan Parameter
                </h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Deskripsi</th>
                                <th>Contoh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code class="badge badge-ghost">id</code></td>
                                <td><span class="badge bgc5 text-white">string</span></td>
                                <td>ID pemohon</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td><code class="badge badge-ghost">nama</code></td>
                                <td><span class="badge bgc5 text-white">string</span></td>
                                <td>Nama lengkap pemohon</td>
                                <td>Dia Orangnya</td>
                            </tr>
                            <tr>
                                <td><code class="badge badge-ghost">no_hp</code></td>
                                <td><span class="badge bgc5 text-white">string</span></td>
                                <td>Nomor HP aktif yang bisa digunakan untuk notifikasi</td>
                                <td>08xxxxxxx</td>
                            </tr>
                            <tr>
                                <td><code class="badge badge-ghost">no_permohonan</code></td>
                                <td><span class="badge bgc5 text-white">string</span></td>
                                <td>Nomor pengajuan permohonan</td>
                                <td>siimutdia123</td>
                            </tr>
                            <tr>
                                <td><code class="badge badge-ghost">jenis_izin</code></td>
                                <td><span class="badge bgc5 text-white">string</span></td>
                                <td>Jenis Izin Pemohon</td>
                                <td>Izin Melupakan Dia</td>
                            </tr>
                            <tr>
                                <td><code class="badge badge-ghost">nama_proses</code></td>
                                <td><span class="badge bgc5 text-white">string</span></td>
                                <td>Proses tahapan pemohon</td>
                                <td>Blokir Nomor Dia</td>
                            </tr>
                            <tr>
                                <td><code class="badge badge-ghost">status</code></td>
                                <td><span class="badge bgc5 text-white">string</span></td>
                                <td>Status dari proses pemohon</td>
                                <td>Proses / Selesai</td>
                            </tr>
                            <tr>
                                <td><code class="badge badge-ghost">tgl_pengajuan</code></td>
                                <td><span class="badge bgc5 text-white">string</span></td>
                                <td>Tanggal mengajukan permohonan</td>
                                <td>2025-07-21 14:30:00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- 5. Contoh Endpoint --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">
                    <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                        </path>
                    </svg>
                    Contoh Endpoint
                </h2>
                <p class="text-base-content mb-4">
                    Contoh format URL endpoint:
                </p>

                <div class="alert alert-success flex flex-row">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                        </path>
                    </svg>
                    <div class="ml-3 overflow-hidden">
                        <div class="font-mono font-semibold text-sm break-words">
                            https://domainanda.com/api/data-pemohon
                        </div>
                        <div class="text-xs font-bold mt-1">Pastikan endpoint ini dapat diakses secara publik</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 6. FAQ / Tips Tambahan --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">
                    <svg class="w-6 h-6 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    FAQ & Tips
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="alert alert-warning font-semibold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                        <div class="text-sm">
                            <strong>Public Access</strong><br>
                            Endpoint harus bisa diakses oleh publik tanpa login atau token.
                        </div>
                    </div>
                    <div class="alert alert-success font-semibold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        <div class="text-sm">
                            <strong>HTTPS Required</strong><br>
                            Gunakan HTTPS untuk keamanan data.
                        </div>
                    </div>
                    <div class="alert alert-info font-semibold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        <div class="text-sm">
                            <strong>Update Structure</strong><br>
                            Jika ada perubahan struktur, pastikan disesuaikan juga di pengaturan Sitaku.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Call to Action --}}
        <div class="text-center">
            <div class="card bgc5">
                <div class="card-body">
                    <h3 class="card-title justify-center text-2xl mb-4 text-white">Siap untuk Integrasi?</h3>
                    <p class="mb-6 text-white font-semibold">Atur endpoint API Anda sekarang dan mulai menggunakan Sitaku
                        secara
                        otomatis!</p>
                    <div class="card-actions justify-center">
                        <a href="/settings"
                            class="btn btn-success hover:shadow-xl shadow-md duration-300 transition-shadow shadow-accent btn-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Buka Pengaturan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
