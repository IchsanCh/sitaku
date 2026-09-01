@extends('user.layout3')

@section('title', 'Cronjob Time')

@section('meta_description',
    'Pelajari jadwal cronjob dan sinkronisasi otomatis pada sistem Exavro. Dokumentasi ini
    menjelaskan waktu pengiriman pesan, sinkronisasi data, dan penghapusan otomatis.')

@section('og_description',
    'Dokumentasi lengkap jadwal cronjob Exavro. Ketahui kapan sistem mengirim pesan otomatis,
    melakukan sinkronisasi data pegawai, dan menghapus log lama.')

@section('content')
    <div class="mb-8">
        <h1 class="xv-display text-3xl font-bold mb-2" style="color: var(--xv-text);">Jadwal Cronjob &amp; Sinkronisasi Data</h1>
        <p style="color: var(--xv-text-soft);">Sistem otomatisasi dan penjadwalan untuk efisiensi maksimal</p>
    </div>

    <div class="grid gap-5 md:grid-cols-2 mb-6">
        <!-- Pengiriman ke Pegawai -->
        <div class="xv-docs-card p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="xv-icon-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                </div>
                <h2 class="xv-display text-lg font-bold" style="color: var(--xv-text);">Pengiriman ke Pegawai</h2>
            </div>
            <div class="space-y-3">
                <div class="xv-callout xv-callout--info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Pengiriman otomatis saat ada pemohon baru</span>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wide" style="color: var(--xv-text-soft);">Jadwal Harian</p>
                <div class="flex items-center gap-3 p-3 rounded-lg" style="background: var(--xv-paper-alt);">
                    <span class="xv-tag" style="background: var(--xv-warning-bg); color: var(--xv-warning);">06:58</span>
                    <span class="text-sm">Reset status pengiriman</span>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-lg" style="background: var(--xv-paper-alt);">
                    <span class="xv-tag xv-tag--on">07:00</span>
                    <span class="text-sm">Kirim pesan pengingat rutin</span>
                </div>
            </div>
        </div>

        <!-- Pengiriman ke Pemohon -->
        <div class="xv-docs-card p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="xv-icon-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M3.478 2.404a.75.75 0 00-.926.941l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.404z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="xv-display text-lg font-bold" style="color: var(--xv-text);">Pengiriman ke Pemohon</h2>
            </div>
            <div class="space-y-3">
                <div class="xv-stat">
                    <div class="xv-stat-title">Interval Pembaruan</div>
                    <div class="xv-stat-value">15 Menit</div>
                    <div class="xv-stat-desc">Pembaruan data otomatis</div>
                </div>
                <div class="xv-callout xv-callout--success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Pesan dikirim hanya untuk data baru atau perubahan tahapan</span>
                </div>
            </div>
        </div>

        <!-- Uptime -->
        <div class="xv-docs-card p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="xv-icon-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0015.059-4.035.75.75 0 00-.53-.918z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="xv-display text-lg font-bold" style="color: var(--xv-text);">Uptime 99,9%</h2>
            </div>
            <div class="space-y-3">
                <div class="xv-stat">
                    <div class="xv-stat-title">Ketersediaan Sistem</div>
                    <div class="xv-stat-value">High Availability</div>
                    <div class="xv-stat-desc">Layanan hanya berhenti saat proses maintenance</div>
                </div>
                <div class="xv-callout xv-callout--warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span>Sistem beroperasi secara berkelanjutan dengan tingkat ketersediaan tinggi.</span>
                </div>
            </div>
        </div>

        <!-- Penghapusan Otomatis -->
        <div class="xv-docs-card p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="xv-icon-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </div>
                <h2 class="xv-display text-lg font-bold" style="color: var(--xv-text);">Penghapusan Otomatis</h2>
            </div>
            <div class="space-y-3">
                <div class="xv-stat">
                    <div class="xv-stat-title">Retensi Data</div>
                    <div class="xv-stat-value">3 Bulan</div>
                    <div class="xv-stat-desc">Otomatis dihapus</div>
                </div>
                <div class="xv-callout xv-callout--info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Data pesan lama dihapus untuk menjaga performa sistem</span>
                </div>
            </div>
        </div>
    </div>

    <div class="xv-docs-card p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="xv-icon-accent">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <h2 class="xv-display text-lg font-bold" style="color: var(--xv-text);">Catatan Penting</h2>
        </div>
        <div class="xv-callout xv-callout--warning">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <span>Zona Waktu: <strong>WIB (UTC+7)</strong></span>
        </div>
    </div>
@endsection