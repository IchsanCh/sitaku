<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'EXAVRO') - Docs</title>
    @vite(['resources/css/app.css', 'resources/css/exavro-docs.css', 'resources/js/exavro-docs.js'])
    <meta property="og:title" content="@yield('title', 'EXAVRO')">
    <meta name="description" content="@yield('meta_description', 'Dokumentasi EXAVRO -- panduan setup, integrasi webhook, dan referensi API untuk sistem notifikasi otomatis berbasis WhatsApp.')">
    <meta property="og:description" content="@yield('og_description', 'Dokumentasi lengkap EXAVRO untuk instansi Anda.')">
</head>

<body style="background: var(--xv-paper);">
    <div class="xv-docs-shell">
        <!-- Overlay (mobile only) -->
        <div id="docs-overlay" class="fixed inset-0 xv-docs-overlay opacity-0 hidden transition-opacity duration-300 ease-in-out z-40 lg:hidden"></div>

        <!-- Sidebar -->
        <aside id="docs-sidebar"
            class="xv-docs-sidebar fixed lg:static inset-y-0 left-0 z-50 w-72 flex-shrink-0 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="p-5 flex items-center justify-between" style="border-bottom: 1px solid var(--xv-ink-line);">
                <a href="{{ route('home') }}" class="flex items-center gap-2" title="EXAVRO">
                    <img src="{{ asset('image/logoLotus.png') }}" alt="Lotus Logo" class="h-6" style="filter: brightness(0) invert(1);">
                    <span class="xv-wordmark">EXAVRO</span>
                </a>
                <button id="docs-close-menu" class="lg:hidden p-1" style="color: var(--xv-on-ink-soft);" title="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('home') }}" title="Home" class="xv-docs-navlink {{ request()->is('/') ? 'is-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Home
                </a>
                <a href="{{ route('about') }}" title="About" class="xv-docs-navlink {{ request()->is('about') ? 'is-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <rect x="3" y="4" width="18" height="16" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="9" cy="10" r="2.5" />
                        <path d="M15 8h3M15 12h3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M5 16h14" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M6 14c0-2 1.5-2 3-2s3 0 3 2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    About
                </a>
                <a href="{{ route('pricing') }}" title="Pricing" class="xv-docs-navlink {{ request()->is('pricing') ? 'is-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>
                    Pricing
                </a>

                <div class="my-3" style="border-top: 1px solid var(--xv-ink-line);"></div>

                <a href="/docs/getting-started" title="Getting Started" class="xv-docs-navlink {{ request()->is('docs/getting-started') ? 'is-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Getting Started
                </a>
                <a href="/docs/menu-wa" title="Menu WA" class="xv-docs-navlink {{ request()->is('docs/menu-wa') ? 'is-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    Menu WA
                </a>

                <details class="xv-docs-navgroup" {{ request()->is('docs/live-support/*') ? 'open' : '' }} title="Live Support">
                    <summary class="xv-docs-navlink {{ request()->is('docs/live-support/*') ? 'is-active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                        </svg>
                        Live Support
                        <svg class="xv-docs-navgroup-caret w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </summary>
                    <div class="xv-docs-navsub">
                        <a href="/docs/live-support/chat" title="Chat" class="xv-docs-navlink {{ request()->is('docs/live-support/chat') ? 'is-active' : '' }}">Chat</a>
                        <a href="/docs/live-support/balasan-cepat" title="Balasan Cepat" class="xv-docs-navlink {{ request()->is('docs/live-support/balasan-cepat') ? 'is-active' : '' }}">Balasan Cepat</a>
                        <a href="/docs/live-support/admin-support" title="Akun Admin Support" class="xv-docs-navlink {{ request()->is('docs/live-support/admin-support') ? 'is-active' : '' }}">Akun Admin Support</a>
                    </div>
                </details>

                <a href="/docs/api/sitaku" title="API EXAVRO" class="xv-docs-navlink {{ request()->is('docs/api/*') ? 'is-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                    API EXAVRO
                </a>
                <a href="/docs/cronjob" title="Cronjob Time" class="xv-docs-navlink {{ request()->is('docs/cronjob') ? 'is-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Cronjob Time
                </a>
            </nav>

            <div class="p-4" style="border-top: 1px solid var(--xv-ink-line);">
                <a href="/login" class="xv-btn xv-btn-accent w-full" title="Login">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                    </svg>
                    Login
                </a>
            </div>
        </aside>

        <!-- Content column -->
        <div class="flex-1 min-w-0 flex flex-col">
            <!-- Mobile topbar -->
            <div class="xv-docs-topbar flex items-center justify-between px-4 py-3 lg:hidden sticky top-0 z-30">
                <button id="docs-menu-toggle" class="p-1" title="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
                <a href="{{ route('home') }}" class="flex items-center gap-2" title="EXAVRO">
                    <img src="{{ asset('image/logoLotus.png') }}" alt="Lotus Logo" class="h-5" style="filter: brightness(0) invert(1);">
                    <span class="xv-wordmark text-base">EXAVRO</span>
                </a>
                <span class="w-6"></span>
            </div>

            <main class="flex-1">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-10 py-10 xv-docs-content xv-docs-article">
                    @yield('content')
                </div>
            </main>

            @include('components.footer')
        </div>
    </div>
</body>

</html>