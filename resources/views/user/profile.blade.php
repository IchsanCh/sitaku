@extends('user.layout2')

@section('title', 'Profile')
@section('meta_description',
    'Perbarui informasi dirimu dan pastikan semua notifikasi berjalan lancar. SITAKU membantumu
    tetap terhubung dengan tugas setiap hari.')
@section('og_description',
    'Kelola profilmu di Dashboard SITAKU dan pastikan notifikasi WhatsApp otomatis selalu
    up-to-date.')

@section('content')
    <div class="min-h-screen bg-base-200">
        <!-- Simple Header -->
        <div class="bg-base-100 borderbc1">
            <div class="max-w-4xl mx-auto px-6 py-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-base-content">Profile</h1>
                        <p class="text-base-content/70">Configure your SITAKU Account</p>
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
                        <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>

                        <div>
                            <h2 class="text-xl font-semibold text-black">User Configuration</h2>
                            <p class="text-sm text-black">Configure your SITAKU Account</p>
                        </div>
                    </div>
                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="form-control">
                            <label class="label mb-1" for="name">
                                <span class="label-text font-medium text-black">Nama</span>
                                <span class="badge badge-primary badge-sm">Required</span>
                            </label>
                            <input type="text" id="name" name="name"
                                class="input input-bordered border-primary focus:input-primary w-full"
                                placeholder="Ex: nama saya CH" value="{{ $user->name }}" required>
                            <div id="name-error" class="text-error text-sm mt-1 hidden"></div>
                            <label class="label">
                                <span class="label-text-alt text-black">Enter Your Full Name</span>
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="label mb-1" for="email">
                                <span class="label-text font-medium text-black">Email</span>
                                <span class="badge badge-primary badge-sm">Required</span>
                            </label>
                            <input type="email" id="email" name="email"
                                class="input border-primary focus:input-primary input-bordered w-full"
                                placeholder="Ex: example@ex.com" value="{{ $user->email }}" required>
                            <div id="email-error" class="text-error text-sm mt-1 hidden"></div>
                            <label class="label">
                                <span class="label-text-alt text-black">Your Email</span>
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="label mb-1" for="password">
                                <span class="label-text font-medium text-black">Password</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="input input-bordered border-primary focus:input-primary w-full pr-10"
                                    placeholder="Enter your New Password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword('password')">
                                    <svg id="password-eye" class="w-4 h-4 text-black" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div id="password-error" class="text-error text-sm mt-1 hidden"></div>
                            <div class="text-xs text-gray-600 mt-1">
                                <span>Password must contain: 1 uppercase, 1 lowercase, 1 number, 1 special character,
                                    minimum 8 characters</span>
                            </div>
                            <div class="relative mt-4">
                                <input type="password" id="confirmpassword" name="confirmpassword"
                                    class="input input-bordered border-primary focus:input-primary w-full pr-10"
                                    placeholder="Password Confirmation">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword('confirmpassword')">
                                    <svg id="confirmpassword-eye" class="w-4 h-4 text-black" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div id="confirmpassword-error" class="text-error text-sm mt-1 hidden"></div>
                            <div class="">
                                <span class="text-black">Kosongkan jika tidak ingin mengubah password</span>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" id="submitBtn" class="btn btn-primary w-full sm:w-auto">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save User
                            </button>
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

            // Initialize validation
            initValidation();
        });

        // Validation functions
        function initValidation() {
            const form = document.getElementById('profileForm');
            const nameField = document.getElementById('name');
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('confirmpassword');

            // Real-time validation
            nameField.addEventListener('input', validateName);
            nameField.addEventListener('blur', validateName);

            emailField.addEventListener('input', validateEmail);
            emailField.addEventListener('blur', validateEmail);

            passwordField.addEventListener('input', validatePassword);
            passwordField.addEventListener('blur', validatePassword);

            confirmPasswordField.addEventListener('input', validateConfirmPassword);
            confirmPasswordField.addEventListener('blur', validateConfirmPassword);

            // Form submission validation
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const isNameValid = validateName();
                const isEmailValid = validateEmail();
                const isPasswordValid = validatePassword();
                const isConfirmPasswordValid = validateConfirmPassword();

                if (isNameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid) {
                    // All validations passed, submit the form
                    this.submit();
                } else {
                    showToast('error', 'Please fix the validation errors before submitting.');
                }
            });
        }

        function validateName() {
            const nameField = document.getElementById('name');
            const errorDiv = document.getElementById('name-error');
            const name = nameField.value.trim();

            if (name.length === 0) {
                showError(nameField, errorDiv, 'Name is required.');
                return false;
            }

            if (name.length < 2) {
                showError(nameField, errorDiv, 'Name must be at least 2 characters long.');
                return false;
            }

            if (name.length > 50) {
                showError(nameField, errorDiv, 'Name must not exceed 50 characters.');
                return false;
            }

            // Check for valid characters (letters, spaces, hyphens, apostrophes)
            if (!/^[a-zA-Z\s\-']+$/.test(name)) {
                showError(nameField, errorDiv, 'Name can only contain letters, spaces, hyphens, and apostrophes.');
                return false;
            }

            clearError(nameField, errorDiv);
            return true;
        }

        function validateEmail() {
            const emailField = document.getElementById('email');
            const errorDiv = document.getElementById('email-error');
            const email = emailField.value.trim();

            if (email.length === 0) {
                showError(emailField, errorDiv, 'Email is required.');
                return false;
            }

            // Basic email regex pattern
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                showError(emailField, errorDiv, 'Please enter a valid email address.');
                return false;
            }

            if (email.length > 254) {
                showError(emailField, errorDiv, 'Email address is too long.');
                return false;
            }

            clearError(emailField, errorDiv);
            return true;
        }

        function validatePassword() {
            const passwordField = document.getElementById('password');
            const errorDiv = document.getElementById('password-error');
            const password = passwordField.value;

            // If password is empty, it's optional (user doesn't want to change password)
            if (password.length === 0) {
                clearError(passwordField, errorDiv);
                return true;
            }

            if (password.length < 8) {
                showError(passwordField, errorDiv, 'Password must be at least 8 characters long.');
                return false;
            }

            if (password.length > 128) {
                showError(passwordField, errorDiv, 'Password must not exceed 128 characters.');
                return false;
            }

            // Check for uppercase letter
            if (!/[A-Z]/.test(password)) {
                showError(passwordField, errorDiv, 'Password must contain at least one uppercase letter.');
                return false;
            }

            // Check for lowercase letter
            if (!/[a-z]/.test(password)) {
                showError(passwordField, errorDiv, 'Password must contain at least one lowercase letter.');
                return false;
            }

            // Check for number
            if (!/\d/.test(password)) {
                showError(passwordField, errorDiv, 'Password must contain at least one number.');
                return false;
            }

            // Check for special character
            if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
                showError(passwordField, errorDiv, 'Password must contain at least one special character.');
                return false;
            }

            clearError(passwordField, errorDiv);
            return true;
        }

        function validateConfirmPassword() {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('confirmpassword');
            const errorDiv = document.getElementById('confirmpassword-error');
            const password = passwordField.value;
            const confirmPassword = confirmPasswordField.value;

            // If both passwords are empty, it's valid (user doesn't want to change password)
            if (password.length === 0 && confirmPassword.length === 0) {
                clearError(confirmPasswordField, errorDiv);
                return true;
            }

            // If password is provided but confirmation is empty
            if (password.length > 0 && confirmPassword.length === 0) {
                showError(confirmPasswordField, errorDiv, 'Please confirm your password.');
                return false;
            }

            // If passwords don't match
            if (password !== confirmPassword) {
                showError(confirmPasswordField, errorDiv, 'Password confirmation does not match.');
                return false;
            }

            clearError(confirmPasswordField, errorDiv);
            return true;
        }

        function showError(field, errorDiv, message) {
            field.classList.add('input-error');
            field.classList.remove('input-success');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
        }

        function clearError(field, errorDiv) {
            field.classList.remove('input-error');
            field.classList.add('input-success');
            errorDiv.textContent = '';
            errorDiv.classList.add('hidden');
        }

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

    <style>
        .input-error {
            border-color: #ef4444 !important;
            background-color: #fef2f2;
        }

        .input-success {
            border-color: #10b981 !important;
        }

        .text-error {
            color: #ef4444;
        }
    </style>

@endsection
