@extends('user.layout')

@section('title', 'Login')
@section('meta_description', 'Masuk ke akun SITAKU untuk mengelola notifikasi otomatis ke pemohon dan pegawai.')
@section('og_description', 'Login ke SITAKU dan mulai kirim notifikasi WhatsApp otomatis ke pemohon dan pegawai.')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/5 via-base-100 to-secondary/5 p-4">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="card bg-base-100 shadow-2xl border border-base-300">
                <div class="card-body p-8 overflow-hidden">
                    <!-- Header -->
                    <div class="text-center mb-6" data-aos="fade-up" data-aos-duration="700">
                        <div class="avatar mb-4">
                            <div class="w-20 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="{{ asset('image/logoLotus.png') }}" alt="Logo Lotus" class="object-cover" />
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-base-content mb-2">Welcome Back</h1>
                        <p class="text-base-content/70">Sign in to your SITAKU account</p>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login.user') }}" id="loginForm" class="space-y-6">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-control" data-aos="fade-up" data-aos-duration="800">
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
                        <div class="form-control" data-aos="fade-up" data-aos-duration="900">
                            <label class="label" for="password">
                                <span class="label-text font-medium">Password</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    placeholder="Enter your password"
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
                            @error('password')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                        <!-- Login Button -->
                        <button type="submit" id="loginButton" class="btn btn-primary w-full h-12 text-base font-medium"
                            title="Sign In" data-aos="fade-in" data-aos-duration="1100">
                            <span id="btnText" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Sign In
                            </span>
                            <span id="btnLoading" class="loading loading-spinner loading-md color1 hidden"></span>
                        </button>
                    </form>
                    <div class="pt-2">
                        <p class="text-base-content/70 text-sm">
                            Lupa password?
                            <a href="{{ route('password.email') }}" class="link link-primary font-medium"
                                title="Lupa Password" title="lupa password">Click here</a>
                        </p>
                    </div>
                    <div class="text-center pt-2">
                        <p class="text-base-content/70 text-sm">
                            Don't have account?
                            <a href="{{ route('signup') }}" title="Sign Up" class="link link-primary font-medium"
                                title="sign up">Sign up
                                here</a>
                        </p>
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
            const form = document.getElementById('loginForm');
            const btn = document.getElementById('loginButton');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            // Password toggle functionality
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    eyeOpen.classList.toggle('hidden');
                    eyeClosed.classList.toggle('hidden');
                });
            }

            // Form submission handling
            if (form && btn) {
                form.addEventListener('submit', function(e) {
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
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

                const toast = document.createElement('div');
                toast.className = `alert ${alertClass} shadow-lg mb-4`;
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

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.classList.add('opacity-0', 'transform', 'translate-x-full');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 5000);
            }
        });
    </script>

@endsection
