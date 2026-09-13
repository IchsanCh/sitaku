@extends('user.layout')

@section('title', 'Login')
@section('meta_description', 'Masuk ke akun Exavro untuk mengelola notifikasi otomatis ke pemohon dan pegawai.')
@section('og_description', 'Login ke Exavro dan mulai kirim notifikasi WhatsApp otomatis ke pemohon dan pegawai.')

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
                <h1 class="xv-auth-title">Selamat datang kembali</h1>
                <p class="xv-auth-subtitle mt-1">Masuk untuk melanjutkan aktivitas Anda di EXAVRO.</p>
            </div>

            <form method="POST" action="{{ route('login.user') }}" id="loginForm" class="space-y-5">
                @csrf

                <div class="xv-field">
                    <label class="xv-label" for="email">Alamat Email</label>
                    <div class="xv-input-wrap">
                        <input type="email" id="email" name="email" required autocomplete="email"
                            placeholder="nama@instansi.go.id" value="{{ old('email') }}" data-autofocus
                            class="xv-input has-icon @error('email') is-invalid @enderror">
                        <span class="xv-input-static-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </span>
                    </div>
                    @error('email') <p class="xv-field-error">{{ $message }}</p> @enderror
                </div>

                <div class="xv-field">
                    <label class="xv-label" for="password">Password</label>
                    <div class="xv-input-wrap">
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="xv-input has-icon @error('password') is-invalid @enderror">
                        <button type="button" class="xv-input-icon-btn" data-password-toggle="#password" aria-label="Lihat password">
                            <svg data-eye-open width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg data-eye-closed class="hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M9.878 9.878l-4.242-4.242m0 0L3.222 3.222m1.414 1.414L15.05 15.05"/></svg>
                        </button>
                    </div>
                    @error('password') <p class="xv-field-error">{{ $message }}</p> @enderror
                </div>

                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                <button type="submit" id="loginButton" class="xv-btn xv-btn-accent xv-btn-block">
                    <span data-btn-label>Masuk</span>
                    <span data-btn-spinner class="xv-spinner hidden"></span>
                </button>

                <p class="xv-auth-footnote">
                    Lupa password? <a href="{{ route('password.email') }}">Atur ulang</a>
                </p>
            </form>

            <div class="xv-divider">atau</div>

            <p class="xv-auth-footnote">
                Belum punya akun? <a href="{{ route('signup') }}">Buat Akun</a>
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const { showToast, initGuardedSubmit } = window.ExavroAuth;

        initGuardedSubmit({
            form: document.getElementById('loginForm'),
            button: document.getElementById('loginButton'),
            siteKey: @json(config('services.recaptcha.site_key')),
            action: 'login',
        });

        @if (session('error')) showToast('error', "{{ session('error') }}"); @endif
        @if (session('success')) showToast('success', "{{ session('success') }}"); @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error) showToast('error', "{{ $error }}"); @endforeach
        @endif
    });
</script>
@endsection