@extends('user.layout')

@section('title', 'Sign Up')
@section('meta_description', 'Daftar akun SITAKU untuk mengelola notifikasi otomatis ke pemohon dan pegawai.')
@section('og_description', 'Daftar ke SITAKU dan mulai kirim notifikasi WhatsApp otomatis ke pemohon dan pegawai.')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/5 via-base-100 to-secondary/5 p-4">
        <div class="w-full max-w-md">
            <!-- Signup Card -->
            <div class="card bg-base-100 shadow-2xl border border-base-300">
                <div class="card-body p-8 overflow-hidden">
                    <!-- Header -->
                    <div class="text-center mb-6" data-aos="fade-up" data-aos-duration="700">
                        <div class="avatar mb-4">
                            <div class="w-20 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="{{ asset('image/logoLotus.png') }}" alt="Logo Lotus" class="object-cover" />
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-base-content mb-2">Create Account</h1>
                        <p class="text-base-content/70">Sign up for your SITAKU account</p>
                    </div>

                    <!-- Signup Form -->
                    <form method="POST" action="{{ route('signup.store') }}" id="signupForm" class="space-y-6">
                        @csrf

                        <!-- Name Field -->
                        <div class="form-control" data-aos="fade-up" data-aos-duration="800">
                            <label class="label" for="name">
                                <span class="label-text font-medium">Full Name</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="name" name="name" required
                                    placeholder="Enter your full name" value="{{ old('name') }}"
                                    class="input input-bordered w-full pr-10 focus:input-primary transition-colors duration-200 @error('name') input-error @enderror" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-base-content/40" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-control" data-aos="fade-up" data-aos-duration="900">
                            <label class="label" for="email">
                                <span class="label-text font-medium">Email Address</span>
                            </label>
                            <div class="relative">
                                <input type="email" id="email" name="email" required placeholder="Enter your email"
                                    value="{{ old('email') }}"
                                    class="input input-bordered w-full pr-10 focus:input-primary transition-colors duration-200 @error('email') input-error @enderror" />
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
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-control" data-aos="fade-up" data-aos-duration="1000">
                            <label class="label" for="password">
                                <span class="label-text font-medium">Password</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    placeholder="Create a password"
                                    class="input input-bordered w-full pr-10 focus:input-primary transition-colors duration-200 @error('password') input-error @enderror" />
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/40 hover:text-base-content transition-colors">
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
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M9.878 9.878l-4.242-4.242m0 0L3.222 3.222m1.414 1.414L15.05 15.05">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="mt-2">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs text-base-content/60">Password strength:</span>
                                    <span id="strengthText" class="text-xs font-medium text-base-content/60">Weak</span>
                                </div>
                                <progress id="strengthMeter" class="progress progress-error w-full h-2" value="0"
                                    max="100"></progress>
                            </div>

                            <!-- Password Requirements -->
                            <div id="passwordRequirements" class="mt-3 space-y-2 text-xs">
                                <div class="flex items-center gap-2" id="lengthReq">
                                    <div
                                        class="w-4 h-4 rounded-full border-2 border-error flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-error hidden" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base-content/70">At least 8 characters</span>
                                </div>
                                <div class="flex items-center gap-2" id="uppercaseReq">
                                    <div
                                        class="w-4 h-4 rounded-full border-2 border-error flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-error hidden" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base-content/70">At least 1 uppercase letter</span>
                                </div>
                                <div class="flex items-center gap-2" id="lowercaseReq">
                                    <div
                                        class="w-4 h-4 rounded-full border-2 border-error flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-error hidden" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base-content/70">At least 1 lowercase letter</span>
                                </div>
                                <div class="flex items-center gap-2" id="numberReq">
                                    <div
                                        class="w-4 h-4 rounded-full border-2 border-error flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-error hidden" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base-content/70">At least 1 number</span>
                                </div>
                                <div class="flex items-center gap-2" id="symbolReq">
                                    <div
                                        class="w-4 h-4 rounded-full border-2 border-error flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-error hidden" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base-content/70">At least 1 special character (!@#$%^&*)</span>
                                </div>
                            </div>

                            @error('password')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Password Confirmation Field -->
                        <div class="form-control">
                            <label class="label" for="password_confirmation">
                                <span class="label-text font-medium">Confirm Password</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    placeholder="Confirm your password"
                                    class="input input-bordered w-full pr-10 focus:input-primary transition-colors duration-200 @error('password_confirmation') input-error @enderror" />
                                <button type="button" id="togglePasswordConfirm"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/40 hover:text-base-content transition-colors">
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
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M9.878 9.878l-4.242-4.242m0 0L3.222 3.222m1.414 1.414L15.05 15.05">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Password Match Indicator -->
                            <div id="passwordMatchStatus" class="mt-2 text-xs hidden">
                                <div class="flex items-center gap-2">
                                    <div id="matchIcon" class="w-4 h-4"></div>
                                    <span id="matchText"></span>
                                </div>
                            </div>

                            @error('password_confirmation')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                        <!-- Signup Button -->
                        <button type="submit" id="signupButton"
                            class="btn btn-primary w-full h-12 text-base font-medium">
                            <span id="btnText" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                                Create Account
                            </span>
                            <span id="btnLoading"
                                class="loading loading-spinner loading-primary loading-md color1 hidden"></span>
                        </button>

                        <!-- Login Link -->
                        <div class="text-center pt-4">
                            <p class="text-base-content/70 text-sm">
                                Already have an account?
                                <a href="{{ route('login') }}" class="link link-primary font-medium">Sign in here</a>
                            </p>
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
            // Form elements
            const form = document.getElementById('signupForm');
            const btn = document.getElementById('signupButton');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');

            // Password elements
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');

            // Password requirements elements
            const lengthReq = document.getElementById('lengthReq');
            const uppercaseReq = document.getElementById('uppercaseReq');
            const lowercaseReq = document.getElementById('lowercaseReq');
            const numberReq = document.getElementById('numberReq');
            const symbolReq = document.getElementById('symbolReq');

            // Password strength elements
            const strengthMeter = document.getElementById('strengthMeter');
            const strengthText = document.getElementById('strengthText');

            // Password match elements
            const passwordMatchStatus = document.getElementById('passwordMatchStatus');
            const matchIcon = document.getElementById('matchIcon');
            const matchText = document.getElementById('matchText');

            // Password toggle functionality for main password
            const togglePassword = document.getElementById('togglePassword');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeOpen.classList.toggle('hidden');
                    eyeClosed.classList.toggle('hidden');
                });
            }

            // Password toggle functionality for confirmation password
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const eyeOpenConfirm = document.getElementById('eyeOpenConfirm');
            const eyeClosedConfirm = document.getElementById('eyeClosedConfirm');

            if (togglePasswordConfirm && passwordConfirmInput) {
                togglePasswordConfirm.addEventListener('click', function() {
                    const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' :
                        'password';
                    passwordConfirmInput.setAttribute('type', type);
                    eyeOpenConfirm.classList.toggle('hidden');
                    eyeClosedConfirm.classList.toggle('hidden');
                });
            }

            // Password validation function
            function validatePassword(password) {
                const requirements = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /\d/.test(password),
                    symbol: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
                };

                return requirements;
            }

            // Update requirement status
            function updateRequirementStatus(element, isValid) {
                const circle = element.querySelector('div');
                const checkmark = element.querySelector('svg');
                const text = element.querySelector('span');

                if (isValid) {
                    circle.classList.remove('border-error');
                    circle.classList.add('border-success', 'bg-success');
                    checkmark.classList.remove('hidden', 'text-error');
                    checkmark.classList.add('text-success-content');
                    text.classList.remove('text-base-content/70');
                    text.classList.add('text-success');
                } else {
                    circle.classList.remove('border-success', 'bg-success');
                    circle.classList.add('border-error');
                    checkmark.classList.add('hidden', 'text-error');
                    checkmark.classList.remove('text-success-content');
                    text.classList.remove('text-success');
                    text.classList.add('text-base-content/70');
                }
            }

            // Calculate password strength
            function calculateStrength(requirements) {
                const validCount = Object.values(requirements).filter(Boolean).length;
                const strength = (validCount / 5) * 100;

                let strengthLevel = 'Very Weak';
                let colorClass = 'progress-error';

                if (strength >= 80) {
                    strengthLevel = 'Very Strong';
                    colorClass = 'progress-success';
                } else if (strength >= 60) {
                    strengthLevel = 'Strong';
                    colorClass = 'progress-info';
                } else if (strength >= 40) {
                    strengthLevel = 'Medium';
                    colorClass = 'progress-warning';
                } else if (strength >= 20) {
                    strengthLevel = 'Weak';
                    colorClass = 'progress-error';
                }

                return {
                    strength,
                    strengthLevel,
                    colorClass
                };
            }

            // Real-time password validation
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    const requirements = validatePassword(password);

                    // Update individual requirements
                    updateRequirementStatus(lengthReq, requirements.length);
                    updateRequirementStatus(uppercaseReq, requirements.uppercase);
                    updateRequirementStatus(lowercaseReq, requirements.lowercase);
                    updateRequirementStatus(numberReq, requirements.number);
                    updateRequirementStatus(symbolReq, requirements.symbol);

                    // Update strength meter
                    const {
                        strength,
                        strengthLevel,
                        colorClass
                    } = calculateStrength(requirements);
                    strengthMeter.value = strength;
                    strengthText.textContent = strengthLevel;

                    // Update progress bar color
                    strengthMeter.className = `progress ${colorClass} w-full h-2`;

                    // Update input border color based on strength
                    this.classList.remove('input-error', 'input-warning', 'input-info', 'input-success');
                    if (password.length > 0) {
                        if (strength >= 80) {
                            this.classList.add('input-success');
                        } else if (strength >= 60) {
                            this.classList.add('input-info');
                        } else if (strength >= 40) {
                            this.classList.add('input-warning');
                        } else {
                            this.classList.add('input-error');
                        }
                    }

                    // Check password match if confirmation field has value
                    if (passwordConfirmInput.value) {
                        checkPasswordMatch();
                    }
                });
            }

            // Password match validation
            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = passwordConfirmInput.value;

                if (confirmPassword.length === 0) {
                    passwordMatchStatus.classList.add('hidden');
                    passwordConfirmInput.classList.remove('input-error', 'input-success');
                    return;
                }

                passwordMatchStatus.classList.remove('hidden');

                if (password === confirmPassword) {
                    // Passwords match
                    matchIcon.innerHTML = `
                        <div class="w-4 h-4 rounded-full bg-success flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-success-content" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    `;
                    matchText.textContent = 'Passwords match';
                    matchText.className = 'text-success';
                    passwordConfirmInput.classList.remove('input-error');
                    passwordConfirmInput.classList.add('input-success');
                } else {
                    // Passwords don't match
                    matchIcon.innerHTML = `
                        <div class="w-4 h-4 rounded-full bg-error flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-error-content" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    `;
                    matchText.textContent = 'Passwords do not match';
                    matchText.className = 'text-error';
                    passwordConfirmInput.classList.remove('input-success');
                    passwordConfirmInput.classList.add('input-error');
                }
            }

            // Real-time password confirmation validation
            if (passwordConfirmInput) {
                passwordConfirmInput.addEventListener('input', checkPasswordMatch);
            }

            // Form submission handling
            if (form && btn) {
                form.addEventListener('submit', function(e) {
                    const termsCheckbox = document.getElementById('terms');
                    if (!termsCheckbox.checked) {
                        e.preventDefault();
                        showToast('error', 'Please agree to the Terms of Service and Privacy Policy',
                            'Required');
                        return;
                    }

                    // Validate password strength
                    const password = passwordInput.value;
                    const requirements = validatePassword(password);
                    const {
                        strength
                    } = calculateStrength(requirements);

                    if (strength < 60) {
                        e.preventDefault();
                        showToast('warning', 'Please choose a stronger password for better security',
                            'Weak Password');
                        return;
                    }

                    // Check password match
                    if (passwordInput.value !== passwordConfirmInput.value) {
                        e.preventDefault();
                        showToast('error', 'Passwords do not match', 'Validation Error');
                        return;
                    }

                    btn.disabled = true;
                    btn.classList.add('btn-disabled');
                    btnText.classList.add('hidden');
                    btnLoading.classList.remove('hidden');
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
                    type === 'warning' ?
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>' :
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

                const toast = document.createElement('div');
                toast.className = `alert ${alertClass} shadow-lg mb-4 animate-pulse`;
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

                // Remove animate-pulse after animation
                setTimeout(() => {
                    toast.classList.remove('animate-pulse');
                }, 1000);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.classList.add('opacity-0', 'transform', 'translate-x-full', 'transition-all',
                            'duration-300');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 5000);
            }

            // Email validation
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('input', function() {
                    const email = this.value;
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (email.length === 0) {
                        this.classList.remove('input-error', 'input-success');
                        return;
                    }

                    if (emailRegex.test(email)) {
                        this.classList.remove('input-error');
                        this.classList.add('input-success');
                    } else {
                        this.classList.remove('input-success');
                        this.classList.add('input-error');
                    }
                });
            }

            // Name validation
            const nameInput = document.getElementById('name');
            if (nameInput) {
                nameInput.addEventListener('input', function() {
                    const name = this.value.trim();

                    if (name.length === 0) {
                        this.classList.remove('input-error', 'input-success');
                        return;
                    }

                    if (name.length >= 2 && /^[a-zA-Z\s]+$/.test(name)) {
                        this.classList.remove('input-error');
                        this.classList.add('input-success');
                    } else {
                        this.classList.remove('input-success');
                        this.classList.add('input-error');
                    }
                });
            }

            // Smooth scroll to first error if validation fails
            function scrollToFirstError() {
                const firstError = document.querySelector('.input-error');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            }

            // Enhanced form validation on submit
            form.addEventListener('submit', function(e) {
                const nameValue = nameInput.value.trim();
                const emailValue = emailInput.value.trim();
                const passwordValue = passwordInput.value;
                const confirmPasswordValue = passwordConfirmInput.value;
                const termsChecked = document.getElementById('terms').checked;

                let hasErrors = false;

                // Validate name
                if (nameValue.length < 2 || !/^[a-zA-Z\s]+$/.test(nameValue)) {
                    nameInput.classList.add('input-error');
                    hasErrors = true;
                }

                // Validate email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailValue)) {
                    emailInput.classList.add('input-error');
                    hasErrors = true;
                }

                // Validate password strength
                const requirements = validatePassword(passwordValue);
                const {
                    strength
                } = calculateStrength(requirements);
                if (strength < 60) {
                    passwordInput.classList.add('input-error');
                    hasErrors = true;
                }

                // Validate password match
                if (passwordValue !== confirmPasswordValue) {
                    passwordConfirmInput.classList.add('input-error');
                    hasErrors = true;
                }

                // Validate terms
                if (!termsChecked) {
                    hasErrors = true;
                }

                if (hasErrors) {
                    e.preventDefault();
                    scrollToFirstError();
                    showToast('error', 'Please fix the highlighted errors before submitting',
                        'Form Validation');
                    return;
                }
            });

            // Keyboard navigation enhancement
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
                    const inputs = Array.from(document.querySelectorAll('input'));
                    const currentIndex = inputs.indexOf(e.target);
                    const nextInput = inputs[currentIndex + 1];

                    if (nextInput && nextInput.type !== 'submit') {
                        e.preventDefault();
                        nextInput.focus();
                    }
                }
            });

            // Initialize tooltips for password requirements
            const requirementElements = [lengthReq, uppercaseReq, lowercaseReq, numberReq, symbolReq];
            requirementElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    this.classList.add('bg-base-200', 'rounded-lg', 'p-1', 'transition-all',
                        'duration-200');
                });

                element.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-base-200', 'rounded-lg', 'p-1');
                });
            });
        });
    </script>

@endsection
