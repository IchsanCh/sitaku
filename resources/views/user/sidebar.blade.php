{{-- resources/views/user/sidebar.blade.php --}}
<div class="drawer lg:drawer-open">
    <!-- Mobile menu toggle -->
    <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />

    <!-- Sidebar content -->
    <div class="drawer-side z-40">
        <!-- Overlay for mobile -->
        <label for="drawer-toggle" aria-label="close sidebar" class="drawer-overlay"></label>

        <!-- Sidebar -->
        <aside class="min-h-full w-64 bg-base-200 text-base-content flex flex-col shadow-xl">
            <!-- Logo/Brand Section -->
            <div class="p-4 border-b border-base-300">
                <div class="flex items-center gap-3">
                    <div class="avatar">
                        <div class="w-10 rounded-full bg-primary text-primary-content flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z" />
                                <polyline points="9,9 9,13 11,13 11,9" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-primary">SITAKU</h2>
                        <p class="text-xs text-base-content/70">Notification System</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-4">
                <ul class="menu menu-vertical w-full space-y-2">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard.user') }}"
                            class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 hover:bg-primary hover:text-primary-content {{ request()->routeIs('dashboard') ? 'bg-primary text-primary-content' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>

                    <!-- Profile -->
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 hover:bg-primary hover:text-primary-content {{ request()->routeIs('profile') ? 'bg-primary text-primary-content' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="font-medium">Profile</span>
                        </a>
                    </li>

                    <!-- Template Pesan -->
                    <li>
                        <details class="group" {{ request()->routeIs('template.*') ? 'open' : '' }}>
                            <summary
                                class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 hover:bg-primary hover:text-primary-content cursor-pointer {{ request()->routeIs('template.*') ? 'bg-primary text-primary-content' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="font-medium">Template Pesan</span>
                                <svg class="w-4 h-4 ml-auto transition-transform group-open:rotate-180" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </summary>
                            <ul class="ml-8 mt-2 space-y-1">
                                <li>
                                    <a href="#"
                                        class="flex items-center gap-2 p-2 rounded-md transition-all duration-200 hover:bg-base-300 {{ request()->routeIs('template.index') ? 'bg-base-300' : '' }}">
                                        <div class="w-2 h-2 rounded-full bg-current opacity-60"></div>
                                        <span class="text-sm">Lihat Template</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center gap-2 p-2 rounded-md transition-all duration-200 hover:bg-base-300 {{ request()->routeIs('template.create') ? 'bg-base-300' : '' }}">
                                        <div class="w-2 h-2 rounded-full bg-current opacity-60"></div>
                                        <span class="text-sm">Buat Template</span>
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>

                    <!-- Log Pesan -->
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 hover:bg-primary hover:text-primary-content {{ request()->routeIs('logs') ? 'bg-primary text-primary-content' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span class="font-medium">Log Pesan</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <div class="divider my-4"></div>

                    <!-- Settings -->
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 hover:bg-primary hover:text-primary-content {{ request()->routeIs('settings') ? 'bg-primary text-primary-content' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="font-medium">Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Profile Section -->
            <div class="p-4 border-t border-base-300">
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
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 15l7-7 7 7" />
                        </svg>
                    </div>
                    <ul tabindex="0"
                        class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                        <li>
                            <a href="#" class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Pengaturan
                            </a>
                        </li>
                        <div class="divider my-1"></div>
                        <li>
                            <form method="POST" action="{{ route('logout.user') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 w-full text-error hover:bg-error hover:text-error-content">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>

<!-- Mobile Menu Button (place this in your main layout) -->
<div class="navbar lg:hidden bg-base-100 border-b border-base-300">
    <div class="flex-none">
        <label for="drawer-toggle" class="btn btn-square btn-ghost">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </label>
    </div>
    <div class="flex-1">
        <h1 class="text-xl font-bold">SITAKU</h1>
    </div>
    <div class="flex-none">
        <!-- Additional mobile header content -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-8 rounded-full">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=0891b2&color=fff' }}"
                        alt="Avatar" />
                </div>
            </div>
            <ul tabindex="0"
                class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                <li><a href="#">Profile</a></li>
                <li><a href="#">Pengaturan</a></li>
                <li>
                    <form method="POST" action="{{ route('logout.user') }}">
                        @csrf
                        <button type="submit" class="text-error">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
