<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'SITAKU')</title>
    @vite(['resources/css/app.css', 'resources/js/auth.js'])
    <meta property="og:title" content="@yield('title', 'SITAKU')">
    <meta name="description" content="@yield('meta_description', 'SITAKU adalah sistem notifikasi otomatis berbasis web yang membantu mengirimkan pesan WhatsApp ke pemohon dan pegawai secara real-time, tepat waktu, dan efisien.')">
    <meta property="og:description" content="@yield('og_description', 'Otomatisasi notifikasi ke pemohon dan pegawai dalam satu sistem yang cerdas dan mudah diatur.')">
    {{-- reCAPTCHA cuma diload di halaman yang beneran butuh (login/signup/forgot-password),
    lewat @push('head-scripts') di masing-masing view -- bukan di semua halaman auth. --}}
    @stack('head-scripts')
</head>

<body>
    <main>
        @yield('content')
    </main>
</body>

</html>