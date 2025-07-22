@extends('user.layout2')
@section('title', 'Status Pembayaran')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 p-8">
        <!-- Status Card -->
        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body">
                <!-- Status Header with Alert -->
                <div class="mb-6">
                    @if ($subscription->status === 'success')
                        <div class="alert alert-success shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h1 class="text-xl font-bold">Pembayaran Berhasil</h1>
                                <div class="text-sm opacity-90">Terima kasih telah melakukan pembayaran. Detail transaksi
                                    kamu ada di bawah ini.</div>
                            </div>
                        </div>
                    @elseif ($subscription->status === 'failed')
                        <div class="alert alert-error shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h1 class="text-xl font-bold">Pembayaran Gagal</h1>
                                <div class="text-sm opacity-90">Maaf, pembayaran kamu gagal. Coba refresh halaman atau
                                    hubungi admin jika perlu bantuan.</div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <div>
                                <h1 class="text-xl font-bold">Status Transaksi</h1>
                                <div class="text-sm opacity-90">Status transaksi saat ini: <span
                                        class="font-semibold">{{ ucfirst($subscription->status) }}</span></div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Transaction Details -->
                <div class="bg-base-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Detail Transaksi
                    </h2>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex justify-between items-center py-2 border-b border-base-300">
                            <span class="text-sm font-medium opacity-70">Invoice</span>
                            <span class="text-sm font-mono">{{ $subscription->payment_token ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-base-300">
                            <span class="text-sm font-medium opacity-70">Paket</span>
                            <span class="text-sm font-semibold">{{ $subscription->package->name ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-base-300">
                            <span class="text-sm font-medium opacity-70">Durasi Paket</span>
                            <span class="text-sm">{{ $subscription->package->duration_days ?? '-' }} Hari</span>
                        </div>

                        <div class="flex justify-between items-start py-2 border-b border-base-300">
                            <span class="text-sm font-medium opacity-70">Deskripsi Paket</span>
                            <span
                                class="text-sm text-right max-w-xs">{{ $subscription->package->description ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-base-300">
                            <span class="text-sm font-medium opacity-70">Total</span>
                            <span
                                class="text-sm font-bold text-primary">Rp{{ number_format($subscription->total ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-base-300">
                            <span class="text-sm font-medium opacity-70">Waktu Pembayaran</span>
                            <span
                                class="text-sm">{{ $subscription->created_at ? $subscription->created_at->format('d M Y, H:i') : '-' }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm font-medium opacity-70">Status</span>
                            <div
                                class="badge {{ $subscription->status === 'success' ? 'badge-success' : ($subscription->status === 'pending' ? 'badge-warning' : 'badge-error') }} badge-lg font-semibold">
                                {{ strtoupper($subscription->status) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="card-actions justify-center mt-8">
                    <a href="{{ route('user.billing') }}" class="btn btn-primary btn-wide">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Billing Menu
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
