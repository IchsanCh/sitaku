<!DOCTYPE html>
<html lang="en" data-theme="sitaku-panel">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <title>@yield('title', 'SITAKU')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
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
            <div class="navbar lg:hidden bg-base-100 border-b border-base-300 sticky top-0 z-30">
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
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth('user')->user()?->name ?? 'User') }}&background=4f46e5&color=fff"
                                    alt="Avatar" />
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                            <li><a href="{{ route('profile.user') }}">Profile</a></li>
                            <div class="divider my-1"></div>
                            <form method="POST" action="{{ route('logout.user') }}">
                                @csrf
                                <li>
                                    <button type="submit" class="text-error w-full text-left">Logout</button>
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

        @include('user.sidebar')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const drawerToggle = document.getElementById('drawer-toggle');
            const menuLinks = document.querySelectorAll('.drawer-side a');

            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        drawerToggle.checked = false;
                    }
                });
            });
        });

        // Dipanggil dari menu/tombol yang dikunci fitur tier (mis. Custom Pesan
        // di sidebar). Bukan Swal.fire lagi -- dialog native DaisyUI, id
        // 'modal-feature-locked' di-declare di body (lihat di bawah).
        function showFeatureLockedAlert() {
            document.getElementById('modal-feature-locked').showModal();
        }
    </script>

    <dialog id="modal-feature-locked" class="modal">
        <div class="modal-box">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-warning/20 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-warning" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold">Anda Tidak Diizinkan</h3>
            </div>
            <p class="text-base-content/70 mb-6">
                Fitur ini tidak tersedia di paket Anda saat ini. Upgrade paket untuk membuka akses.
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modal-feature-locked').close()"
                    class="btn">Tutup</button>
                <a href="{{ route('pricing') }}" class="btn btn-primary">Lihat Paket</a>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</body>

</html>