@extends('user.layout2')

@section('title', 'Settings')
@section('meta_description',
    'Atur preferensi sistem seperti URL API, token WhatsApp, unit layanan, dan jadwal
    pengiriman pesan otomatis.')

@section('og_description',
    'Halaman pengaturan SITAKU. Kelola konfigurasi sistem untuk memastikan pengiriman notifikasi
    WhatsApp berjalan sesuai kebutuhan.')
@section('content')
    <div class="min-h-screen bg-base-200">
        <!-- Simple Header -->
        <div class="bg-base-100 borderbc1">
            <div class="max-w-4xl mx-auto px-6 py-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-base-content">Settings</h1>
                        <p class="text-base-content/70">Configure your SITAKU notification preferences</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-6 py-8">
            <!-- API Configuration Card -->
            <div class="card bg-base-100 shadow-sm borderc1">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                            </path>
                        </svg>
                        <div>
                            <h2 class="text-xl font-semibold text-black">API Configuration</h2>
                            <p class="text-sm text-black">Configure your API endpoints and authentication</p>
                        </div>
                    </div>
                    <form action="{{ route('setting.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="form-control mb-4">
                            <label class="cursor-pointer label">
                                <span class="label-text font-medium text-black">Service Status</span>
                                <input type="checkbox" name="active" class="toggle toggle-primary"
                                    {{ $user->status === 'active' ? 'checked' : '' }}>
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="label mb-1" for="apirul">
                                <span class="label-text font-medium text-black">API URL (Pemohon)</span>
                                <span class="badge badge-primary badge-sm">Required</span>
                            </label>
                            <input type="url" id="apirul" name="apirul"
                                class="input input-bordered border-primary focus:input-primary w-full"
                                placeholder="Ex: https://lotusaja.com/api/pemohon" value="{{ $user->api_url }}" required>
                            <div class="">
                                <span class="text-black">Enter the complete API endpoint URL</span>
                            </div>
                        </div>
                        <div class="form-control">
                            <label class="label mb-1" for="fonnte">
                                <span class="label-text font-medium text-black">Token Fonnte</span>
                                <span class="badge badge-primary badge-sm">Required</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="fonnte" name="fonnte"
                                    class="input input-bordered border-primary focus:input-primary w-full pr-10"
                                    placeholder="Enter your Fonnte token" value="{{ $user->fonnte }}" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword('fonnte')">
                                    <svg id="fonnte-eye" class="w-4 h-4 text-black" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="">
                                <span class="text-black">Status:
                                    {{ $fonnteInfo['status'] ?? 'Connect The Fonnte Device or Check The Token!' }}</span>
                            </div>
                        </div>
                        <div class="form-control">
                            <label class="label mb-1" for="unit">
                                <span class="label-text font-medium text-black">Unit ID</span>
                                <span class="badge badge-primary badge-sm">Required</span>
                            </label>
                            <input type="text" id="unit" name="unit"
                                class="input border-primary focus:input-primary input-bordered w-full"
                                placeholder="Ex: 1133" value="{{ $user->unit_id }}" pattern="[0-9]+" required>
                            <label class="label">
                                <span class="label-text-alt text-black">Unique identifier for your unit</span>
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="label mb-1" for="sitoken">
                                <span class="label-text font-medium text-black">SITAKU Token</span>
                                <span class="badge badge-primary badge-sm">Required</span>
                            </label>
                            @php
                                use Carbon\Carbon;
                                $expired = Carbon::now()->gt($user->subscription_expires_at);
                                $message = urlencode(
                                    "Halo, saya {$user->name}. Saya ingin memperbarui langganan dengan token berikut: {$user->subscription_token}. Mohon bantuannya. Terima kasih.",
                                );
                            @endphp
                            <div class="relative">
                                <input type="password" id="sitoken" name="sitoken" disabled
                                    class="input input-bordered border-primary focus:input-primary w-full pr-10"
                                    placeholder="Enter your SITAKU Token" value="{{ $user->subscription_token }}"
                                    required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword('sitoken')">
                                    <svg id="sitoken-eye" class="w-4 h-4 text-black" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <label class="label">
                                <span class="label-text-alt text-black">
                                    Valid Until {{ $user->subscription_expires_at->format('d M Y') }}
                                </span>
                            </label>

                            @if ($expired)
                                <a href="/billing">
                                    <div class="perbarui mt-2">
                                        <div role="alert" class="alert alert-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6 shrink-0 stroke-current" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <span>Expired SITAKU Token! Click here to renew your subscription</span>
                                        </div>
                                    </div>
                                </a>
                            @endif
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary w-full sm:w-auto">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save Configuration
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast toast-top toast-end z-50" id="toastContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Laravel flash messages
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

        // Simple toast function
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

            // Auto remove after 4 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 4000);
        }

        // Simple password toggle
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye');

            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                field.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>

@endsection
