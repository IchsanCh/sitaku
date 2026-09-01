@extends('user.layout3')

@section('title', 'Live Support - Balasan Cepat')

@section('meta_description',
    'Panduan Balasan Cepat Exavro: membuat template pesan yang dapat dipanggil admin support
    cukup dengan mengetikkan "/" pada kotak chat live support.')

@section('og_description',
    'Dokumentasi Balasan Cepat (quick reply) Exavro untuk mempercepat respons admin support
    pada live chat WhatsApp.')

@section('content')
    <h1 class="xv-display text-3xl font-bold mb-4" style="color: var(--xv-text);">Live Support: Balasan Cepat</h1>

    <div class="xv-callout xv-callout--info mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Balasan Cepat (quick reply) merupakan template pesan siap pakai yang dapat
            dipanggil admin support secara instan melalui kotak chat, tanpa perlu mengetikkan
            ulang jawaban yang sama secara berulang.</span>
    </div>

    <h2 class="text-xl font-bold mb-3">Cara Pengaturan</h2>
    <div class="xv-step-list mb-8">
        <div class="xv-step">
            <div class="xv-step-num">1</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Membuka Balasan Cepat</h3>
                <p>Pada sidebar panel instansi, klik <strong>Balasan Cepat</strong>, kemudian pilih "Tambah Balasan Cepat".</p>
            </div>
        </div>
        <div class="xv-step">
            <div class="xv-step-num">2</div>
            <div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--xv-text);">Mengisi Trigger dan Isi Pesan</h3>
                <p>Trigger hanya boleh terdiri atas huruf kecil, angka, tanda hubung
                    "-", dan garis bawah "_" (misalnya <code>alur-pelayanan</code>), serta harus unik pada
                    instansi ini. Isi pesan dapat berupa teks bebas hingga 2000 karakter, yang akan langsung
                    mengisi kotak chat ketika dipilih.</p>
            </div>
        </div>
    </div>

    <h2 class="text-xl font-bold mb-3">Cara Penggunaan pada Chat</h2>
    <p class="mb-6">
        Admin support mengetikkan tanda <code>/</code> pada kotak chat, kemudian melanjutkan
        dengan mengetik trigger yang dimaksud. Sebuah dropdown akan otomatis muncul dan
        tersaring sesuai huruf yang diketik. Pemilihan dapat dilakukan dengan klik, atau
        dengan navigasi panah atas maupun bawah yang diikuti dengan
        <span class="xv-kbd">Enter</span> atau <span class="xv-kbd">Tab</span>.
        Isi kotak chat akan langsung berganti menjadi teks lengkap dari template tersebut, dan
        masih dapat diedit sebelum dikirim.
    </p>

    <div class="xv-callout xv-callout--success mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Balasan Cepat khusus digunakan pada
            <a href="/docs/live-support/chat">Live Support</a>.
            Apabila instansi belum memiliki feature Live Support, halaman ini turut terkunci.</span>
    </div>

    <div class="xv-docs-card p-8 text-center">
        <h3 class="xv-display text-xl font-bold mb-2" style="color: var(--xv-text);">Butuh Bantuan?</h3>
        <p class="mb-4">Jika mengalami kendala, silakan hubungi tim support kami.</p>
        <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Support" class="xv-btn xv-btn-accent">Hubungi Support</a>
    </div>
@endsection