@extends('user.layout')

@section('title', 'Signup')
@section('meta_description', 'Daftar akun Exavro untuk mengelola notifikasi otomatis ke pemohon dan pegawai.')
@section('og_description', 'Daftar ke Exavro dan mulai kirim notifikasi WhatsApp otomatis ke pemohon dan pegawai.')

@if (config('services.recaptcha.site_key'))
    @push('head-scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endpush
@endif

@section('content')
<div class="xv-auth-shell">
    <div class="xv-auth-wrap">
        <a href="{{ route('home') }}" class="xv-auth-brand" title="Exavro">
            <img src="{{ asset('image/logoLotus.png') }}" alt="">
            <span class="xv-wordmark">EXAVRO</span>
        </a>

        <div class="xv-auth-card">
            <div class="text-center mb-6">
                <h1 class="xv-auth-title">Buat akun instansi</h1>
                <p class="xv-auth-subtitle mt-1">Daftar sekarang dan mulai kelola notifikasi WhatsApp Anda.</p>
            </div>

            <form method="POST" action="{{ route('signup.store') }}" id="signupForm" class="space-y-5">
                @csrf

                <div class="xv-field">
                    <label class="xv-label" for="name">Nama Lengkap</label>
                    <div class="xv-input-wrap">
                        <input type="text" id="name" name="name" required autocomplete="name" data-validate="name" data-autofocus
                            placeholder="Nama Anda" value="{{ old('name') }}"
                            class="xv-input @error('name') is-invalid @enderror">
                    </div>
                    @error('name') <p class="xv-field-error">{{ $message }}</p> @enderror
                </div>

                <div class="xv-field">
                    <label class="xv-label" for="email">Alamat Email</label>
                    <div class="xv-input-wrap">
                        <input type="email" id="email" name="email" required autocomplete="email" data-validate="email"
                            placeholder="nama@instansi.go.id" value="{{ old('email') }}"
                            class="xv-input @error('email') is-invalid @enderror">
                    </div>
                    @error('email') <p class="xv-field-error">{{ $message }}</p> @enderror
                </div>

                <div class="xv-field" id="passwordField">
                    <label class="xv-label" for="password">Password</label>
                    <div class="xv-input-wrap">
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                            placeholder="Buat password" data-strength-input data-match-password
                            class="xv-input has-icon @error('password') is-invalid @enderror">
                        <button type="button" class="xv-input-icon-btn" data-password-toggle="#password" aria-label="Lihat password">
                            <svg data-eye-open width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg data-eye-closed class="hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M9.878 9.878l-4.242-4.242m0 0L3.222 3.222m1.414 1.414L15.05 15.05"/></svg>
                        </button>
                    </div>

                    <div class="mt-2 space-y-1.5">
                        <div class="flex items-center justify-between">
                            <div class="xv-strength-track" data-strength-segments>
                                <span class="xv-strength-seg"></span>
                                <span class="xv-strength-seg"></span>
                                <span class="xv-strength-seg"></span>
                                <span class="xv-strength-seg"></span>
                            </div>
                            <span class="xv-strength-label ml-2" data-strength-label></span>
                        </div>
                    </div>

                    <ul class="xv-req-list mt-3">
                        <li class="xv-req-item" data-req="length">
                            <span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>
                            Minimal 8 karakter
                        </li>
                        <li class="xv-req-item" data-req="upper">
                            <span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>
                            Satu huruf besar
                        </li>
                        <li class="xv-req-item" data-req="lower">
                            <span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>
                            Satu huruf kecil
                        </li>
                        <li class="xv-req-item" data-req="number">
                            <span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>
                            Satu angka
                        </li>
                        <li class="xv-req-item" data-req="symbol">
                            <span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>
                            Satu simbol (!@#$%^&*)
                        </li>
                    </ul>

                    @error('password') <p class="xv-field-error mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="xv-field">
                    <label class="xv-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="xv-input-wrap">
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi password" data-match-confirm
                            class="xv-input has-icon @error('password_confirmation') is-invalid @enderror">
                        <button type="button" class="xv-input-icon-btn" data-password-toggle="#password_confirmation" aria-label="Lihat password">
                            <svg data-eye-open width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg data-eye-closed class="hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M9.878 9.878l-4.242-4.242m0 0L3.222 3.222m1.414 1.414L15.05 15.05"/></svg>
                        </button>
                    </div>
                    <p class="xv-match-note hidden mt-1" data-match-note></p>
                    @error('password_confirmation') <p class="xv-field-error">{{ $message }}</p> @enderror
                </div>

                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                <button type="submit" id="signupButton" class="xv-btn xv-btn-accent xv-btn-block">
                    <span data-btn-label>Buat Akun</span>
                    <span data-btn-spinner class="xv-spinner hidden"></span>
                </button>

                <p class="xv-auth-footnote">
                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                </p>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const { showToast, initGuardedSubmit, initPasswordStrength, initPasswordMatch } = window.ExavroAuth;

        const strength = initPasswordStrength(document.getElementById('passwordField'));
        const match = initPasswordMatch(document.getElementById('signupForm'));

        initGuardedSubmit({
            form: document.getElementById('signupForm'),
            button: document.getElementById('signupButton'),
            siteKey: @json(config('services.recaptcha.site_key')),
            action: 'signup',
            onBeforeSubmit() {
                if (strength && strength.getScore() < 4) {
                    showToast('warning', 'Pilih password yang lebih kuat dulu ya.', 'Password lemah');
                    return false;
                }
                if (match && !match.matches()) {
                    showToast('error', 'Konfirmasi password belum cocok.', 'Tidak cocok');
                    return false;
                }
                return true;
            },
        });

        @if (session('error')) showToast('error', "{{ session('error') }}"); @endif
        @if (session('success')) showToast('success', "{{ session('success') }}"); @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error) showToast('error', "{{ $error }}"); @endforeach
        @endif
    });
</script>
@endsection