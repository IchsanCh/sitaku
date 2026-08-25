@extends('user.layout3')

@section('title', 'Live Support - Akun Admin Support')

@section('meta_description',
    'Panduan mengelola akun admin support Sitaku -- siapa aja yang boleh login ke panel
    live chat WhatsApp instansi.')

@section('og_description',
    'Dokumentasi pengelolaan akun admin support Sitaku untuk panel live chat WhatsApp.')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h1 class="card-title text-3xl font-bold mb-4">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Live Support -- Akun Admin Support
            </h1>

            <div class="alert alert-info mb-6 font-semibold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Akun admin support terpisah dari akun login instansi -- ini akun yang
                    dipakai staf buat login ke panel chat dan menangani percakapan pemohon.</span>
            </div>

            <h2 class="text-xl font-bold mb-3">Kelola Akun</h2>
            <p class="font-semibold mb-6">
                Dari sidebar panel instansi, buka <strong>Akun Admin Support</strong> buat lihat,
                tambah, edit, atau hapus akun. Setiap akun butuh nama, email (harus unik), dan
                password. Akun bisa dinonaktifkan sementara lewat toggle "Aktif" tanpa perlu dihapus.
            </p>

            <div class="alert alert-warning mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span class="text-sm">Menghapus akun admin support langsung bikin akun itu gak bisa
                    login lagi -- pastikan gak ada yang lagi butuh akses sebelum dihapus.</span>
            </div>

            <h2 class="text-xl font-bold mb-3">Login Admin Support</h2>
            <p class="font-semibold mb-4">
                Staf yang punya akun login lewat <code>/support/login</code> -- halaman ini terpisah
                dari login instansi biasa. Kalau lupa password, tersedia menu "Lupa password" di
                halaman login yang sama.
            </p>

            <div class="alert alert-success mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm">Setelah login, admin langsung masuk ke Inbox
                    <a href="/docs/live-support/chat" class="link link-primary font-semibold">Live Support</a>.</span>
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