@extends('user.layout2')

@section('title', 'Pesan Pemohon')
@section('meta_description',
    'Pantau semua pesan otomatis yang dikirim ke pemohon. Dashboard SITAKU memudahkan Anda
    melihat riwayat notifikasi dengan jelas.')
@section('og_description',
    'Cek log pesan pemohon yang dikirim otomatis melalui WhatsApp. Kelola informasi tahapan
    permohonan dengan mudah lewat Dashboard SITAKU.')

@section('content')
    <div class="min-h-screen bg-base-200">
        <div class="bg-base-100 borderbc1">
            <div class="max-w-4xl mx-auto px-6 py-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                        <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-base-content">Pesan Pemohon</h1>
                        <p class="text-base-content/70">Kelola dan lihat pesan pemohon</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-4xl mx-auto px-6 py-8">
            <!-- Search and Filter Form -->
            <form method="GET" action="{{ route('pesan.user') }}" class="mb-6">
                <div class="flex flex-col gap-4">
                    <!-- Search Input -->
                    <div class="flex flex-row sm:flex-row gap-4 items-start sm:items-center justify-between">
                        <div class="flex-1 max-w-md">
                            <div class="form-control">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari No Permohonan..."
                                        class="input input-bordered input-primary flex-1" />
                                    <button type="submit" class="btn btn-primary">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                    @if (request('search') || request('status'))
                                        <a href="{{ route('pesan.user') }}" class="btn btn-outline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm font-medium text-base-content/70">Filter Status:</span>
                        <div class="flex flex-wrap gap-2">
                            <!-- All Status -->
                            <button type="submit" name="status" value=""
                                class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline' }}">
                                Semua
                            </button>
                            <!-- Terkirim -->
                            <button type="submit" name="status" value="terkirim"
                                class="btn btn-sm {{ request('status') == 'terkirim' ? 'btn-success' : 'btn-outline' }}">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Terkirim
                            </button>
                            <!-- Gagal -->
                            <button type="submit" name="status" value="gagal"
                                class="btn btn-sm {{ request('status') == 'gagal' ? 'btn-error' : 'btn-outline' }}">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Gagal
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Search/Filter Results Info -->
            @if (request('search') || request('status'))
                <div class="mb-4 p-3 bg-info/20 rounded-lg border border-info/50">
                    <div class="flex items-center gap-2 text-black">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">
                            @if ($pesan->count() > 0)
                                Ditemukan {{ $pesan->total() }} hasil
                                @if (request('search'))
                                    untuk "<strong>{{ request('search') }}</strong>"
                                @endif
                                @if (request('status'))
                                    dengan status
                                    "<strong>{{ ucfirst(request('status') == 'sent' ? 'Terkirim' : (request('status') == 'failed' ? 'Gagal' : request('status'))) }}</strong>"
                                @endif
                            @else
                                Tidak ada hasil ditemukan
                                @if (request('search'))
                                    untuk "<strong>{{ request('search') }}</strong>"
                                @endif
                                @if (request('status'))
                                    dengan status
                                    "<strong>{{ ucfirst(request('status') == 'sent' ? 'Terkirim' : (request('status') == 'failed' ? 'Gagal' : request('status'))) }}</strong>"
                                @endif
                            @endif
                        </span>
                    </div>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto bg-base-100 rounded-lg shadow">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-base-200">
                            <th class="text-left font-semibold text-xs sm:text-sm">No Permohonan</th>
                            <th class="text-left font-semibold text-xs sm:text-sm hidden sm:table-cell">Contact</th>
                            <th class="text-left font-semibold text-xs sm:text-sm">Pesan</th>
                            <th class="text-center font-semibold text-xs sm:text-sm">Status</th>
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
                                                    {!! highlightSearchTerm($p->pemohon->no_permohonan, request('search')) !!}
                                                @else
                                                    {{ $p->pemohon->no_permohonan }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 sm:py-4 hidden sm:table-cell">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1 sm:gap-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-success flex-shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-xs sm:text-sm truncate">{{ $p->pemohon->nomor_hp }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 sm:py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1 sm:gap-2">
                                            <span class="text-xs sm:text-sm line-clamp-2">{{ $p->pesan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 sm:py-4 text-center">
                                    <div class="flex justify-center">
                                        @php
                                            $statusClass = match ($p->status) {
                                                'sent' => 'badge-success',
                                                'pending' => 'badge-warning',
                                                'failed' => 'badge-error',
                                                default => 'badge-neutral',
                                            };
                                            $statusText = match ($p->status) {
                                                'sent' => 'Terkirim',
                                                'pending' => 'Pending',
                                                'failed' => 'Gagal',
                                                default => ucfirst($p->status),
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }} text-xs">
                                            {{ $statusText }}
                                        </span>
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
                                                @if (request('search') || request('status'))
                                                    Tidak ada pesan yang ditemukan
                                                @else
                                                    Belum ada pesan
                                                @endif
                                            </p>
                                            <p class="text-sm">
                                                @if (request('search') || request('status'))
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
