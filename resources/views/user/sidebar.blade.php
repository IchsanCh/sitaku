{{--
    Sidebar panel user -- di-@include dari user/layout2.blade.php.
    Dipisah jadi file sendiri biar gampang maintenance (nambah/ubah menu
    gak perlu bongkar layout.blade.php yang isinya struktur drawer utuh).

    Butuh auth('user')->user() aja, gak gantungan variable yang di-pass dari
    controller manapun -- jadi aman di-include dari halaman mana pun yang
    extends layout2 (billing, pegawai, dashboard, dst - variable yang mereka
    pass ke view beda-beda, sidebar gak boleh gantungan salah satu).
--}}
@php
    $navUser = auth('user')->user();

    // Custom Pesan itu fitur toggle -- kalau tier user gak punya ini nyala,
    // menu tetep keliatan (biar user tau fiturnya ada) tapi dikunci +
    // munculin ajakan upgrade. Enforcement beneran tetep di middleware
    // 'feature:custom_pesan' di routes/web.php -- ini cuma UX, bukan security.
    $customPesanLocked = ! ($navUser?->hasFeature('custom_pesan') ?? false);

    // Balasan Cepat numpang feature yang sama kayak live support di menu WA --
    // gak ada gunanya punya balasan cepat kalau live support-nya sendiri gak kebuka.
    $quickReplyLocked = ! ($navUser?->hasFeature('menu_action_live_support') ?? false);
@endphp

<div class="drawer-side z-40">
    <!-- Overlay for mobile -->
    <label for="drawer-toggle" aria-label="close sidebar" class="drawer-overlay"></label>

    <!-- Sidebar -->
    <aside class="min-h-full w-64 bg-base-100 text-base-content flex flex-col border-r border-base-300">
        <!-- Logo/Brand Section -->
        <div class="p-4 border-b border-base-300">
            <div class="flex items-center gap-3">
                <div class="avatar">
                    <div class="w-10 rounded-full ring-1 ring-base-300 flex items-center justify-center">
                        <img src="{{ asset('image/logoLotus.png') }}" alt="Logo Lotusaja" class="h-full w-full">
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-base-content tracking-tight">SITAKU</h2>
                    <p class="text-xs text-base-content/50">Notification System</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-3 overflow-y-auto">
            <ul class="menu menu-vertical w-full gap-1 p-0">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard.user') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors
                            {{ request()->routeIs('dashboard.user') ? 'bg-primary text-primary-content' : 'hover:bg-base-200 text-base-content/80' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>

                <!-- Pegawai -->
                <li>
                    <a href="{{ route('user.pegawai') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors
                            {{ request()->routeIs('user.pegawai') ? 'bg-primary text-primary-content' : 'hover:bg-base-200 text-base-content/80' }}">
                        <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        Pegawai
                    </a>
                </li>

                <!-- Custom Pesan (locked kalau tier gak punya fiturnya) -->
                <li>
                    <details class="group" {{ request()->routeIs('custom.pesan.*') ? 'open' : '' }}>
                        <summary
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm cursor-pointer hover:bg-base-200 text-base-content/80 transition-colors">
                            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                            </svg>
                            <span class="flex-1">Custom Pesan</span>
                            @if ($customPesanLocked)
                                <svg class="w-3.5 h-3.5 text-base-content/30 shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            @endif
                        </summary>
                        <ul class="ml-4 mt-1 border-l border-base-300 pl-3 space-y-1">
                            <li>
                                <a href="{{ $customPesanLocked ? '#' : route('custom.pesan.pemohon') }}"
                                    @if ($customPesanLocked) onclick="event.preventDefault(); showFeatureLockedAlert()" @endif
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm transition-colors
                                        {{ $customPesanLocked ? 'text-base-content/35 cursor-not-allowed' : (request()->routeIs('custom.pesan.pemohon') ? 'bg-primary/10 text-primary font-medium' : 'hover:bg-base-200 text-base-content/70') }}">
                                    Pesan Pemohon
                                </a>
                            </li>
                            <li>
                                <a href="{{ $customPesanLocked ? '#' : route('custom.pesan.penyerahan') }}"
                                    @if ($customPesanLocked) onclick="event.preventDefault(); showFeatureLockedAlert()" @endif
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm transition-colors
                                        {{ $customPesanLocked ? 'text-base-content/35 cursor-not-allowed' : (request()->routeIs('custom.pesan.penyerahan') ? 'bg-primary/10 text-primary font-medium' : 'hover:bg-base-200 text-base-content/70') }}">
                                    Pesan Penyerahan
                                </a>
                            </li>
                            <li>
                                <a href="{{ $customPesanLocked ? '#' : route('custom.pesan.pegawai') }}"
                                    @if ($customPesanLocked) onclick="event.preventDefault(); showFeatureLockedAlert()" @endif
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm transition-colors
                                        {{ $customPesanLocked ? 'text-base-content/35 cursor-not-allowed' : (request()->routeIs('custom.pesan.pegawai') ? 'bg-primary/10 text-primary font-medium' : 'hover:bg-base-200 text-base-content/70') }}">
                                    Pesan Pegawai
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>

                <!-- Menu WA (state machine) -- menu.index kebuka buat semua tier,
                     cuma create/hapus slot baru yang eksklusif Premium (dicek di
                     dalem halamannya sendiri, bukan di sini). -->
                <li>
                    <a href="{{ route('menu.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors
                            {{ request()->routeIs('menu.*') ? 'bg-primary text-primary-content' : 'hover:bg-base-200 text-base-content/80' }}">
                        <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        Menu WA
                    </a>
                </li>

                <!-- Balasan Cepat (locked kalau tier gak punya menu_action_live_support) -->
                <li>
                    <a href="{{ $quickReplyLocked ? '#' : route('quick-reply.index') }}"
                        @if ($quickReplyLocked) onclick="event.preventDefault(); showFeatureLockedAlert()" @endif
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors
                            {{ $quickReplyLocked ? 'text-base-content/35 cursor-not-allowed' : (request()->routeIs('quick-reply.*') ? 'bg-primary text-primary-content' : 'hover:bg-base-200 text-base-content/80') }}">
                        <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                        </svg>
                        <span class="flex-1">Balasan Cepat</span>
                        @if ($quickReplyLocked)
                            <svg class="w-3.5 h-3.5 text-base-content/30 shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        @endif
                    </a>
                </li>

                <!-- Akun Admin Support (locked bareng Balasan Cepat, sama-sama butuh live support) -->
                <li>
                    <a href="{{ $quickReplyLocked ? '#' : route('admin-support.index') }}"
                        @if ($quickReplyLocked) onclick="event.preventDefault(); showFeatureLockedAlert()" @endif
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors
                            {{ $quickReplyLocked ? 'text-base-content/35 cursor-not-allowed' : (request()->routeIs('admin-support.*') ? 'bg-primary text-primary-content' : 'hover:bg-base-200 text-base-content/80') }}">
                        <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span class="flex-1">Akun Admin Support</span>
                        @if ($quickReplyLocked)
                            <svg class="w-3.5 h-3.5 text-base-content/30 shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        @endif
                    </a>
                </li>

                <!-- Log Pesan -->
                <li>
                    <details class="group" {{ request()->routeIs('pesan.*') ? 'open' : '' }}>
                        <summary
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm cursor-pointer hover:bg-base-200 text-base-content/80 transition-colors">
                            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span class="flex-1">Log Pesan</span>
                        </summary>
                        <ul class="ml-4 mt-1 border-l border-base-300 pl-3 space-y-1">
                            <li>
                                <a href="{{ route('pesan.user') }}"
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm transition-colors
                                        {{ request()->routeIs('pesan.user') ? 'bg-primary/10 text-primary font-medium' : 'hover:bg-base-200 text-base-content/70' }}">
                                    Pesan Pemohon
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pesan.pegawai') }}"
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm transition-colors
                                        {{ request()->routeIs('pesan.pegawai') ? 'bg-primary/10 text-primary font-medium' : 'hover:bg-base-200 text-base-content/70' }}">
                                    Pesan Pegawai
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>

                <!-- Billing -->
                <li>
                    <a href="{{ route('user.billing') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors
                            {{ request()->routeIs('user.billing') ? 'bg-primary text-primary-content' : 'hover:bg-base-200 text-base-content/80' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Billing
                    </a>
                </li>

                <!-- Pengaturan -->
                <li>
                    <a href="{{ route('setting.user') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors
                            {{ request()->routeIs('setting.user') ? 'bg-primary text-primary-content' : 'hover:bg-base-200 text-base-content/80' }}">
                        <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Pengaturan
                    </a>
                </li>
            </ul>
        </nav>

        <!-- User Profile Section -->
        <div class="p-3 border-t border-base-300 hidden lg:block">
            <div class="dropdown dropdown-top dropdown-end w-full">
                <div tabindex="0" role="button"
                    class="flex items-center gap-3 w-full p-2 rounded-lg hover:bg-base-200 transition-colors">
                    <div class="avatar">
                        <div class="w-9 rounded-full ring-1 ring-base-300">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($navUser?->name ?? 'User') }}&background=4f46e5&color=fff"
                                alt="Avatar" />
                        </div>
                    </div>
                    <div class="flex flex-col items-start flex-1 min-w-0">
                        <span class="font-medium text-sm truncate w-full">{{ $navUser?->name ?? 'User' }}</span>
                        <span
                            class="text-xs text-base-content/50 truncate w-full">{{ $navUser?->email ?? 'user@example.com' }}</span>
                    </div>
                    <svg class="w-4 h-4 shrink-0 text-base-content/40" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                    <li>
                        <a href="{{ route('profile.user') }}" class="flex items-center gap-2">
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
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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