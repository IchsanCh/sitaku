@extends('user.layout')

@section('title', 'Billing Payment')

@section('meta_description',
    'Aktifkan langganan SITAKU sesuai kebutuhan unit Anda. Tersedia pilihan paket Basic dan
    Premium dengan fitur lengkap untuk otomasi notifikasi dan pengelolaan data.')

@section('og_description',
    'Berlangganan SITAKU dengan mudah melalui pembayaran online menggunakan Midtrans. Dapatkan
    akses penuh ke fitur premium dan tingkatkan efisiensi layanan Anda.')

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-base-200 via-base-100 to-primary/10 flex items-center justify-center p-4">
        <div class="card w-full max-w-md bg-base-100 shadow-2xl border border-base-300">
            <!-- Header with animated gradient -->
            <div class="card-body relative overflow-hidden">
                <!-- Background decoration -->
                <div
                    class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-primary/20 to-secondary/20 rounded-full blur-3xl">
                </div>
                <div
                    class="absolute -bottom-20 -left-20 w-32 h-32 bg-gradient-to-tr from-accent/20 to-info/20 rounded-full blur-3xl">
                </div>

                <!-- Package info -->
                <div class="text-center mb-8 relative z-10">
                    <!-- Package icon -->
                    <div class="avatar mb-4">
                        <div
                            class="w-20 h-20 rounded-full bg-gradient-to-br from-primary to-secondary flex content-center justify-center">
                            <svg class="w-10 h-10 text-primary-content inline-block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>

                    <!-- Package name with badge -->
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <h1
                            class="text-2xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                            {{ $package->name }}
                        </h1>
                    </div>

                    <!-- Package description (if available) -->
                    @if (isset($package->description))
                        <p class="text-base-content/70 text-sm mb-4">{{ $package->description }}</p>
                    @endif
                </div>

                <!-- Price display -->
                <div class="text-center mb-8">
                    <div class="bg-gradient-to-r from-primary/10 to-secondary/10 rounded-2xl p-6 border border-primary/20">
                        <div class="text-sm text-base-content/60 mb-1">Total Pembayaran</div>
                        <div
                            class="text-4xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                            Rp{{ number_format($package->price, 0, ',', '.') }}
                        </div>
                        @if (isset($package->duration))
                            <div class="text-sm text-base-content/60 mt-2">
                                <div class="badge badge-outline badge-sm">{{ $package->duration }} hari</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Package features (if available) -->
                @if (isset($package->features))
                    <div class="mb-8">
                        <h3 class="font-semibold mb-3 text-center">Yang Kamu Dapatkan:</h3>
                        <div class="space-y-2">
                            @foreach (explode(',', $package->features) as $feature)
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-success/20 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-success" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-sm">{{ trim($feature) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Payment button -->
                <button id="pay-button" class="btn btn-primary btn-lg w-full group relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-primary-focus to-secondary opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <svg class="w-5 h-5 mr-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v2a2 2 0 002 2z" />
                    </svg>
                    <span class="relative z-10">Bayar Sekarang</span>
                    <div class="loading loading-spinner loading-sm ml-2 hidden" id="loading-spinner"></div>
                </button>

                <!-- Security badges -->
                <div class="flex items-center justify-center gap-4 mt-6 pt-4 border-t border-base-300">
                    <div class="flex items-center gap-1 text-xs text-base-content/60">
                        <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Keamanan SSL</span>
                    </div>
                    <div class="flex items-center gap-1 text-xs text-base-content/60">
                        <svg class="w-4 h-4 text-info" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Midtrans</span>
                    </div>
                </div>

                <!-- Back button -->
                <div class="text-center mt-4">
                    <a href="{{ route('user.billing') }}" class="btn btn-ghost btn-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Billing
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center hidden">
        <div class="bg-base-100 rounded-2xl p-8 text-center shadow-2xl max-w-sm mx-4">
            <div class="loading loading-spinner loading-lg text-primary mb-4"></div>
            <h3 class="font-bold text-lg mb-2">Memproses Pembayaran</h3>
            <p class="text-base-content/70 text-sm">Mohon tunggu, jangan tutup halaman ini...</p>
        </div>
    </div>

    <!-- Success modal -->
    <dialog id="success-modal" class="modal">
        <div class="modal-box text-center">
            <div class="w-20 h-20 bg-success/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="font-bold text-lg text-success mb-2">Pembayaran Berhasil!</h3>
            <p class="text-base-content/70 mb-4">Terima kasih, pembayaran Anda telah berhasil diproses.</p>
            <div class="modal-action justify-center">
                <button class="btn btn-success" onclick="window.location.href='/billing'">Lanjutkan</button>
            </div>
        </div>
    </dialog>

    <!-- Error modal -->
    <dialog id="error-modal" class="modal">
        <div class="modal-box text-center">
            <div class="w-20 h-20 bg-error/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h3 class="font-bold text-lg text-error mb-2">Pembayaran Gagal!</h3>
            <p class="text-base-content/70 mb-4">Maaf, terjadi kesalahan saat memproses pembayaran Anda.</p>
            <div class="modal-action justify-center">
                <button class="btn btn-error" onclick="window.location.href='/billing'">Coba Lagi</button>
            </div>
        </div>
    </dialog>

    <!-- Pending modal -->
    <dialog id="pending-modal" class="modal">
        <div class="modal-box text-center">
            <div class="w-20 h-20 bg-warning/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="font-bold text-lg text-warning mb-2">Pembayaran Sedang Diproses</h3>
            <p class="text-base-content/70 mb-4">Pembayaran Anda sedang dalam proses verifikasi.</p>
            <div class="modal-action justify-center">
                <button class="btn btn-warning" onclick="window.location.href='/billing'">Periksa Status</button>
            </div>
        </div>
    </dialog>

    <script
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        const loadingSpinner = document.getElementById('loading-spinner');
        const loadingOverlay = document.getElementById('loading-overlay');
        const successModal = document.getElementById('success-modal');
        const errorModal = document.getElementById('error-modal');
        const pendingModal = document.getElementById('pending-modal');

        // Add button animation
        payButton.addEventListener('mouseover', function() {
            this.classList.add('scale-105');
        });

        payButton.addEventListener('mouseout', function() {
            this.classList.remove('scale-105');
        });

        function showLoading() {
            payButton.disabled = true;
            loadingSpinner.classList.remove('hidden');
            loadingOverlay.classList.remove('hidden');
            loadingOverlay.classList.add('flex');
        }

        function hideLoading() {
            payButton.disabled = false;
            loadingSpinner.classList.add('hidden');
            loadingOverlay.classList.add('hidden');
            loadingOverlay.classList.remove('flex');
        }

        function showModal(modal) {
            hideLoading();
            modal.showModal();
        }

        payButton.onclick = function() {
            showLoading();

            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    showModal(successModal);
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    showModal(pendingModal);
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    showModal(errorModal);
                },
                onClose: function() {
                    hideLoading();
                    // Optional: show a toast notification
                    const toast = document.createElement('div');
                    toast.className = 'toast toast-top toast-center';
                    toast.innerHTML = `
                    <div class="alert alert-warning">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <span>Pembayaran dibatalkan</span>
                    </div>
                `;
                    document.body.appendChild(toast);

                    // Remove toast after 3 seconds
                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }
            });
        };

        // Add some CSS animations
        const style = document.createElement('style');
        style.textContent = `
        .btn:hover {
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-4px);
        }
        
        .toast {
            z-index: 9999;
        }
        
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .animate-pulse-slow {
            animation: pulse-slow 2s ease-in-out infinite;
        }
    `;
        document.head.appendChild(style);
    </script>
@endsection
