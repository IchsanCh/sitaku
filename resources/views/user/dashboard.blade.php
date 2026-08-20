@extends('user.layout2')

@section('title', 'Dashboard')
@section('meta_description', 'Selamat datang di Dashboard SITAKU! Atur notifikasi otomatis dan cek log pesan di sini.')
@section('og_description', 'Gunakan Dashboard SITAKU untuk mengelola semua notifikasi WhatsApp secara otomatis.')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <!-- Header -->
        <div class="mb-8">
            <p class="text-sm font-semibold text-primary mb-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            <h1 class="text-2xl md:text-3xl font-bold text-base-content tracking-tight">Halo, {{ $user->name }} 👋</h1>
            <p class="text-base-content/60 mt-1">Berikut ringkasan aktivitas notifikasi Anda.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <!-- Pesan Terkirim (hero metric -- diisi solid, beda dari 2 lainnya) -->
            <div class="rounded-2xl bg-primary text-primary-content p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-10 h-10 rounded-lg bg-white/15 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold" id="totalMessages">{{ $totalPesanTerkirim ?? '0' }}</p>
                <p class="text-sm text-primary-content/70 mt-1">
                    Pesan Terkirim &middot; {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                </p>
            </div>

            <!-- Total Pegawai -->
            <div class="rounded-2xl border border-base-300 bg-base-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-base-content">{{ $pegawai->count() ?? '0' }}</p>
                <p class="text-sm text-base-content/50 mt-1">Total Pegawai Terdaftar</p>
            </div>

            <!-- Sisa Pesan (Fonnte quota) -->
            <div class="rounded-2xl border border-base-300 bg-base-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-base-content" id="remainingMessages">
                    {{ $fonnteInfo['quota'] ?? 'N/A' }}
                </p>
                <p class="text-sm text-base-content/50 mt-1">
                    Fonnte &middot; {{ $fonnteInfo['package'] ?? 'Token tidak valid' }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- Pengumuman -->
            <div class="lg:col-span-2 rounded-2xl border border-base-300 bg-base-100 p-6">
                <div class="flex items-center gap-2 mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                    </svg>
                    <h2 class="font-semibold text-base-content">Pengumuman Terakhir</h2>
                </div>

                <div class="space-y-3">
                    @forelse ($announcement as $a)
                        <div class="rounded-xl p-4 bg-base-200/60 border border-base-300">
                            <h3 class="font-semibold text-base-content mb-1.5">{{ $a->name }}</h3>
                            <div class="prose prose-sm max-w-none text-base-content/70">
                                {!! $a->description !!}
                            </div>
                            <p class="mt-2 text-xs text-base-content/40">
                                Diumumkan pada {{ $a->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-base-content/40 text-sm">Belum ada pengumuman.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Aksi Cepat + Status Sistem -->
            <div class="rounded-2xl border border-base-300 bg-base-100 p-6">
                <h2 class="font-semibold text-base-content mb-4">Aksi Cepat</h2>
                <div class="space-y-1.5 mb-6">
                    <a href="{{ route('user.pegawai') }}"
                        class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-base-200 transition-colors group">
                        <div
                            class="w-9 h-9 rounded-lg bg-secondary/10 flex items-center justify-center shrink-0 group-hover:bg-secondary/20">
                            <svg class="w-4.5 h-4.5 text-secondary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-base-content flex-1">Kelola Pegawai</span>
                        <svg class="w-4 h-4 text-base-content/30" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('pesan.pegawai') }}"
                        class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-base-200 transition-colors group">
                        <div
                            class="w-9 h-9 rounded-lg bg-accent/10 flex items-center justify-center shrink-0 group-hover:bg-accent/20">
                            <svg class="w-4.5 h-4.5 text-accent" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                <path d="M8,12H16V14H8V12M8,16H13V18H8V16Z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-base-content flex-1">Log Pesan Pegawai</span>
                        <svg class="w-4 h-4 text-base-content/30" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('setting.user') }}"
                        class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-base-200 transition-colors group">
                        <div
                            class="w-9 h-9 rounded-lg bg-info/10 flex items-center justify-center shrink-0 group-hover:bg-info/20">
                            <svg class="w-4.5 h-4.5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-base-content flex-1">Pengaturan</span>
                        <svg class="w-4 h-4 text-base-content/30" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="border-t border-base-300 pt-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-base-content/40 mb-3">Status Sistem</h3>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                <span class="text-sm text-base-content/70">Service</span>
                            </div>
                            <span class="text-xs font-medium text-base-content/50">
                                {{ $user->status === 'active' ? 'Online' : 'Offline' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                <span class="text-sm text-base-content/70">Database</span>
                            </div>
                            <span class="text-xs font-medium text-base-content/50">Online</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span
                                    class="w-1.5 h-1.5 rounded-full {{ $fonnteInfo ? 'bg-success' : 'bg-error' }}"></span>
                                <span class="text-sm text-base-content/70">Fonnte Service</span>
                            </div>
                            <span class="text-xs font-medium text-base-content/50">
                                {{ $fonnteInfo['status'] ?? 'Cek Token' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast toast-top toast-end z-50" id="toastContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('error'))
                showToast('error', "{{ session('error') }}", 'Error');
            @endif

            @if (session('success'))
                showToast('success', "{{ session('success') }}", 'Success');
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showToast('error', "{{ $error }}", 'Validation Error');
                @endforeach
            @endif

            function showToast(type, message, title = '') {
                const toastContainer = document.getElementById('toastContainer');
                if (!toastContainer) return;

                const alertClass = type === 'error' ? 'alert-error' :
                    type === 'success' ? 'alert-success' :
                    type === 'warning' ? 'alert-warning' : 'alert-info';

                const icon = type === 'error' ?
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
                    type === 'success' ?
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

                const toast = document.createElement('div');
                toast.className = `alert ${alertClass} shadow-lg mb-4`;
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        ${icon}
                        <div class="flex-1">
                            ${title ? `<div class="font-bold">${title}</div>` : ''}
                            <div class="text-sm">${message}</div>
                        </div>
                        <button class="btn btn-ghost btn-sm" onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;

                toastContainer.appendChild(toast);

                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 5000);
            }
        });
    </script>
@endsection