@extends('user.layout')

@section('title', 'Verify OTP')
@section('meta_description', 'Verifikasi kode OTP untuk melanjutkan proses pendaftaran akun SITAKU.')
@section('og_description', 'Masukkan kode verifikasi OTP yang telah dikirim ke email Anda.')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/5 via-base-100 to-secondary/5 p-4">
        <div class="w-full max-w-md">
            <!-- OTP Verification Card -->
            <div class="card bg-base-100 shadow-2xl border border-base-300">
                <div class="card-body p-8 overflow-hidden">
                    <!-- Header -->
                    <div class="text-center mb-6" data-aos="fade-up" data-aos-duration="700">
                        <div class="avatar mb-4">
                            <div class="w-20 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="{{ asset('image/logoLotus.png') }}" alt="Logo Lotus" class="object-cover" />
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-base-content mb-2">Verify Your Email</h1>
                        <p class="text-base-content/70 mb-2">We've sent a verification code to</p>
                        <p class="text-primary font-semibold">{{ $email }}</p>
                        <p class="text-base-content/60 text-sm mt-2">Please enter the 6-digit code below</p>
                    </div>

                    <!-- OTP Verification Form -->
                    <form method="POST" action="{{ route('signup.verify') }}" id="otpForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        <!-- OTP Input Field -->
                        <div class="form-control" data-aos="fade-up" data-aos-duration="800">
                            <label class="label" for="otp">
                                <span class="label-text font-medium">Verification Code</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="otp" name="otp" required
                                    placeholder="Enter 6-digit code" maxlength="6" pattern="[0-9]{6}"
                                    class="input input-bordered w-full pr-12 text-center text-2xl font-mono tracking-widest focus:input-primary @error('otp') input-error @enderror" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-base-content/40" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.74 5.74L9 18H6v-3l3.26-4.26A6 6 0 1119 9z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('otp')
                                <div class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Verify Button -->
                        <button type="submit" id="verifyButton"
                            class="btn btn-primary w-full h-12 text-base font-medium transition-all duration-200"
                            data-aos="fade-in" data-aos-duration="900">
                            <span id="verifyBtnText" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Verify Code
                            </span>
                            <span id="verifyBtnLoading" class="loading loading-spinner loading-md hidden"></span>
                        </button>
                    </form>

                    <!-- Resend OTP Section -->
                    <div class="divider text-base-content/50">or</div>

                    <div class="text-center">
                        <p class="text-base-content/70 text-sm mb-3">Didn't receive the code?</p>

                        <!-- Timer Display -->
                        <div id="timerDisplay" class="mb-4">
                            <div class="flex items-center justify-center gap-2 text-base-content/60">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm">Resend available in <span id="countdown"
                                        class="font-semibold text-primary">60</span> seconds</span>
                            </div>
                        </div>

                        <!-- Resend Form -->
                        <form method="GET" action="{{ route('signup.otp.resend') }}" id="resendForm">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <button type="submit" id="resendButton"
                                class="btn btn-outline btn-primary btn-sm transition-all duration-200 disabled:opacity-50"
                                disabled>
                                <span id="resendBtnText" class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Resend Code
                                </span>
                                <span id="resendBtnLoading" class="loading loading-spinner loading-sm color1 hidden"></span>
                            </button>
                        </form>
                    </div>

                    <!-- Back to Login Link -->
                    <div class="text-center mt-6" data-aos="fade-up" data-aos-duration="1200">
                        <a href="{{ route('login') }}" title="Sign In" class="link link-primary text-sm">
                            ← Back to Sign In
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast toast-top toast-end z-50" id="toastContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form elements
            const otpForm = document.getElementById('otpForm');
            const verifyBtn = document.getElementById('verifyButton');
            const verifyBtnText = document.getElementById('verifyBtnText');
            const verifyBtnLoading = document.getElementById('verifyBtnLoading');

            const resendForm = document.getElementById('resendForm');
            const resendBtn = document.getElementById('resendButton');
            const resendBtnText = document.getElementById('resendBtnText');
            const resendBtnLoading = document.getElementById('resendBtnLoading');

            const otpInput = document.getElementById('otp');
            const timerDisplay = document.getElementById('timerDisplay');
            const countdown = document.getElementById('countdown');

            // Timer variables
            let timeLeft = 60;
            let timerInterval;

            // Start countdown timer
            function startTimer() {
                resendBtn.disabled = true;
                timerDisplay.classList.remove('hidden');

                timerInterval = setInterval(() => {
                    timeLeft--;
                    countdown.textContent = timeLeft;

                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        resendBtn.disabled = false;
                        timerDisplay.classList.add('hidden');
                        timeLeft = 60; // Reset for next time
                    }
                }, 1000);
            }

            // Initialize timer on page load
            startTimer();

            // OTP input formatting
            if (otpInput) {
                otpInput.addEventListener('input', function(e) {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Auto-submit when 6 digits are entered
                    if (this.value.length === 6) {
                        otpForm.submit();
                    }
                });

                // Handle paste event
                otpInput.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const numbers = paste.replace(/[^0-9]/g, '').slice(0, 6);
                    this.value = numbers;

                    if (numbers.length === 6) {
                        setTimeout(() => otpForm.submit(), 100);
                    }
                });
            }

            // Verify form submission handling
            if (otpForm && verifyBtn) {
                otpForm.addEventListener('submit', function(e) {
                    if (otpInput.value.length !== 6) {
                        e.preventDefault();
                        showToast('error', 'Please enter a complete 6-digit code', 'Invalid Code');
                        return;
                    }

                    verifyBtn.disabled = true;
                    verifyBtn.classList.add('btn-disabled');
                    verifyBtnText.classList.add('hidden');
                    verifyBtnLoading.classList.remove('hidden');
                });
            }

            // Resend form submission handling
            if (resendForm && resendBtn) {
                resendForm.addEventListener('submit', function(e) {
                    resendBtn.disabled = true;
                    resendBtn.classList.add('btn-disabled');
                    resendBtnText.classList.add('hidden');
                    resendBtnLoading.classList.remove('hidden');

                    // Restart timer after form submission
                    setTimeout(() => {
                        resendBtnText.classList.remove('hidden');
                        resendBtnLoading.classList.add('hidden');
                        resendBtn.classList.remove('btn-disabled');
                        startTimer();
                    }, 1000);
                });
            }

            // Input focus animations
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-primary/20');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-primary/20');
                });
            });

            // Enhanced error handling with toast notifications
            @if (session('error'))
                showToast('error', "{{ session('error') }}", 'Error');
            @endif

            @if (session('success'))
                showToast('success', "{{ session('success') }}", 'Success');
                // Reset timer on success message (like when OTP is resent)
                clearInterval(timerInterval);
                startTimer();
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
                toast.className = `alert ${alertClass} shadow-lg mb-4 transition-all duration-300`;
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        ${icon}
                        <div class="flex-1">
                            ${title ? `<div class="font-bold">${title}</div>` : ''}
                            <div class="text-sm">${message}</div>
                        </div>
                        <button class="btn btn-ghost btn-sm hover:btn-outline" onclick="this.parentElement.parentElement.remove()">
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
                        toast.classList.add('opacity-0', 'transform', 'translate-x-full');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 5000);
            }

            // Clean up timer when page unloads
            window.addEventListener('beforeunload', function() {
                if (timerInterval) {
                    clearInterval(timerInterval);
                }
            });
        });
    </script>

@endsection
