@extends('user.layout2')

@section('title', 'Pesan Pegawai')
@section('meta_description',
    'Lihat semua notifikasi yang telah dikirim ke pegawai berdasarkan tahapan proses
    permohonan. SITAKU bantu koordinasi tim lebih efektif.')
@section('og_description',
    'Kelola dan pantau log pesan WhatsApp yang dikirim ke pegawai sesuai tahapan kerja. Semua
    tercatat rapi dalam Dashboard SITAKU.')

@section('content')
    <div class="min-h-screen bg-base-200">
        <div class="bg-base-100 borderbc1">
            <div class="max-w-4xl mx-auto px-6 py-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-base-content">Pesan Pegawai</h1>
                        <p class="text-base-content/70">Kelola dan lihat pesan pegawai</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-4xl mx-auto px-6 py-8">
            <!-- Search and Filter Form -->
            <div class="card bg-base-100 shadow-lg hover:shadow-xl transition-shadow mb-6">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                        </svg>
                        Filter Pesan Pegawai
                    </h2>

                    <form method="GET" action="{{ route('pesan.pegawai') }}" class="space-y-4">
                        <!-- Search and Date Filters Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search Input -->
                            <div class="form-control">
                                <label class="text-black">
                                    <span class="label-text font-medium">Nama Pegawai</span>
                                </label>
                                <label class="input input-bordered input-primary flex items-center gap-2">
                                    <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Ex: Ic     hsan" class="grow" />
                                </label>
                            </div>

                            <!-- Start Date -->
                            <div class="form-control">
                                <label class="text-black">
                                    <span class="label-text font-medium">Dari Tanggal</span>
                                </label>
                                <label class="input input-bordered input-primary flex items-center gap-2">
                                    <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <input type="date" name="start_date"
                                        value="{{ request('start_date', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}"
                                        class="grow" />
                                </label>
                            </div>

                            <!-- End Date -->
                            <div class="form-control">
                                <label class="text-black">
                                    <span class="label-text font-medium">Sampai Tanggal</span>
                                </label>
                                <label class="input input-bordered input-primary flex items-center gap-2">
                                    <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <input type="date" name="end_date"
                                        value="{{ request('end_date', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}"
                                        class="grow" />
                                </label>
                            </div>

                            <!-- Action Buttons -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium opacity-0">Actions</span>
                                </label>
                                <div class="join w-full flex flex-row gap-1">
                                    <button type="submit" class="btn btn-primary join-item flex-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Cari
                                    </button>
                                    @if (request()->hasAny(['search', 'start_date', 'end_date']))
                                        <a href="{{ route('pesan.pegawai') }}"
                                            class="btn btn-outline btn-secondary join-item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Quick Filter Badges (Optional Enhancement) -->
                        @if (request()->hasAny(['search', 'start_date', 'end_date']))
                            <div class="divider">Filter Aktif</div>
                            <div class="flex flex-wrap gap-2">
                                @if (request('search'))
                                    <div class="badge badge-primary badge-lg gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Nama: {{ request('search') }}
                                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                            class="btn btn-ghost btn-xs btn-circle">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif

                                @if (request('start_date'))
                                    <div class="badge badge-secondary badge-lg gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Dari: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
                                        <a href="{{ request()->fullUrlWithQuery(['start_date' => null]) }}"
                                            class="btn btn-ghost btn-xs btn-circle">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif

                                @if (request('end_date'))
                                    <div class="badge badge-accent badge-lg gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Sampai: {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                                        <a href="{{ request()->fullUrlWithQuery(['end_date' => null]) }}"
                                            class="btn btn-ghost btn-xs btn-circle">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-base-100 rounded-lg shadow">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-base-200">
                            <th class="text-left font-semibold text-xs sm:text-sm">Nama</th>
                            <th class="text-left font-semibold text-xs sm:text-sm">Contact</th>
                            <th class="text-left font-semibold text-xs sm:text-sm">Pesan</th>
                            <th class="text-left font-semibold text-xs sm:text-sm">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesan as $p)
                            <tr class="hover:bg-base-200/50 transition-colors duration-200">
                                <td class="py-2 sm:py-4">
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <div class="min-w-0 flex-1">
                                            <div class="font-bold text-base-content text-xs sm:text-base truncate">
                                                @if (request('search'))
                                                    {!! highlightSearchTerm($p->nama, request('search')) !!}
                                                @else
                                                    {{ $p->nama }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 sm:py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1 sm:gap-2">
                                            <span class="text-xs sm:text-sm truncate">{{ $p->nomor_hp }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 sm:py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1 sm:gap-2">
                                            <span class="text-xs sm:text-sm">{{ $p->pesan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 sm:py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1 sm:gap-2">
                                            <span class="text-xs sm:text-sm">
                                                {{ $p->created_at->format('d M Y H:i') }}</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-3 text-base-content">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <div class="text-center">
                                            <p class="font-medium">
                                                @if (request('search'))
                                                    Tidak ada pesan yang ditemukan
                                                @else
                                                    Belum ada pesan
                                                @endif
                                            </p>
                                            <p class="text-sm">
                                                @if (request('search'))
                                                    Coba ubah kata kunci pencarian atau filter status Anda
                                                @else
                                                    Pesan akan muncul di sini setelah dikirim
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($pesan->hasPages())
                <div class="mt-6 flex justify-center">
                    <div class="join">
                        {{-- Previous Page Link --}}
                        @if ($pesan->onFirstPage())
                            <button class="join-item btn btn-disabled">«</button>
                        @else
                            <a href="{{ $pesan->appends(request()->query())->previousPageUrl() }}"
                                class="join-item btn">«</a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($pesan->appends(request()->query())->getUrlRange(1, $pesan->lastPage()) as $page => $url)
                            @if ($page == $pesan->currentPage())
                                <button class="join-item btn btn-active">{{ $page }}</button>
                            @else
                                <a href="{{ $url }}" class="join-item btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($pesan->hasMorePages())
                            <a href="{{ $pesan->appends(request()->query())->nextPageUrl() }}"
                                class="join-item btn">»</a>
                        @else
                            <button class="join-item btn btn-disabled">»</button>
                        @endif
                    </div>
                </div>

                <!-- Pagination Info -->
                <div class="mt-4 text-center text-sm text-base-content/70">
                    Menampilkan {{ $pesan->firstItem() }} - {{ $pesan->lastItem() }} dari {{ $pesan->total() }} hasil
                </div>
            @endif
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast toast-top toast-end z-50" id="toastContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('error'))
                showToast('error', "{{ session('error') }}");
            @endif

            @if (session('success'))
                showToast('success', "{{ session('success') }}");
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showToast('error', "{{ $error }}");
                @endforeach
            @endif
        });

        function showToast(type, message) {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) return;

            const alertClass = type === 'error' ? 'alert-error' : 'alert-success';
            const icon = type === 'error' ?
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

            const toast = document.createElement('div');
            toast.className = `alert ${alertClass} shadow-lg mb-4`;
            toast.innerHTML = `
                <div class="flex items-center gap-3">
                    ${icon}
                    <span>${message}</span>
                    <button class="btn btn-ghost btn-xs" onclick="this.parentElement.parentElement.remove()">✕</button>
                </div>
            `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 4000);
        }
    </script>

@endsection
