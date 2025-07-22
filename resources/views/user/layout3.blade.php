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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>@yield('title', 'SITAKU')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta property="og:title" content="@yield('title', 'SITAKU')">
    <meta name="description" content="@yield('meta_description', 'SITAKU adalah sistem notifikasi otomatis berbasis web yang membantu mengirimkan pesan WhatsApp ke pemohon dan pegawai secara real-time, tepat waktu, dan efisien.')">
    <meta property="og:description" content="@yield('og_description', 'Otomatisasi notifikasi ke pemohon dan pegawai dalam satu sistem yang cerdas dan mudah diatur.')">
</head>

<body class="bg-base-100">
    <div class="drawer lg:drawer-open">
        <!-- Mobile menu toggle -->
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />

        <!-- Main Content Wrapper -->
        <div class="drawer-content">
            <!-- Mobile Header (visible only on mobile) -->
            <div class="navbar lg:hidden bgc1 flex justify-between sticky top-0 z-30">
                <div class="flex-none">
                    <label for="drawer-toggle" class="btn btn-square btn-ghost">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>
                <div class="flex flex-row items-center gap-2 pr-2.5">
                    <img src="{{ asset('image/logoLotus.png') }}" alt="Logo lotusaja" class="h-5 w-auto image-white">
                    <h1 class="text-xl font-bold text-white">SITAKU</h1>
                </div>
            </div>

            <!-- Main Content Area -->
            <main class="min-h-screen">
                <div class="container mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>

            @include('user.footer')
        </div>

        <!-- Sidebar content -->
        <div class="drawer-side bg-transparant z-40">
            <!-- Overlay for mobile -->
            <label for="drawer-toggle" aria-label="close sidebar" class="drawer-overlay"></label>

            <!-- Sidebar -->
            <aside class="min-h-full w-64 bgc5 text-base-content flex flex-col shadow-xl">
                <!-- Logo/Brand Section -->
                <div class="p-4 bgc1">
                    <div class="flex items-center gap-3">
                        <div class="avatar">
                            <div
                                class="w-10 rounded-full border-white bg-black border-1 flex items-center justify-center">
                                <img src="{{ asset('image/logoLotus.png') }}" alt="Logo Lotusaja"
                                    class="h-full w-full image-white">
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">SITAKU</h2>
                            <p class="text-xs text-white">Notification System</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 bgc5 p-4">
                    <ul class="menu menu-vertical w-full space-y-2">
                        <!-- Home -->
                        <li>
                            <a href="{{ route('home') }}"
                                class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 text-white lisa {{ request()->is('home') ? 'bgc2 border-b-2 border-white' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="font-medium">Home</span>
                            </a>
                        </li>

                        <!-- About -->
                        <li>
                            <a href="{{ route('about') }}"
                                class="flex items-center text-white lisa gap-3 p-3 rounded-lg transition-all duration-200 {{ request()->is('about') ? 'bgc2 border-b-2 border-white' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <rect x="3" y="4" width="18" height="16" rx="2" ry="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="9" cy="10" r="2.5" />
                                    <path d="M15 8h3M15 12h3" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5 16h14" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6 14c0-2 1.5-2 3-2s3 0 3 2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                                <span class="font-medium">About</span>
                            </a>
                        </li>
                        <li>
                            <a href="/docs/getting-started"
                                class="flex items-center text-white lisa gap-3 p-3 rounded-lg transition-all duration-200 {{ request()->is('docs/getting-started') ? 'bgc2 border-b-2 border-white' : '' }}">
                                <i class="fa-solid fa-book"></i>
                                <span class="font-medium">Getting Started</span>
                            </a>
                        </li>
                        <!-- API References -->
                        <li>
                            <details class="group" {{ request()->is('docs/api/*') ? 'open' : '' }}>
                                <summary
                                    class="flex items-center gap-3 p-3 lisa rounded-lg transition-all duration-200 text-white cursor-pointer {{ request()->is('docs/api/*') ? '' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                    <span class="font-medium">API References</span>
                                </summary>

                                <ul class="ml-6 mt-2 border-l-2 border-base-300 pl-4">
                                    <li class="mt-4 mb-2">
                                        <a href="/docs/api/pemohon"
                                            class="flex items-center gap-3 p-2 rounded-md transition-all duration-200 lisa text-white {{ request()->is('docs/api/pemohon') ? 'bgc2 border-b-2 border-white' : '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="text-sm">API Pemohon</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/docs/api/sitaku"
                                            class="flex items-center gap-3 p-2 rounded-md transition-all duration-200 lisa text-white {{ request()->is('docs/api/sitaku') ? 'bgc2 border-b-2 border-white' : '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                            </svg>
                                            <span class="text-sm">API SITAKU</span>
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>
                        <li>
                            <a href="/docs/cronjob"
                                class="flex items-center gap-3 p-3 rounded-lg lisa transition-all duration-200 text-white {{ request()->is('docs/cronjob') ? 'bgc2 border-b-2 border-white' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-5 h-5"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="font-medium">Cronjob Time</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="p-4 bgc1 w-full">
                    <a href="/login" class="btn btn-success w-full font-bold"><i
                            class="fa-solid fa-arrow-right-to-bracket"></i> Login</a>
                </div>
            </aside>
        </div>
    </div>

    <script>
        AOS.init();
        // Auto-close mobile menu when clicking a link
        document.addEventListener('DOMContentLoaded', function() {
            const drawerToggle = document.getElementById('drawer-toggle');
            const menuLinks = document.querySelectorAll('.drawer-side a');

            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) { // Only on mobile
                        drawerToggle.checked = false;
                    }
                });
            });
        });
    </script>
</body>

</html>
