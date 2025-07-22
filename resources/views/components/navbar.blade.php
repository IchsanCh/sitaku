<div class="navbar shadow-sm bgc1 text-white sticky top-0 z-30">
    <div class="navbar-start pl-4">
        <button id="menu-toggle" class="btn btn-ghost md:hidden" title="Menu-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
        <a href="https://lotusaja.com" class="font-2xl font-semibold text-white ml-2 hover:font-bold md:hidden"
            title="sitaku">SITAKU</a>
        <!-- Logo -->
        <a href="https://lotusaja.com"
            class="flex flex-row items-center hover:text-green-500 transition-colors hidden md:flex"
            title="Website sitaku">
            <img src="{{ asset('image/logoLotus.png') }}" alt="Lotus Logo" class="h-8"
                style="filter: brightness(0) invert(1);">
            <span class="font-semibold text-xl ml-2">SITAKU</span>
        </a>
    </div>

    <!-- Desktop Navigation (Hidden on Small Screens) -->
    <div class="navbar-center hidden md:flex">
        <ul class="menu menu-horizontal px-1 gap-4">
            <li title="Home">
                <a href="/"
                    class="flex items-center gap-2 lisa rounded-lg px-4 transition-colors {{ request()->is('/') ? 'bgc2 text-white font-semibold border-b-2 border-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Home
                </a>
            </li>
            <li title="About">
                <a href="/about"
                    class="flex items-center gap-3 rounded-lg lisa transition-colors {{ request()->is('about*') ? 'bgc2 text-white font-semibold border-b-2 border-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
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
            <li title="Documentation">
                <a href="/docs/getting-started"
                    class="flex items-center gap-3 rounded-lg lisa transition-colors {{ request()->is('docs*') ? 'bgc2 text-white font-semibold border-b-2 border-white' : '' }}">
                    <i class="fa-solid fa-book"></i>
                    Documentation
                </a>
            </li>
        </ul>
    </div>

    <!-- Right Side Action Button -->
    <div class="navbar-end pr-6">
        <a href="/login" title="Login"
            class="rounded-lg px-4 py-2 gets flex items-center justify-center gap-2 font-semibold hover:font-bold transition-all md:text-sm">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
            Login
        </a>
    </div>
</div>

<!-- Mobile Sidebar (Off-Canvas) -->
<div id="overlay"
    class="fixed inset-0 bg-transparent bg-opacity-0 transition-opacity duration-300 ease-in-out z-40 hidden">
</div>

<div id="sidebar"
    class="fixed top-0 left-0 h-screen w-64 shadow-lg bg-base-300 transform -translate-x-full transition-transform duration-300 ease-in-out bg-base-400 z-50 overflow-y-auto md:hidden">
    <!-- Sidebar Header -->
    <div class="p-3 flex justify-between items-center bgc1">
        <div class="flex items-center">
            <img src="{{ asset('image/logoLotus.png') }}" alt="Lotus Logo" class="h-6"
                style="filter: brightness(0) invert(1);">
            <h2 class="text-lg font-bold ml-2 text-white">SITAKU</h2>
        </div>
        <button id="close-menu" class="p-2 rounded-full lisa">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <ul class="menu p-4 space-y-2 mt-2 w-full">
        <li title="Home">
            <a href="/"
                class="flex items-center gap-3 p-3 rounded-lg lisa transition-colors  {{ request()->is('/') ? 'bgc2 text-white' : '' }}">
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
                class="flex items-center gap-3 p-3 rounded-lg lisa transition-colors {{ request()->is('about*') ? 'bgc2 text-white' : '' }}">
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
        <li title="Documentation">
            <a href="/docs/getting-started"
                class="flex items-center gap-3 p-3 rounded-lg lisa transition-colors {{ request()->is('docs*') ? 'bgc2 text-white' : '' }}">
                <i class="fa-solid fa-book"></i>
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
