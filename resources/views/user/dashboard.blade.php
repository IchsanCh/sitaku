@extends('user.layout2')

@section('title', 'Dashboard')
@section('meta_description', 'Selamat datang di Dashboard SITAKU! Atur notifikasi otomatis dan cek log pesan di sini.')
@section('og_description', 'Gunakan Dashboard SITAKU untuk mengelola semua notifikasi WhatsApp secara otomatis.')

@section('content')
    <div class="min-h-screen bg-base-100 p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-base-content flex items-center gap-3">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                            </path>
                        </svg>
                        Hallo, {{ $user->name }}!
                    </h1>
                    <p class="text-base-content mt-2">Selamat datang kembali di Dashboard SITAKU</p>
                </div>
                <div class="flex items-center gap-2">
                    <div
                        class="badge px-3 py-2 text-white font-semibold transition-all duration-300 
        {{ $user->status === 'active' ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-400 hover:bg-gray-500' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            @if ($user->status === 'active')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            @endif
                        </svg>
                        {{ $user->status === 'active' ? 'Online' : 'Offline' }}
                    </div>
                </div>

            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Messages Sent This Year -->
            <div
                class="card bg-gradient-to-br hover:scale-105 transition-transform duration-200 from-primary/90 to-primary text-primary-content shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="card-title text-lg font-semibold text-white">Pesan Terkirim</h3>
                            <p class="text-3xl font-bold mt-2 text-white" id="totalMessages">
                                {{ $totalPesanTerkirim ?? '0' }}
                            </p>
                            <p class="text-white text-sm">Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Employees -->
            <div
                class="card bg-gradient-to-br hover:scale-105 transition-transform duration-200 from-secondary/90 to-secondary text-secondary-content shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="card-title text-lg font-semibold text-white">Total Pegawai</h3>
                            <p class="text-3xl font-bold mt-2 text-white">{{ $pegawai->count() ?? '0' }}</p>
                            <p class="text-sm text-white">Terdaftar</p>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Remaining Messages -->
            <div
                class="card bg-gradient-to-br hover:scale-105 transition-transform duration-200 from-green-800 to-green-900 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="card-title text-lg font-semibold">Sisa Pesan</h3>
                            <p class="text-3xl font-bold mt-2" id="remainingMessages">
                                {{ $fonnteInfo['quota'] ?? 'Token Tidak Valid' }}
                            </p>
                            <p class="text-sm">Fonnte: {{ $fonnteInfo['package'] ?? 'Token Tidak Valid' }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="card bg-white border border-base-300 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="card-body space-y-4">
                    <!-- Header -->
                    <div class="flex items-center gap-2 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h2 class="card-title text-xl font-semibold">Pengumuman Terakhir</h2>
                    </div>

                    <!-- Content -->
                    @forelse ($announcement as $a)
                        <div
                            class="rounded-xl p-4 bg-base-100 border hover:scale-105 border-base-300 shadow-lg hover:shadow-xl transition-shadow transition-transform duration-300">
                            <h3 class="text-lg font-semibold text-black mb-2">{{ $a->name }}</h3>
                            <div class="prose text-sm text-black leading-relaxed">
                                {!! $a->description !!}
                            </div>
                            <p class="mt-2 text-sm text-black">
                                Diumumkan pada: {{ $a->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    @empty
                        <p>Tidak ada pengumuman</p>
                    @endforelse

                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card bg-base-100 shadow-lg border border-base-200 hover:shadow-xl transition-shadow duration-300">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Aksi Cepat
                    </h2>
                    <div class="space-y-3">
                        <a class="btn btn-secondary btn-block gap-3 hover:scale-105 transition-transform duration-200 font-bold"
                            href="{{ route('user.pegawai') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Kelola Pegawai
                        </a>

                        <button
                            class="btn btn-accent btn-block gap-3 hover:scale-105 transition-transform duration-200 font-bold">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                <path d="M8,12H16V14H8V12M8,16H13V18H8V16Z" />
                            </svg>
                            Lihat Log Pesan
                        </button>

                        <a href="{{ route('setting.user') }}"
                            class="btn btn-info btn-block gap-3 hover:scale-105 transition-transform duration-200 font-bold">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.22,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.22,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.68 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z" />
                            </svg>
                            Pengaturan
                        </a>
                    </div>

                    <!-- System Status -->
                    <div class="divider divider-neutral">Status Sistem</div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-2 bg-base-300 rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">Service</span>
                            </div>
                            <div class="badge badge-success badge-sm font-bold">
                                {{ $user->status === 'active' ? 'Online' : 'Offline' }}</div>
                        </div>

                        <div class="flex justify-between items-center p-2 bg-base-300 rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">Database</span>
                            </div>
                            <div class="badge badge-success badge-sm font-bold">Online</div>
                        </div>

                        <div class="flex justify-between items-center p-2 bg-base-300 rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">Fonnte Service</span>
                            </div>
                            <div class="badge badge-success badge-sm font-bold">
                                {{ $fonnteInfo['status'] ?? 'Cek Token Fonnte' }}</div>
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
            // Toast functionality
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

            // Toast notification function
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
                toast.className = `alert ${alertClass} shadow-lg mb-4 animate-in slide-in-from-right duration-300`;
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        ${icon}
                        <div class="flex-1">
                            ${title ? `<div class="font-bold">${title}</div>` : ''}
                            <div class="text-sm">${message}</div>
                        </div>
                        <button class="btn btn-ghost btn-sm hover:bg-base-200" onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;

                toastContainer.appendChild(toast);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.classList.add('animate-out', 'slide-out-to-right');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 5000);
            }

            // Chart.js initialization with improved styling
            const ctx1 = document.getElementById('messagesChart').getContext('2d');
            const messagesChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov',
                        'Des'
                    ],
                    datasets: [{
                        label: 'Pesan Terkirim',
                        data: [120, 190, 300, 500, 200, 300, 450, 300, 250, 400, 350, 200],
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 2,
                        borderRadius: 5,
                        borderSkipped: false,

                        // Hover effects
                        hoverBackgroundColor: 'rgba(37, 99, 235, 0.9)',
                        hoverBorderColor: 'rgba(29, 78, 216, 1)',
                        hoverBorderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)', // Dark background
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: 'rgba(59, 130, 246, 0.5)',
                            borderWidth: 1,
                            cornerRadius: 12,
                            displayColors: false,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            padding: 12,
                            // Custom tooltip format
                            callbacks: {
                                label: function(context) {
                                    return `Pesan: ${context.parsed.y.toLocaleString('id-ID')}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(148, 163, 184, 0.3)', // Light gray grid
                                drawBorder: false
                            },
                            ticks: {
                                color: 'rgba(71, 85, 105, 0.8)', // Slate color
                                font: {
                                    size: 12
                                },
                                // Format numbers with Indonesian locale
                                callback: function(value) {
                                    return value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: 'rgba(71, 85, 105, 0.8)', // Slate color
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    // Add smooth animations
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });

            // Auto-refresh data every 30 seconds (optional)
            setInterval(() => {
                console.log('Auto-refreshing dashboard data...');
            }, 30000);
        });
    </script>
@endsection
