@extends('user.layout3')

@section('title', 'API Sitaku')

@section('meta_description',
    'Dokumentasi lengkap untuk Sitaku API. Pelajari bagaimana mengambil data user, pegawai, dan
    langganan dengan mudah tanpa perlu login ke dashboard.')

@section('og_description',
    'Akses data user dan pegawai secara otomatis menggunakan Sitaku API. Cocok untuk integrasi
    monitoring, pelaporan, dan automasi internal.')

@section('content')
    <div class="container mx-auto px-4 py-6 space-y-8">
        <div class="card bg-base-100 shadow-xl mb-8">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">
                    <svg class="w-6 h-6 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tentang API SITAKU
                </h2>
                <div class="alert alert-info">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Monitoring API</p>
                        <p class="text-sm font-semibold">Sitaku API memungkinkan integrasi, automasi, dan monitoring
                            langsung dari sistem
                            internal kamu.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-8">
            <!-- Endpoint Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-4">
                        Endpoint
                        <div class="badge badge-primary">GET</div>
                    </h2>
                    <div class="mockup-code">
                        <pre data-prefix="$"><code>curl -X GET https://sitaku.lotusaja.com/api/v1/user -H "Authorization: token_sitaku_anda"</code></pre>
                    </div>
                </div>
            </div>

            <!-- Authentication Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-4">
                        Autentikasi
                        <div class="badge badge-warning">Required</div>
                    </h2>
                    <div class="alert alert-warning mb-4 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        <span>Gunakan token Sitaku untuk mengakses endpoint ini. Token didapatkan setelah registrasi akun.
                            Anda dapat melihat SITAKU token melalui menu <a href="/settings" title="Pengaturan"
                                class="text-primary">Pengaturan</a>.</span>
                    </div>
                    <div class="mockup-code">
                        <pre data-prefix="H"><code>Authorization: &lt;token_sitaku_anda&gt;</code></pre>
                    </div>
                </div>
            </div>

            <!-- Response Sample Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-4">
                        Contoh Response JSON
                        <div class="badge badge-success">200 OK</div>
                    </h2>
                    <div class="mockup-code text-sm overflow-x-auto">
                        <pre data-prefix="1"><code>{</code></pre>
                        <pre data-prefix="2"><code>  "status": "success",</code></pre>
                        <pre data-prefix="3"><code>  "message": "Data user berhasil diambil.",</code></pre>
                        <pre data-prefix="4"><code>  "data": {</code></pre>
                        <pre data-prefix="5"><code>    "id": 1,</code></pre>
                        <pre data-prefix="6"><code>    "name": "Selalu Ada untuk Kamu",</code></pre>
                        <pre data-prefix="7"><code>    "email": "example@ex.com",</code></pre>
                        <pre data-prefix="8"><code>    "unit_id": "12",</code></pre>
                        <pre data-prefix="9"><code>    "api_url": "https://example.com/api/pemohon",</code></pre>
                        <pre data-prefix="10"><code>    "status": "active",</code></pre>
                        <pre data-prefix="11"><code>    "subscription_expires_at": "21 Juli 2025 09:31",</code></pre>
                        <pre data-prefix="12"><code>    "pegawais": [</code></pre>
                        <pre data-prefix="13"><code>      {</code></pre>
                        <pre data-prefix="14"><code>        "id": 1,</code></pre>
                        <pre data-prefix="15"><code>        "nama": "Sitaku - Karena Kamu Layak Diingat",</code></pre>
                        <pre data-prefix="16"><code>        "no_hp": "08xxxxxxxxx",</code></pre>
                        <pre data-prefix="17"><code>        "posisi": "Agent Cinta & Automation"</code></pre>
                        <pre data-prefix="18"><code>      },</code></pre>
                        <pre data-prefix="19"><code>      // other pegawai data...</code></pre>
                        <pre data-prefix="20"><code>    ]</code></pre>
                        <pre data-prefix="21"><code>  }</code></pre>
                        <pre data-prefix="22"><code>}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Field Explanation Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-6">Penjelasan Field</h2>

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th class="text-base">Field</th>
                                    <th class="text-base">Type</th>
                                    <th class="text-base">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code class="bg-base-200 px-2 py-1 rounded">id</code></td>
                                    <td>
                                        <div class="badge bgc5 text-white">integer</div>
                                    </td>
                                    <td>ID unik user</td>
                                </tr>
                                <tr>
                                    <td><code class="bg-base-200 px-2 py-1 rounded">name</code></td>
                                    <td>
                                        <div class="badge bgc5 text-white">string</div>
                                    </td>
                                    <td>Nama user</td>
                                </tr>
                                <tr>
                                    <td><code class="bg-base-200 px-2 py-1 rounded">email</code></td>
                                    <td>
                                        <div class="badge bgc5 text-white">string</div>
                                    </td>
                                    <td>Email user</td>
                                </tr>
                                <tr>
                                    <td><code class="bg-base-200 px-2 py-1 rounded">unit_id</code></td>
                                    <td>
                                        <div class="badge bgc5 text-white">string</div>
                                    </td>
                                    <td>ID unit yang digunakan untuk menandai instansi</td>
                                </tr>
                                <tr>
                                    <td><code class="bg-base-200 px-2 py-1 rounded">api_url</code></td>
                                    <td>
                                        <div class="badge bgc5 text-white">string</div>
                                    </td>
                                    <td>URL API untuk mengambil data pemohon</td>
                                </tr>
                                <tr>
                                    <td><code class="bg-base-200 px-2 py-1 rounded">status</code></td>
                                    <td>
                                        <div class="badge bgc5 text-white">string</div>
                                    </td>
                                    <td>Status aktif/nonaktif layanan notifikasi</td>
                                </tr>
                                <tr>
                                    <td><code class="bg-base-200 px-2 py-1 rounded">subscription_expires_at</code></td>
                                    <td>
                                        <div class="badge bgc5 text-white">string</div>
                                    </td>
                                    <td>Tanggal berakhirnya subscription</td>
                                </tr>
                                <tr>
                                    <td><code class="bg-base-200 px-2 py-1 rounded">pegawais</code></td>
                                    <td>
                                        <div class="badge bgc5 text-white">array</div>
                                    </td>
                                    <td>Daftar pegawai yang terdaftar pada akun user</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
