<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/css/exavro.css', 'resources/js/public.js'])
    <title>@yield('title', 'EXAVRO')</title>
    <meta property="og:title" content="@yield('title', 'EXAVRO')">
    <meta name="description" content="@yield('meta_description', 'EXAVRO adalah sistem notifikasi otomatis berbasis web yang membantu mengirimkan pesan WhatsApp ke pemohon dan pegawai secara real-time, tepat waktu, dan efisien.')">
    <meta property="og:description" content="@yield('og_description', 'Otomatisasi notifikasi ke pemohon dan pegawai dalam satu sistem yang cerdas dan mudah diatur.')">
</head>

<body>
    <x-navbar></x-navbar>
    <main>
        {{ $slot }}
    </main>
    <x-footer></x-footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll(".nav-link");

            navLinks.forEach((link) => {
                link.addEventListener("click", function(e) {
                    navLinks.forEach((navLink) => {
                        navLink.classList.remove("active");
                    });
                    this.classList.add("active");
                });
            });
            // Scroll ke section berdasarkan parameter
            const urlParams = new URLSearchParams(window.location.search);
            const section = urlParams.get("section");

            if (section) {
                const target = document.getElementById(section);
                if (target) {
                    setTimeout(() => {
                        target.scrollIntoView({
                            behavior: "smooth",
                            block: "start"
                        });
                    }, 300); // delay dikit biar AOS juga sempat inisialisasi
                }
            }
        });
    </script>
</body>

</html>