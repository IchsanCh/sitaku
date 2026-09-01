@extends('user.layout3')

@section('title', 'Live Support - Akun Admin Support')

@section('meta_description',
    'Panduan mengelola akun admin support Exavro, yaitu siapa saja yang berwenang masuk ke
    panel live chat WhatsApp instansi.')

@section('og_description',
    'Dokumentasi pengelolaan akun admin support Exavro untuk panel live chat WhatsApp.')

@section('content')
    <h1 class="xv-display text-3xl font-bold mb-4" style="color: var(--xv-text);">Live Support: Akun Admin Support</h1>

    <div class="xv-callout xv-callout--info mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Akun admin support terpisah dari akun login instansi. Akun ini digunakan oleh
            staf untuk masuk ke panel chat dan menangani percakapan dengan pemohon.</span>
    </div>

    <h2 class="text-xl font-bold mb-3">Mengelola Akun</h2>
    <p class="mb-6">
        Pada sidebar panel instansi, buka <strong>Akun Admin Support</strong> untuk melihat,
        menambah, mengubah, atau menghapus akun. Setiap akun membutuhkan nama, email yang
        harus unik, dan kata sandi. Akun dapat dinonaktifkan sementara melalui toggle "Aktif"
        tanpa perlu dihapus.
    </p>

    <div class="xv-callout xv-callout--warning mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        <span>Menghapus akun admin support akan membuat akun tersebut tidak
            dapat masuk lagi. Pastikan tidak ada staf yang masih membutuhkan akses sebelum
            akun dihapus.</span>
    </div>

    <h2 class="text-xl font-bold mb-3">Masuk sebagai Admin Support</h2>
    <p class="mb-6">
        Staf yang telah memiliki akun dapat masuk melalui
        <a href="https://exavro.lotusaja.com/support/login" target="_blank" rel="noopener">exavro.lotusaja.com/support/login</a>.
        Halaman ini terpisah dari login instansi pada umumnya. Apabila lupa kata sandi, tersedia menu
        "Lupa password" pada halaman login yang sama.
    </p>

    <div class="xv-callout xv-callout--success mb-8">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Setelah berhasil masuk, admin akan langsung diarahkan ke Inbox
            <a href="/docs/live-support/chat">Live Support</a>.</span>
    </div>

    <div class="xv-docs-card p-8 text-center">
        <h3 class="xv-display text-xl font-bold mb-2" style="color: var(--xv-text);">Butuh Bantuan?</h3>
        <p class="mb-4">Jika mengalami kendala, silakan hubungi tim support kami.</p>
        <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Support" class="xv-btn xv-btn-accent">Hubungi Support</a>
    </div>
@endsection