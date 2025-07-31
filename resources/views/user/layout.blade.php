<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'SITAKU')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta property="og:title" content="@yield('title', 'SITAKU')">
    <meta name="description" content="@yield('meta_description', 'SITAKU adalah sistem notifikasi otomatis berbasis web yang membantu mengirimkan pesan WhatsApp ke pemohon dan pegawai secara real-time, tepat waktu, dan efisien.')">
    <meta property="og:description" content="@yield('og_description', 'Otomatisasi notifikasi ke pemohon dan pegawai dalam satu sistem yang cerdas dan mudah diatur.')">
</head>

<body>
    <main>
        @yield('content')
    </main>
    <script>
        AOS.init();
    </script>
</body>

</html>
