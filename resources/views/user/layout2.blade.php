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
            <div class="navbar lg:hidden border-b bg-base-300 border-base-300 sticky top-0 z-30">
                <div class="flex-none">
                    <label for="drawer-toggle" class="btn btn-square btn-ghost">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>
                <div class="flex-1">
                    <h1 class="text-xl font-bold text-primary">SITAKU</h1>
                </div>
                <div class="flex-none">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-8 rounded-full">
                                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=0891b2&color=fff' }}"
                                    alt="Avatar" />
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                            <li><a href="/profile">Profile</a></li>
                            <form method="POST" action="{{ route('logout.user') }}">
                                @csrf
                                <li>

                                    <button type="submit" class="text-error">Logout</button>
                                </li>
                            </form>
                        </ul>
                    </div>
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
        <div class="drawer-side z-40">
            <!-- Overlay for mobile -->
            <label for="drawer-toggle" aria-label="close sidebar" class="drawer-overlay"></label>

            <!-- Sidebar -->
            <aside class="min-h-full w-64 bg-base-200 text-base-content flex flex-col shadow-xl">
                <!-- Logo/Brand Section -->
                <div class="p-4 border-b bg-base-300 border-base-300">
                    <div class="flex items-center gap-3">
                        <div class="avatar">
                            <div class="w-10 rounded-full border-primary border-1 flex items-center justify-center">
                                <img src="{{ asset('image/logoLotus.png') }}" alt="Logo Lotusaja" class="h-full w-full">
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold color1">SITAKU</h2>
                            <p class="text-xs text-base-content/70">Notification System</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 bg-base-300 p-4">
                    <ul class="menu menu-vertical w-full space-y-2">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('dashboard.user') }}"
                                class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 colorss1 {{ request()->routeIs('dashboard.user') ? 'colors1 border-b-2 border-black text-primary-content' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        </li>

                        <!-- Profile -->
                        <li>
                            <a href="{{ route('user.pegawai') }}"
                                class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 colorss1 {{ request()->routeIs('user.pegawai') ? 'colors1 border-b-2 border-black' : '' }}">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>

                                <span class="font-medium">Pegawai</span>
                            </a>
                        </li>
                        <!-- Log Pesan -->
                        <li>
                            <details class="group" {{ request()->routeIs('pesan.*') ? 'open' : '' }}>
                                <summary
                                    class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 colorss1 cursor-pointer {{ request()->routeIs('pesan.*') ? '' : '' }}">
                                    <!-- Main menu icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span class="font-medium">Log Pesan</span>
                                </summary>

                                <ul class="ml-6 mt-2 border-l-2 border-base-300 pl-4">
                                    <li class="mt-4 mb-2">
                                        <a href="{{ route('pesan.user') }}"
                                            class="flex items-center gap-3 p-2 rounded-md transition-all duration-200 colorss1 {{ request()->routeIs('pesan.user') ? 'colors1 border-b-2 border-black' : '' }}">
                                            <!-- User icon for pemohon -->
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                            </svg>
                                            <span class="text-sm">Pesan Pemohon</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pesan.pegawai') }}"
                                            class="flex items-center gap-3 p-2 rounded-md transition-all duration-200 colorss1 {{ request()->routeIs('pesan.pegawai') ? 'colors1 border-b-2 border-black' : '' }}">
                                            <!-- Badge icon for pegawai -->
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                            <span class="text-sm">Pesan Pegawai</span>
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>
                        <li>
                            <a href="{{ route('user.billing') }}"
                                class="flex items-center gap-3 p-3 rounded-lg colorss1 transition-all duration-200 colorss1 {{ request()->routeIs('user.billing') ? 'colors1 border-b-2 border-black' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span class="font-medium">Billing</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('setting.user') }}"
                                class="flex items-center gap-3 p-3 rounded-lg colorss1 transition-all duration-200 colorss1 {{ request()->routeIs('setting.user') ? 'colors1 border-b-2 border-black' : '' }}">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="font-medium">Pengaturan</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- User Profile Section -->
                <div class="p-4 border-t hidden lg:inline-flex bg-base-300 border-base-300">
                    <div class="dropdown dropdown-top dropdown-end w-full">
                        <div tabindex="0" role="button" class="btn btn-ghost w-full justify-start p-3">
                            <div class="avatar">
                                <div class="w-8 rounded-full">
                                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=0891b2&color=fff' }}"
                                        alt="Avatar" />
                                </div>
                            </div>
                            <div class="flex flex-col items-start flex-1 min-w-0">
                                <span
                                    class="font-medium text-sm truncate w-full">{{ auth()->user()->name ?? 'User' }}</span>
                                <span
                                    class="text-xs text-base-content/70 truncate w-full">{{ auth()->user()->email ?? 'user@example.com' }}</span>
                            </div>
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 15l7-7 7 7" />
                            </svg>
                        </div>
                        <ul tabindex="0"
                            class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                            <li>
                                <a href="/profile" class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile
                                </a>
                            </li>
                            <div class="divider my-1"></div>
                            <form method="POST" action="{{ route('logout.user') }}">
                                @csrf
                                <li>

                                    <button type="submit"
                                        class="flex items-center gap-2 w-full text-error hover:bg-error hover:text-error-content">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </li>
                            </form>
                        </ul>
                    </div>
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
