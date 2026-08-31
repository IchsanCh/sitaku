<div class="navbar xv-navbar shadow-sm sticky top-0 z-30">
    <div class="navbar-start pl-4">
        <button id="menu-toggle" class="btn btn-ghost md:hidden xv-btn-ghost-onink" title="Menu-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
        <a href="{{ route('home') }}" class="xv-wordmark ml-2 md:hidden" title="exavro">EXAVRO</a>
        <!-- Logo -->
        <a href="{{ route('home') }}"
            class="flex flex-row items-center gap-2 hidden md:flex"
            title="Website exavro">
            <img src="{{ asset('image/logoLotus.png') }}" alt="Lotus Logo" class="h-7"
                style="filter: brightness(0) invert(1);">
            <span class="xv-wordmark">EXAVRO</span>
        </a>
    </div>

    <!-- Desktop Navigation (Hidden on Small Screens) -->
    <div class="navbar-center hidden md:flex">
        <ul class="menu menu-horizontal px-1 gap-6">
            <li title="Home">
                <a href="/"
                    class="xv-navlink flex items-center gap-2 px-1 {{ request()->is('/') ? 'is-active' : '' }}">
                    Home
                </a>
            </li>
            <li title="About">
                <a href="/about"
                    class="xv-navlink flex items-center gap-2 px-1 {{ request()->is('about') ? 'is-active' : '' }}">
                    About Us
                </a>
            </li>
            <li title="Pricing">
                <a href="/pricing"
                    class="xv-navlink flex items-center gap-2 px-1 {{ request()->is('pricing') ? 'is-active' : '' }}">
                    Pricing
                </a>
            </li>
            <li title="Documentation">
                <a href="/docs/getting-started"
                    class="xv-navlink flex items-center gap-2 px-1 {{ request()->is('docs*') ? 'is-active' : '' }}">
                    Documentation
                </a>
            </li>
        </ul>
    </div>

    <!-- Right Side Action Button -->
    <div class="navbar-end pr-6">
        <a href="/login" title="Login" class="xv-btn xv-btn-accent !py-2 !px-4 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
            </svg>
            Login
        </a>
    </div>
</div>

<!-- Mobile Sidebar (Off-Canvas) -->
<div id="overlay"
    class="fixed inset-0 bg-black bg-opacity-0 transition-opacity duration-300 ease-in-out z-40 hidden">
</div>

<div id="sidebar"
    class="fixed top-0 left-0 h-screen w-64 shadow-lg xv-sidebar transform -translate-x-full transition-transform duration-300 ease-in-out z-50 overflow-y-auto md:hidden">
    <!-- Sidebar Header -->
    <div class="p-4 flex justify-between items-center" style="border-bottom: 1px solid var(--xv-ink-line);">
        <div class="flex items-center gap-2">
            <img src="{{ asset('image/logoLotus.png') }}" alt="Lotus Logo" class="h-6"
                style="filter: brightness(0) invert(1);">
            <span class="xv-wordmark text-lg">EXAVRO</span>
        </div>
        <button id="close-menu" class="p-2 rounded-full xv-btn-ghost-onink" title="Close">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <ul class="menu p-4 space-y-1 mt-2 w-full">
        <li title="Home">
            <a href="/"
                class="xv-navlink flex items-center gap-3 p-3 rounded-lg {{ request()->is('/') ? 'is-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Home
            </a>
        </li>
        <li title="About">
            <a href="/about"
                class="xv-navlink flex items-center gap-3 p-3 rounded-lg {{ request()->is('about') ? 'is-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <rect x="3" y="4" width="18" height="16" rx="2" ry="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="9" cy="10" r="2.5" />
                    <path d="M15 8h3M15 12h3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M5 16h14" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 14c0-2 1.5-2 3-2s3 0 3 2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                About Us
            </a>
        </li>
        <li title="Pricing">
            <a href="/pricing"
                class="xv-navlink flex items-center gap-3 p-3 rounded-lg {{ request()->is('pricing') ? 'is-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
                Pricing
            </a>
        </li>
        <li title="Documentation">
            <a href="/docs/getting-started"
                class="xv-navlink flex items-center gap-3 p-3 rounded-lg {{ request()->is('docs*') ? 'is-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Documentation
            </a>
        </li>
    </ul>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar functionality
        const menuToggle = document.getElementById('menu-toggle');
        const closeMenu = document.getElementById('close-menu');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        // Function to open sidebar
        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.add('bg-opacity-50');
                overlay.classList.remove('bg-opacity-0');
            }, 50);
        }

        // Function to close sidebar
        function closeSidebar() {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('bg-opacity-50');
            overlay.classList.add('bg-opacity-0');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }

        // Event listeners for sidebar toggle
        if (menuToggle) {
            menuToggle.addEventListener('click', openSidebar);
        }

        if (closeMenu) {
            closeMenu.addEventListener('click', closeSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });
    });
</script>