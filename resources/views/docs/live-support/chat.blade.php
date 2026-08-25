@extends('user.layout3')

@section('title', 'Live Support - Chat')

@section('meta_description',
    'Panduan Live Support Sitaku: mengalihkan percakapan WhatsApp kepada admin manusia, mengirim
    gambar atau berkas, dan membalas dengan kutipan melalui panel chat khusus admin support.')

@section('og_description',
    'Dokumentasi Live Support Sitaku, panel chat real-time bagi admin support instansi untuk
    menangani pemohon secara langsung melalui WhatsApp.')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h1 class="card-title text-3xl font-bold mb-4">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                </svg>
                Live Support: Chat
            </h1>

            <div class="alert alert-info mb-6 font-semibold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Live Support memindahkan percakapan WhatsApp dari bot kepada admin manusia,
                    melalui panel chat real-time yang terpisah dari panel instansi.</span>
            </div>

            <h2 class="text-xl font-bold mb-3">Cara Pemohon Memasuki Live Support</h2>
            <p class="font-semibold mb-6">
                Pemohon mengetikkan trigger yang pada <a href="/docs/menu-wa" class="link link-primary">Menu WA</a>
                telah diatur dengan tipe aksi <code>live_support</code>. Setelah masuk, bot akan
                berhenti membalas secara otomatis untuk nomor tersebut, dan seluruh pesan berikutnya
                akan masuk ke inbox admin support.
            </p>

            <h2 class="text-xl font-bold mb-3">Panel Admin Support</h2>
            <p class="font-semibold mb-4">
                Admin support masuk melalui halaman terpisah pada
                <a href="https://exavro.lotusaja.com/support/login" target="_blank" rel="noopener"
                    class="link link-primary font-semibold">exavro.lotusaja.com/support/login</a>,
                bukan halaman login instansi. Setelah berhasil masuk, seluruh percakapan aktif akan
                ditampilkan pada Inbox dan diperbarui secara otomatis tanpa perlu memuat ulang halaman.
            </p>

            <div class="space-y-4 mb-6">
                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="live-support-accordion" checked="checked" />
                    <div class="collapse-title text-lg font-medium flex items-center gap-3">
                        <div class="badge badge-primary badge-lg">1</div>
                        <strong>Mengirim dan Menerima Pesan</strong>
                    </div>
                    <div class="collapse-content">
                        <p class="font-semibold">Admin dapat mengetikkan balasan seperti biasa, atau melampirkan
                            gambar maupun berkas melalui ikon 📎. Gambar akan ditampilkan langsung pada chat,
                            sedangkan berkas lain akan menjadi tautan yang dapat dibuka atau diunduh.</p>
                        <div class="alert alert-warning mt-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm">Penerimaan lampiran (gambar atau berkas) dari pemohon hanya
                                berfungsi apabila device Fonnte instansi menggunakan paket "all feature".</span>
                        </div>
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="live-support-accordion" />
                    <div class="collapse-title text-lg font-medium flex items-center gap-3">
                        <div class="badge badge-secondary badge-lg">2</div>
                        <strong>Membalas dengan Kutipan (Geser Pesan)</strong>
                    </div>
                    <div class="collapse-content">
                        <p class="font-semibold">Geser bubble pesan ke arah kanan untuk mengutip pesan tersebut
                            pada balasan berikutnya. Pratinjau "Balas ke..." akan muncul di atas kotak chat dan
                            dapat dibatalkan kapan saja.</p>
                        <div class="alert alert-warning mt-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm">Agar kutipan tersebut benar-benar tersemat pada pesan pemohon
                                di WhatsApp, dan bukan hanya tampil di panel, toggle <strong>Inbox</strong> pada
                                device Fonnte instansi harus dalam posisi
                                <span class="badge badge-success badge-sm">On</span>. Silakan lihat
                                <a href="/docs/getting-started" class="link link-primary font-semibold">Getting Started</a>.</span>
                        </div>
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="live-support-accordion" />
                    <div class="collapse-title text-lg font-medium flex items-center gap-3">
                        <div class="badge badge-accent badge-lg">3</div>
                        <strong>Balasan Cepat</strong>
                    </div>
                    <div class="collapse-content">
                        <p class="font-semibold">Ketikkan tanda "/" pada kotak chat untuk memanggil template balasan
                            yang telah disiapkan oleh instansi. Silakan lihat <a href="/docs/live-support/balasan-cepat" class="link link-primary">dokumentasi Balasan Cepat</a>.</p>
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="live-support-accordion" />
                    <div class="collapse-title text-lg font-medium flex items-center gap-3">
                        <div class="badge badge-success badge-lg">4</div>
                        <strong>Mengakhiri Sesi</strong>
                    </div>
                    <div class="collapse-content">
                        <p class="font-semibold">Klik "Akhiri Sesi" pada pojok kanan atas chat untuk menutup
                            percakapan dan mengembalikan nomor tersebut ke alur bot biasa. Pemohon akan menerima
                            notifikasi WhatsApp bahwa sesi telah diakhiri.</p>
                    </div>
                </div>
            </div>

            <div class="alert alert-success mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm">Siapa saja yang berwenang masuk ke panel ini diatur pada
                    <a href="/docs/live-support/admin-support" class="link link-primary font-semibold">Akun Admin Support</a>.</span>
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