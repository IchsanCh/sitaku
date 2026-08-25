@extends('user.layout3')

@section('title', 'Live Support - Balasan Cepat')

@section('meta_description',
    'Panduan Balasan Cepat Sitaku: membuat template pesan yang dapat dipanggil admin support
    cukup dengan mengetikkan "/" pada kotak chat live support.')

@section('og_description',
    'Dokumentasi Balasan Cepat (quick reply) Sitaku untuk mempercepat respons admin support
    pada live chat WhatsApp.')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h1 class="card-title text-3xl font-bold mb-4">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                </svg>
                Live Support: Balasan Cepat
            </h1>

            <div class="alert alert-info mb-6 font-semibold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Balasan Cepat (quick reply) merupakan template pesan siap pakai yang dapat
                    dipanggil admin support secara instan melalui kotak chat, tanpa perlu mengetikkan
                    ulang jawaban yang sama secara berulang.</span>
            </div>

            <h2 class="text-xl font-bold mb-3">Cara Pengaturan</h2>
            <div class="space-y-4 mb-6">
                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="qr-accordion" checked="checked" />
                    <div class="collapse-title text-lg font-medium flex items-center gap-3">
                        <div class="badge badge-primary badge-lg">1</div>
                        <strong>Membuka Balasan Cepat</strong>
                    </div>
                    <div class="collapse-content">
                        <p class="font-semibold">Pada sidebar panel instansi, klik <strong>Balasan Cepat</strong>,
                            kemudian pilih "Tambah Balasan Cepat".</p>
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="qr-accordion" />
                    <div class="collapse-title text-lg font-medium flex items-center gap-3">
                        <div class="badge badge-secondary badge-lg">2</div>
                        <strong>Mengisi Trigger dan Isi Pesan</strong>
                    </div>
                    <div class="collapse-content">
                        <p class="font-semibold">Trigger hanya boleh terdiri atas huruf kecil, angka, tanda hubung
                            "-", dan garis bawah "_" (misalnya <code>alur-pelayanan</code>), serta harus unik pada
                            instansi ini. Isi pesan dapat berupa teks bebas hingga 2000 karakter, yang akan langsung
                            mengisi kotak chat ketika dipilih.</p>
                    </div>
                </div>
            </div>

            <h2 class="text-xl font-bold mb-3">Cara Penggunaan pada Chat</h2>
            <p class="font-semibold mb-4">
                Admin support mengetikkan tanda <code>/</code> pada kotak chat, kemudian melanjutkan
                dengan mengetik trigger yang dimaksud. Sebuah dropdown akan otomatis muncul dan
                tersaring sesuai huruf yang diketik. Pemilihan dapat dilakukan dengan klik, atau
                dengan navigasi panah atas maupun bawah yang diikuti dengan
                <kbd class="kbd kbd-sm">Enter</kbd> atau <kbd class="kbd kbd-sm">Tab</kbd>.
                Isi kotak chat akan langsung berganti menjadi teks lengkap dari template tersebut, dan
                masih dapat diedit sebelum dikirim.
            </p>

            <div class="alert alert-success mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm">Balasan Cepat khusus digunakan pada
                    <a href="/docs/live-support/chat" class="link link-primary font-semibold">Live Support</a>.
                    Apabila instansi belum memiliki feature Live Support, halaman ini turut terkunci.</span>
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