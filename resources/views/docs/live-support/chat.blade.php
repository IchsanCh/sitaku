@extends('user.layout3')

@section('title', 'Live Support - Chat')

@section('meta_description',
    'Panduan Live Support Exavro: mengalihkan percakapan WhatsApp kepada admin manusia, mengirim
    gambar atau berkas, dan membalas dengan kutipan melalui panel chat khusus admin support.')

@section('og_description',
    'Dokumentasi Live Support Exavro, panel chat real-time bagi admin support instansi untuk
    menangani pemohon secara langsung melalui WhatsApp.')

@section('content')
    <h1 class="xv-display text-3xl font-bold mb-4" style="color: var(--xv-text);">Live Support: Chat</h1>

    <div class="xv-callout xv-callout--info mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Live Support memindahkan percakapan WhatsApp dari bot kepada admin manusia,
            melalui panel chat real-time yang terpisah dari panel instansi.</span>
    </div>

    <h2 class="text-xl font-bold mb-3">Cara Pemohon Memasuki Live Support</h2>
    <p class="mb-6">
        Pemohon mengetikkan trigger yang pada <a href="/docs/menu-wa">Menu WA</a>
        telah diatur dengan tipe aksi <code>live_support</code>. Setelah masuk, bot akan
        berhenti membalas secara otomatis untuk nomor tersebut, dan seluruh pesan berikutnya
        akan masuk ke inbox admin support.
    </p>

    <h2 class="text-xl font-bold mb-3">Panel Admin Support</h2>
    <p class="mb-6">
        Admin support masuk melalui halaman terpisah pada
        <a href="https://exavro.lotusaja.com/support/login" target="_blank" rel="noopener">exavro.lotusaja.com/support/login</a>,
        bukan halaman login instansi. Setelah berhasil masuk, seluruh percakapan aktif akan
        ditampilkan pada Inbox dan diperbarui secara otomatis tanpa perlu memuat ulang halaman.
    </p>

    <div class="xv-step-list mb-8">
        <div class="xv-step">
            <div class="xv-step-num">1</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Mengirim dan Menerima Pesan</h3>
                <p class="mb-3">Admin dapat mengetikkan balasan seperti biasa, atau melampirkan
                    gambar maupun berkas melalui ikon &#128206;. Gambar akan ditampilkan langsung pada chat,
                    sedangkan berkas lain akan menjadi tautan yang dapat dibuka atau diunduh.</p>
                <div class="xv-callout xv-callout--warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span>Penerimaan lampiran (gambar atau berkas) dari pemohon hanya
                        berfungsi apabila device Fonnte instansi menggunakan paket "all feature".</span>
                </div>
            </div>
        </div>

        <div class="xv-step">
            <div class="xv-step-num">2</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Membalas dengan Kutipan (Geser Pesan)</h3>
                <p class="mb-3">Geser bubble pesan ke arah kanan untuk mengutip pesan tersebut
                    pada balasan berikutnya. Pratinjau "Balas ke..." akan muncul di atas kotak chat dan
                    dapat dibatalkan kapan saja.</p>
                <div class="xv-callout xv-callout--warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span>Agar kutipan tersebut benar-benar tersemat pada pesan pemohon
                        di WhatsApp, dan bukan hanya tampil di panel, toggle <strong>Inbox</strong> pada
                        device Fonnte instansi harus dalam posisi
                        <span class="xv-tag xv-tag--on">On</span>. Silakan lihat
                        <a href="/docs/getting-started">Getting Started</a>.</span>
                </div>
            </div>
        </div>

        <div class="xv-step">
            <div class="xv-step-num">3</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Balasan Cepat</h3>
                <p>Ketikkan tanda "/" pada kotak chat untuk memanggil template balasan
                    yang telah disiapkan oleh instansi. Silakan lihat <a href="/docs/live-support/balasan-cepat">dokumentasi Balasan Cepat</a>.</p>
            </div>
        </div>

        <div class="xv-step">
            <div class="xv-step-num">4</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Mengakhiri Sesi</h3>
                <p>Klik "Akhiri Sesi" pada pojok kanan atas chat untuk menutup
                    percakapan dan mengembalikan nomor tersebut ke alur bot biasa. Pemohon akan menerima
                    notifikasi WhatsApp bahwa sesi telah diakhiri.</p>
            </div>
        </div>
    </div>

    <div class="xv-callout xv-callout--success mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Siapa saja yang berwenang masuk ke panel ini diatur pada
            <a href="/docs/live-support/admin-support">Akun Admin Support</a>.</span>
    </div>

    <div class="xv-docs-card p-8 text-center">
        <h3 class="xv-display text-xl font-bold mb-2" style="color: var(--xv-text);">Butuh Bantuan?</h3>
        <p class="mb-4">Jika mengalami kendala, silakan hubungi tim support kami.</p>
        <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Support" class="xv-btn xv-btn-accent">Hubungi Support</a>
    </div>
@endsection