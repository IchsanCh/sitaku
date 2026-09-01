@extends('user.layout3')

@section('title', 'API EXAVRO')

@section('meta_description',
    'Dokumentasi lengkap untuk Exavro API. Pelajari bagaimana mengambil data user, pegawai, dan
    langganan dengan mudah tanpa perlu login ke dashboard.')

@section('og_description',
    'Akses data user dan pegawai secara otomatis menggunakan Exavro API. Cocok untuk integrasi
    monitoring, pelaporan, dan automasi internal.')

@section('content')
    <h1 class="xv-display text-3xl font-bold mb-4" style="color: var(--xv-text);">Tentang API EXAVRO</h1>

    <div class="xv-callout xv-callout--info mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <p class="font-semibold" style="color: var(--xv-text);">Monitoring API</p>
            <p>Exavro API memungkinkan integrasi, automasi, dan monitoring langsung dari sistem internal kamu.</p>
        </div>
    </div>

    <!-- Endpoint -->
    <div class="xv-docs-card p-6 mb-6">
        <h2 class="xv-display text-xl font-bold mb-4 flex items-center gap-3" style="color: var(--xv-text);">
            Endpoint
            <span class="xv-tag" style="background: var(--xv-info-bg); color: var(--xv-info);">GET</span>
        </h2>
        <div class="relative">
            <pre><code>curl -X GET https://exavro.lotusaja.com/api/v1/user -H "Authorization: token_exavro_anda"</code></pre>
            <button type="button" data-xv-copy="curl -X GET https://exavro.lotusaja.com/api/v1/user -H &quot;Authorization: token_exavro_anda&quot;"
                class="xv-copy-btn absolute top-3 right-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                </svg>
                <span data-xv-copy-label>Copy</span>
            </button>
        </div>
    </div>

    <!-- Authentication -->
    <div class="xv-docs-card p-6 mb-6">
        <h2 class="xv-display text-xl font-bold mb-4 flex items-center gap-3" style="color: var(--xv-text);">
            Autentikasi
            <span class="xv-tag" style="background: var(--xv-warning-bg); color: var(--xv-warning);">Required</span>
        </h2>
        <div class="xv-callout xv-callout--warning mb-4">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
            <span>Gunakan token Exavro untuk mengakses endpoint ini. Token didapatkan setelah registrasi akun.
                Anda dapat melihat token Exavro melalui menu <a href="/settings" title="Pengaturan">Pengaturan</a>.</span>
        </div>
        <pre><code>Authorization: &lt;token_exavro_anda&gt;</code></pre>
    </div>

    <!-- Response Sample -->
    <div class="xv-docs-card p-6 mb-6">
        <h2 class="xv-display text-xl font-bold mb-4 flex items-center gap-3" style="color: var(--xv-text);">
            Contoh Response JSON
            <span class="xv-tag xv-tag--on">200 OK</span>
        </h2>
        <pre><code>{
  "status": "success",
  "message": "Data user berhasil diambil.",
  "data": {
    "id": 1,
    "name": "Selalu Ada untuk Kamu",
    "email": "example@ex.com",
    "unit_id": "12",
    "api_url": "https://example.com/api/pemohon",
    "status": "active",
    "subscription_expires_at": "21 Juli 2025 09:31",
    "pegawais": [
      {
        "id": 1,
        "nama": "Exavro - Karena Kamu Layak Diingat",
        "no_hp": "08xxxxxxxxx",
        "posisi": "Agent Cinta &amp; Automation"
      }
      // other pegawai data...
    ]
  }
}</code></pre>
    </div>

    <!-- Field Explanation -->
    <div class="xv-docs-card p-6">
        <h2 class="xv-display text-xl font-bold mb-4" style="color: var(--xv-text);">Penjelasan Field</h2>
        <div class="overflow-x-auto">
            <table class="xv-docs-table">
                <thead><tr><th>Field</th><th>Type</th><th>Deskripsi</th></tr></thead>
                <tbody>
                    <tr><td><code>id</code></td><td><span class="xv-tag xv-tag--neutral">integer</span></td><td>ID unik user</td></tr>
                    <tr><td><code>name</code></td><td><span class="xv-tag xv-tag--neutral">string</span></td><td>Nama user</td></tr>
                    <tr><td><code>email</code></td><td><span class="xv-tag xv-tag--neutral">string</span></td><td>Email user</td></tr>
                    <tr><td><code>unit_id</code></td><td><span class="xv-tag xv-tag--neutral">string</span></td><td>ID unit yang digunakan untuk menandai instansi</td></tr>
                    <tr><td><code>api_url</code></td><td><span class="xv-tag xv-tag--neutral">string</span></td><td>URL API untuk mengambil data pemohon</td></tr>
                    <tr><td><code>status</code></td><td><span class="xv-tag xv-tag--neutral">string</span></td><td>Status aktif/nonaktif layanan notifikasi</td></tr>
                    <tr><td><code>subscription_expires_at</code></td><td><span class="xv-tag xv-tag--neutral">string</span></td><td>Tanggal berakhirnya subscription</td></tr>
                    <tr><td><code>pegawais</code></td><td><span class="xv-tag xv-tag--neutral">array</span></td><td>Daftar pegawai yang terdaftar pada akun user</td></tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection