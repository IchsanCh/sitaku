<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Support Panel')</title>
    @vite(['resources/css/support.css', 'resources/js/support.js'])
    @stack('head-scripts')
</head>
<body class="bg-base-200 min-h-screen">
    @auth('support')
        <div class="navbar bg-base-100 shadow-sm px-6">
            <div class="flex-1">
                <a href="{{ route('support.inbox') }}" class="text-lg font-bold">SITAKU Support</a>
            </div>
            <div class="flex-none gap-3 items-center">
                <span class="text-sm text-base-content/60">{{ auth('support')->user()->name }}</span>
                <form action="{{ route('support.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Keluar</button>
                </form>
            </div>
        </div>
    @endauth

    <div id="toastContainer" class="toast toast-top toast-end z-50"></div>

    @yield('content')

    <script>
        function showToast(type, message) {
            const el = document.createElement('div');
            el.className = `alert ${type === 'error' ? 'alert-error' : 'alert-success'}`;
            el.innerHTML = `<span>${message}</span>`;
            document.getElementById('toastContainer').appendChild(el);
            setTimeout(() => el.remove(), 4000);
        }
    </script>
    @yield('scripts')
</body>
</html>