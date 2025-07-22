<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'SITAKU')</title>
    <meta property="og:title" content="@yield('title', 'SITAKU')">
    <meta name="description" content="@yield('meta_description', 'SITAKU adalah sistem notifikasi otomatis berbasis web yang membantu mengirimkan pesan WhatsApp ke pemohon dan pegawai secara real-time, tepat waktu, dan efisien.')">
    <meta property="og:description" content="@yield('og_description', 'Otomatisasi notifikasi ke pemohon dan pegawai dalam satu sistem yang cerdas dan mudah diatur.')">
</head>

<body>
    <x-navbar></x-navbar>
    <main>
        {{ $slot }}
    </main>
    <x-footer></x-footer>
    <script>
        AOS.init();

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
