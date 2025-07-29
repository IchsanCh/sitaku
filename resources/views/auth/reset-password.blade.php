@extends('user.layout')

@section('title', 'Set New Password')
@section('meta_description', 'Buat password baru untuk akun SITAKU Anda dengan aman.')
@section('og_description', 'Masukkan password baru yang kuat untuk mengamankan akun Anda.')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/5 via-base-100 to-secondary/5 p-4">
        <div class="w-full max-w-md">
            <!-- Password Reset Update Card -->
            <div class="card bg-base-100 shadow-2xl border border-base-300">
                <div class="card-body p-8 overflow-hidden">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <div class="avatar mb-4">
                            <div class="w-20 rounded-full ring ring-success ring-offset-base-100 ring-offset-2">
                                <img src="{{ asset('image/logoLotus.png') }}" alt="Logo Lotus" class="object-cover" />
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-base-content mb-2">Set New Password</h1>
                        <p class="text-base-content/70 mb-2">Almost done! Create your new secure password</p>
                        <div class="flex items-center justify-center gap-2 text-sm text-success">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.95-3.95A10.97 10.97 0 0121 12c0 6.075-4.925 11-11 11S-1 18.075-1 12 3.925 1 10 1c2.3 0 4.44.708 6.21 1.917">
                                </path>
                            </svg>
                            <span class="font-medium">Reset link verified for {{ $email }}</span>
                        </div>
                    </div>

                    <!-- Success/Error Messages -->
                    @if (session('status'))
                        <div class="alert alert-success mb-6" data-aos="fade-in">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <div class="font-bold">Success!</div>
                                <div class="text-sm">{{ session('status') }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-error mb-6" data-aos="fade-in">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <div class="font-bold">Please fix the following errors:</div>
                                <ul class="text-sm mt-2 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Password Reset Form -->
                    <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ old('email', $email) }}">

                        <!-- New Password Input -->
                        <div class="form-control">
                            <label class="label" for="password">
                                <span class="label-text font-medium">New Password</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    placeholder="Enter your new password"
                                    class="input input-bordered w-full pr-12 focus:input-primary @error('password') input-error @enderror" />
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/40 hover:text-base-content/60">
                                    <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            @enderror

                            <!-- Password Strength Indicator -->
                            <div class="mt-2">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs text-base-content/60">Password Strength</span>
                                    <span id="strengthText" class="text-xs font-medium">Weak</span>
                                </div>
                                <div class="w-full bg-base-300 rounded-full h-2">
                                    <div id="strengthBar" class="bg-error h-2 rounded-full transition-all duration-300"
                                        style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="form-control">
                            <label class="label" for="password_confirmation">
                                <span class="label-text font-medium">Confirm New Password</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    placeholder="Confirm your new password"
                                    class="input input-bordered w-full pr-12 focus:input-primary @error('password_confirmation') input-error @enderror" />
                                <button type="button" id="togglePasswordConfirm"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/40 hover:text-base-content/60">
                                    <svg id="eyeOpenConfirm" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg id="eyeClosedConfirm" class="w-5 h-5 hidden" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            @enderror

                            <!-- Password Match Indicator -->
                            <div id="matchIndicator" class="mt-2 hidden">
                                <div class="flex items-center gap-2">
                                    <svg id="matchIcon" class="w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span id="matchText" class="text-xs font-medium">Passwords match</span>
                                </div>
                            </div>
                        </div>

                        <!-- Password Requirements -->
                        <div class="alert alert-info">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <div class="font-semibold text-sm mb-2">Password Requirements:</div>
                                <ul class="text-xs space-y-1">
                                    <li id="req-length" class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-base-300"></span>
                                        At least 8 characters long
                                    </li>
                                    <li id="req-upper" class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-base-300"></span>
                                        Contains uppercase letter
                                    </li>
                                    <li id="req-lower" class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-base-300"></span>
                                        Contains lowercase letter
                                    </li>
                                    <li id="req-number" class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-base-300"></span>
                                        Contains a number
                                    </li>
                                    <li id="req-special" class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-base-300"></span>
                                        Contains special character
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Update Password Button -->
                        <button type="submit" id="updateButton"
                            class="btn btn-primary w-full h-12 text-base font-medium transition-all duration-200">
                            <span id="updateBtnText" class="flex items-center gap-2" title="Update Password">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.95-3.95A10.97 10.97 0 0121 12c0 6.075-4.925 11-11 11S-1 18.075-1 12 3.925 1 10 1c2.3 0 4.44.708 6.21 1.917">
                                    </path>
                                </svg>
                                Update Password
                            </span>
                            <span id="updateBtnLoading" class="loading loading-spinner loading-md hidden"></span>
                        </button>
                    </form>
                    <!-- Back to Login Link -->
                    <div class="text-center mt-4">
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
            const form = document.getElementById('resetPasswordForm');
            const updateBtn = document.getElementById('updateButton');
            const updateBtnText = document.getElementById('updateBtnText');
            const updateBtnLoading = document.getElementById('updateBtnLoading');

            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');

            const togglePassword = document.getElementById('togglePassword');
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');

            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            const matchIndicator = document.getElementById('matchIndicator');
            const matchIcon = document.getElementById('matchIcon');
            const matchText = document.getElementById('matchText');

            // Password visibility toggles
            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const eyeOpen = document.getElementById('eyeOpen');
                    const eyeClosed = document.getElementById('eyeClosed');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeOpen.classList.add('hidden');
                        eyeClosed.classList.remove('hidden');
                    } else {
                        passwordInput.type = 'password';
                        eyeOpen.classList.remove('hidden');
                        eyeClosed.classList.add('hidden');
                    }
                });
            }

            if (togglePasswordConfirm) {
                togglePasswordConfirm.addEventListener('click', function() {
                    const eyeOpen = document.getElementById('eyeOpenConfirm');
                    const eyeClosed = document.getElementById('eyeClosedConfirm');

                    if (confirmPasswordInput.type === 'password') {
                        confirmPasswordInput.type = 'text';
                        eyeOpen.classList.add('hidden');
                        eyeClosed.classList.remove('hidden');
                    } else {
                        confirmPasswordInput.type = 'password';
                        eyeOpen.classList.remove('hidden');
                        eyeClosed.classList.add('hidden');
                    }
                });
            }

            // Password strength checker
            function checkPasswordStrength(password) {
                let score = 0;
                const requirements = {
                    length: password.length >= 8,
                    upper: /[A-Z]/.test(password),
                    lower: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[^A-Za-z0-9]/.test(password)
                };

                // Update requirement indicators
                Object.keys(requirements).forEach(req => {
                    const element = document.getElementById(`req-${req}`);
                    const indicator = element.querySelector('span');
                    if (requirements[req]) {
                        indicator.classList.remove('bg-base-300');
                        indicator.classList.add('bg-success');
                        score++;
                    } else {
                        indicator.classList.remove('bg-success');
                        indicator.classList.add('bg-base-300');
                    }
                });

                // Update strength bar
                const percentage = (score / 5) * 100;
                strengthBar.style.width = percentage + '%';

                if (score === 0) {
                    strengthBar.className = 'bg-error h-2 rounded-full transition-all duration-300';
                    strengthText.textContent = 'Very Weak';
                    strengthText.className = 'text-xs font-medium text-error';
                } else if (score <= 2) {
                    strengthBar.className = 'bg-error h-2 rounded-full transition-all duration-300';
                    strengthText.textContent = 'Weak';
                    strengthText.className = 'text-xs font-medium text-error';
                } else if (score <= 3) {
                    strengthBar.className = 'bg-warning h-2 rounded-full transition-all duration-300';
                    strengthText.textContent = 'Fair';
                    strengthText.className = 'text-xs font-medium text-warning';
                } else if (score <= 4) {
                    strengthBar.className = 'bg-info h-2 rounded-full transition-all duration-300';
                    strengthText.textContent = 'Good';
                    strengthText.className = 'text-xs font-medium text-info';
                } else {
                    strengthBar.className = 'bg-success h-2 rounded-full transition-all duration-300';
                    strengthText.textContent = 'Strong';
                    strengthText.className = 'text-xs font-medium text-success';
                }

                return score >= 4; // Require at least 4/5 criteria
            }

            // Password confirmation checker
            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirm = confirmPasswordInput.value;

                if (confirm.length === 0) {
                    matchIndicator.classList.add('hidden');
                    return false;
                }

                matchIndicator.classList.remove('hidden');

                if (password === confirm) {
                    matchIcon.innerHTML =
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                    matchIcon.classList.remove('text-error');
                    matchIcon.classList.add('text-success');
                    matchText.textContent = 'Passwords match';
                    matchText.classList.remove('text-error');
                    matchText.classList.add('text-success');
                    return true;
                } else {
                    matchIcon.innerHTML =
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                    matchIcon.classList.remove('text-success');
                    matchIcon.classList.add('text-error');
                    matchText.textContent = 'Passwords do not match';
                    matchText.classList.remove('text-success');
                    matchText.classList.add('text-error');
                    return false;
                }
            }

            // Event listeners
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    checkPasswordStrength(this.value);
                    if (confirmPasswordInput.value) {
                        checkPasswordMatch();
                    }
                });
            }

            if (confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', checkPasswordMatch);
            }

            // Form submission
            if (form && updateBtn) {
                form.addEventListener('submit', function(e) {
                    const password = passwordInput.value;
                    const confirm = confirmPasswordInput.value;

                    if (password.length < 8) {
                        e.preventDefault();
                        showToast('error', 'Password must be at least 8 characters long',
                            'Invalid Password');
                        return;
                    }

                    if (password !== confirm) {
                        e.preventDefault();
                        showToast('error', 'Passwords do not match', 'Password Mismatch');
                        return;
                    }

                    if (!checkPasswordStrength(password)) {
                        e.preventDefault();
                        showToast('warning',
                            'Please choose a stronger password that meets all requirements',
                            'Weak Password');
                        return;
                    }

                    // Show loading state
                    updateBtn.disabled = true;
                    updateBtn.classList.add('btn-disabled');
                    updateBtnText.classList.add('hidden');
                    updateBtnLoading.classList.remove('hidden');

                    showToast('info', 'Updating your password...', 'Processing');
                });
            }

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

                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.classList.add('opacity-0', 'transform', 'translate-x-full');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 6000);
            }

            // Auto-focus password input
            setTimeout(() => passwordInput.focus(), 500);
        });
    </script>

@endsection
