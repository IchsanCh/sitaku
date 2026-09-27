{{--
    Shell buat halaman yang butuh fokus penuh (checkout/pembayaran) -- bukan
    dashboard biasa jadi sengaja TANPA sidebar/drawer punya layout2, tapi
    tetep pakai bundle exavro-panel yang sama (Tailwind + daisyUI + tema
    Exavro + showToast() dari panel.js) biar konsisten sama sisa halaman
    billing. Ini yang tadinya jadi sumber "billing-payment berantakan": view
    itu sebelumnya extends user.layout (bundle auth, gak ada Tailwind sama
    sekali), jadi semua class Tailwind/daisyUI di markup-nya gak ke-apply.
--}}
<!DOCTYPE html>
<html lang="id" data-theme="exavro-panel">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Exavro')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/exavro-panel.css', 'resources/js/panel.js'])
    @stack('styles')
    <meta property="og:title" content="@yield('title', 'Exavro')">
    <meta name="description"
        content="@yield('meta_description', 'Exavro adalah sistem notifikasi otomatis berbasis web yang membantu mengirimkan pesan WhatsApp ke pemohon dan pegawai secara real-time, tepat waktu, dan efisien.')">
    <meta property="og:description"
        content="@yield('og_description', 'Otomatisasi notifikasi ke pemohon dan pegawai dalam satu sistem yang cerdas dan mudah diatur.')">
</head>

<body class="bg-base-200">
    <div class="min-h-screen flex flex-col">
        <header class="navbar bg-base-100 border-b border-base-300 px-4 sm:px-6">
            <div class="flex-1 flex items-center gap-2">
                <img src="{{ asset('image/logoLotus.png') }}" alt="" class="h-6 w-auto">
                <span class="font-display font-bold tracking-tight">EXAVRO</span>
            </div>
            <div class="flex-none">
                <a href="{{ route('user.billing') }}" class="btn btn-ghost btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Billing
                </a>
            </div>
        </header>

        <main class="flex-1 flex items-center justify-center p-4 sm:p-6">
            @yield('content')
        </main>
    </div>

    {{-- Dipakai bareng window.showToast() dari panel.js --}}
    <div class="toast toast-top toast-end z-50" id="toastContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('error'))
                showToast('error', @json(session('error')));
            @endif
            @if (session('success'))
                showToast('success', @json(session('success')));
            @endif
            @if (session('info'))
                showToast('info', @json(session('info')));
            @endif
        });
    </script>

    @stack('scripts')
</body>

</html>