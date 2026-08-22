<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Support Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher-js/8.4.0/pusher.min.js"></script>
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