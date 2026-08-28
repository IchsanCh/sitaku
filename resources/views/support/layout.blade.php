<!DOCTYPE html>
<html lang="id" data-theme="sitaku-support">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Support Panel')</title>
    @vite(['resources/css/support.css', 'resources/js/support.js'])
    @stack('head-scripts')
</head>
<body class="bg-base-200 min-h-screen">
    @auth('support')
        <div class="navbar bg-base-100 border-b border-base-300 px-4 sm:px-6 py-2.5">
            <div class="flex-1 flex items-center gap-2.5">
                <a href="{{ route('support.inbox') }}" class="flex items-center gap-2.5 group">
                    <span class="w-8 h-8 rounded-lg bg-primary text-primary-content flex items-center justify-center font-display font-semibold text-sm">EX</span>
                    <span class="font-display font-semibold text-base leading-none">Help Desk</span>
                </a>
                <span class="hidden sm:flex items-center gap-1.5 ml-2 pl-2.5 border-l border-base-300 text-xs text-base-content/50">
                    <span class="pulse-dot" id="connectionDot" title="Status koneksi realtime"></span>
                    <span id="connectionLabel">Terhubung</span>
                </span>
            </div>
            <div class="flex-none flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 text-sm">
                    <span class="w-6 h-6 rounded-full bg-base-200 flex items-center justify-center text-[0.65rem] font-mono font-medium text-base-content/60">
                        {{ strtoupper(substr(auth('support')->user()->name, 0, 1)) }}
                    </span>
                    <span class="text-base-content/70">{{ auth('support')->user()->name }}</span>
                </div>
                <form action="{{ route('support.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    @endauth

    <div id="toastContainer" class="toast toast-top toast-end z-50"></div>

    @yield('content')

    <script>
        function showToast(type, message) {
            const el = document.createElement('div');
            el.className = `alert ${type === 'error' ? 'alert-error' : 'alert-success'} shadow-lg text-sm`;
            el.innerHTML = `<span>${message}</span>`;
            document.getElementById('toastContainer').appendChild(el);
            setTimeout(() => el.remove(), 4000);
        }

        // Dipanggil dari script Pusher tiap halaman (inbox/chat) lewat
        // pusher.connection.bind(...) -- satu sumber kebenaran buat nampilin
        // status live di navbar biar konsisten di semua halaman.
        function setConnectionStatus(connected) {
            const dot = document.getElementById('connectionDot');
            const label = document.getElementById('connectionLabel');
            if (!dot) return;
            dot.classList.toggle('is-offline', !connected);
            if (label) label.textContent = connected ? 'Terhubung' : 'Terputus';
        }
    </script>
    @yield('scripts')
</body>
</html>