@extends('user.layout')

@section('title', 'Reset Password')
@section('meta_description', 'Reset password akun SITAKU Anda dengan mudah dan aman.')
@section('og_description', 'Masukkan email Anda untuk menerima link reset password.')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/5 via-base-100 to-secondary/5 p-4">
        <div class="w-full max-w-md">
            <!-- Password Reset Card -->
            <div class="card bg-base-100 shadow-2xl border border-base-300">
                <div class="card-body p-8 overflow-hidden">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <div class="avatar mb-4">
                            <div class="w-20 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="{{ asset('image/logoLotus.png') }}" alt="Logo Lotus" class="object-cover" />
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-base-content mb-2">Reset Password</h1>
                        <p class="text-base-content/70 mb-2">Forgot your password? No worries!</p>
                        <p class="text-base-content/60 text-sm mt-2">Enter your email address and we'll send you a reset
                            link</p>
                    </div>

                    <!-- Password Reset Form -->
                    <form method="POST" action="{{ route('password.email') }}" id="resetForm" class="space-y-6">
                        @csrf

                        <!-- Email Input Field -->
                        <div class="form-control">
                            <label class="label" for="email">
                                <span class="label-text font-medium">Email Address</span>
                            </label>
                            <div class="relative">
                                <input type="email" id="email" name="email" required
                                    placeholder="Enter your email address" value="{{ old('email') }}"
                                    class="input input-bordered w-full pr-12 focus:input-primary @error('email') input-error @enderror" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-base-content/40" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                                <div class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Send Reset Link Button -->
                        <button type="submit" id="resetButton"
                            class="btn btn-primary w-full h-12 text-base font-medium transition-all duration-200">
                            <span id="resetBtnText" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Send Reset Link
                            </span>
                            <span id="resetBtnLoading" class="loading loading-spinner loading-md hidden"></span>
                        </button>
                    </form>
                    <!-- Divider -->
                    <div class="divider text-base-content/50">or</div>

                    <!-- Alternative Actions -->
                    <div class="text-center space-y-3">
                        <div class="text-base-content/70 text-sm mb-3">Remember your password?</div>

                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('login') }}" class="btn btn-outline btn-primary btn-sm flex-1 sm:flex-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Back to Login
                            </a>

                            <a href="{{ route('signup') }}" class="btn btn-ghost btn-sm flex-1 sm:flex-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                                Sign Up
                            </a>
                        </div>
                    </div>

                    <!-- Help Text -->
                    <div class="mt-6 p-4 bg-base-200 rounded-lg">
                        <div class="text-sm text-base-content font-semibold">
                            <div class="font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                What happens next?
                            </div>
                            <ul class="text-xs space-y-1 ml-6">
                                <li>• We'll send a secure reset link to your email</li>
                                <li>• The link will expire in 60 minutes</li>
                                <li>• Click the link to create a new password</li>
                                <li>• Your account will be secured immediately</li>
                            </ul>
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
            // Form elements
            const resetForm = document.getElementById('resetForm');
            const resetBtn = document.getElementById('resetButton');
            const resetBtnText = document.getElementById('resetBtnText');
            const resetBtnLoading = document.getElementById('resetBtnLoading');
            const emailInput = document.getElementById('email');

            // Email validation regex
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Real-time email validation
            if (emailInput) {
                emailInput.addEventListener('input', function(e) {
                    const email = this.value.trim();
                    const isValid = emailRegex.test(email);

                    // Visual feedback
                    if (email && !isValid) {
                        this.classList.add('input-error');
                        this.classList.remove('input-success');
                    } else if (email && isValid) {
                        this.classList.remove('input-error');
                        this.classList.add('input-success');
                    } else {
                        this.classList.remove('input-error', 'input-success');
                    }
                });

                // Handle paste event for email
                emailInput.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        const email = this.value.trim();
                        if (emailRegex.test(email)) {
                            this.classList.remove('input-error');
                            this.classList.add('input-success');
                        }
                    }, 100);
                });
            }

            // Form submission handling
            if (resetForm && resetBtn) {
                resetForm.addEventListener('submit', function(e) {
                    const email = emailInput.value.trim();

                    if (!email) {
                        e.preventDefault();
                        showToast('error', 'Please enter your email address', 'Email Required');
                        emailInput.focus();
                        return;
                    }

                    if (!emailRegex.test(email)) {
                        e.preventDefault();
                        showToast('error', 'Please enter a valid email address', 'Invalid Email');
                        emailInput.focus();
                        return;
                    }

                    // Show loading state
                    resetBtn.disabled = true;
                    resetBtn.classList.add('btn-disabled');
                    resetBtnText.classList.add('hidden');
                    resetBtnLoading.classList.remove('hidden');

                    // Show immediate feedback
                    showToast('info', 'Processing your request...', 'Please Wait');
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

            // Handle Laravel session messages
            @if (session('status'))
                showToast('success', "{{ session('status') }}", 'Reset Link Sent');

                // Show additional info
                setTimeout(() => {
                    showToast('info', 'Please check your email inbox and spam folder', 'Check Your Email');
                }, 2000);
            @endif

            @if (session('error'))
                showToast('error', "{{ session('error') }}", 'Error');

                // Re-enable form on error
                if (resetBtn) {
                    resetBtn.disabled = false;
                    resetBtn.classList.remove('btn-disabled');
                    resetBtnText.classList.remove('hidden');
                    resetBtnLoading.classList.add('hidden');
                }
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showToast('error', "{{ $error }}", 'Validation Error');
                @endforeach

                // Re-enable form on validation errors
                if (resetBtn) {
                    resetBtn.disabled = false;
                    resetBtn.classList.remove('btn-disabled');
                    resetBtnText.classList.remove('hidden');
                    resetBtnLoading.classList.add('hidden');
                }
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
                    type === 'warning' ?
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>' :
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

                // Auto remove after 6 seconds (longer for info messages)
                const timeout = type === 'info' ? 8000 : 6000;
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.classList.add('opacity-0', 'transform', 'translate-x-full');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, timeout);
            }

            // Auto-focus email input
            if (emailInput && !emailInput.value) {
                setTimeout(() => emailInput.focus(), 500);
            }
        });
    </script>

@endsection
