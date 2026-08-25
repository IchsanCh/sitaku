<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'SITAKU')</title>
    @vite(['resources/css/app.css'])
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
                    <img src="{{ asset('image/logoLotus.png') }}" alt="Logo lotusaja" class="h-5 w-auto image-white"
                        title="Logo Lotusaja">
                    <h1 class="text-xl font-bold text-white">SITAKU</h1>
                </div>
            </div>

            <!-- Main Content Area -->
            <main class="min-h-screen">
                <div class="container mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>

            @include('components.footer')
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
                            <a href="{{ route('home') }}" title="Home"
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
                            <a href="{{ route('about') }}" title="About"
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
                            <a href="{{ route('pricing') }}" title="Pricing"
                                class="flex items-center text-white lisa gap-3 p-3 rounded-lg transition-all duration-200 {{ request()->is('about') ? 'bgc2 border-b-2 border-white' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                </svg>
                                <span class="font-medium">Pricing</span>
                            </a>
                        </li>
                        <li>
                            <a href="/docs/getting-started" title="Getting Started"
                                class="flex items-center text-white lisa gap-3 p-3 rounded-lg transition-all duration-200 {{ request()->is('docs/getting-started') ? 'bgc2 border-b-2 border-white' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                <span class="font-medium">Getting Started</span>
                            </a>
                        </li>
                        <!-- Menu WA -->
                        <li>
                            <a href="/docs/menu-wa" title="Menu WA"
                                class="flex items-center text-white lisa gap-3 p-3 rounded-lg transition-all duration-200 {{ request()->is('docs/menu-wa') ? 'bgc2 border-b-2 border-white' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span class="font-medium">Menu WA</span>
                            </a>
                        </li>

                        <!-- Live Support -->
                        <li>
                            <details class="group" {{ request()->is('docs/live-support/*') ? 'open' : '' }}
                                title="Live Support">
                                <summary
                                    class="flex items-center gap-3 p-3 lisa rounded-lg transition-all duration-200 text-white cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                                    </svg>
                                    <span class="font-medium">Live Support</span>
                                </summary>

                                <ul class="ml-6 mt-2 border-l-2 border-base-300 pl-4">
                                    <li class="mt-4 mb-2">
                                        <a href="/docs/live-support/chat" title="Chat"
                                            class="flex items-center gap-3 p-2 rounded-md transition-all duration-200 lisa text-white {{ request()->is('docs/live-support/chat') ? 'bgc2 border-b-2 border-white' : '' }}">
                                            <span class="text-sm">Chat</span>
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="/docs/live-support/balasan-cepat" title="Balasan Cepat"
                                            class="flex items-center gap-3 p-2 rounded-md transition-all duration-200 lisa text-white {{ request()->is('docs/live-support/balasan-cepat') ? 'bgc2 border-b-2 border-white' : '' }}">
                                            <span class="text-sm">Balasan Cepat</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/docs/live-support/admin-support" title="Akun Admin Support"
                                            class="flex items-center gap-3 p-2 rounded-md transition-all duration-200 lisa text-white {{ request()->is('docs/live-support/admin-support') ? 'bgc2 border-b-2 border-white' : '' }}">
                                            <span class="text-sm">Akun Admin Support</span>
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>

                        <!-- API Reference (cuma API SITAKU) -->
                        <li>
                            <a href="/docs/api/sitaku" title="API SITAKU"
                                class="flex items-center gap-3 p-3 rounded-lg lisa transition-all duration-200 text-white {{ request()->is('docs/api/sitaku') ? 'bgc2 border-b-2 border-white' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                </svg>
                                <span class="font-medium">API SITAKU</span>
                            </a>
                        </li>
                        <li>
                            <a href="/docs/cronjob" title="Cronjob Time"
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
                    <a href="/login" class="btn btn-success w-full font-bold" title="Login">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                            </svg>
                        Login
                    </a>
                </div>
            </aside>
        </div>
    </div>

    <script>
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