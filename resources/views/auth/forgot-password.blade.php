@extends('user.layout')

@section('title', 'Reset Password')
@section('meta_description', 'Reset password akun Exavro Anda dengan mudah dan aman.')
@section('og_description', 'Masukkan email Anda untuk menerima link reset password.')

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
                <h1 class="xv-auth-title">Lupa password?</h1>
                <p class="xv-auth-subtitle mt-1">Masukkan email Anda untuk menerima link pengaturan ulang password.</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" id="resetForm" class="space-y-5">
                @csrf

                <div class="xv-field">
                    <label class="xv-label" for="email">Alamat Email</label>
                    <div class="xv-input-wrap">
                        <input type="email" id="email" name="email" required autocomplete="email" data-validate="email" data-autofocus
                            placeholder="nama@instansi.go.id" value="{{ old('email') }}"
                            class="xv-input has-icon @error('email') is-invalid @enderror">
                        <span class="xv-input-static-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </span>
                    </div>
                    @error('email') <p class="xv-field-error">{{ $message }}</p> @enderror
                </div>

                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                <button type="submit" id="resetButton" class="xv-btn xv-btn-accent xv-btn-block">
                    <span data-btn-label>Kirim Link Reset</span>
                    <span data-btn-spinner class="xv-spinner hidden"></span>
                </button>
            </form>

            <div class="xv-divider">atau</div>

            <div class="flex gap-3 justify-center">
                <a href="{{ route('login') }}" class="xv-btn xv-btn-outline-ink" style="height: 2.25rem; padding: 0 1rem; font-size: 0.85rem;">
                    Kembali Masuk
                </a>
                <a href="{{ route('signup') }}" class="xv-btn xv-btn-outline-ink" style="height: 2.25rem; padding: 0 1rem; font-size: 0.85rem;">
                    Daftar Akun
                </a>
            </div>

            <div class="xv-info-box mt-6">
                <strong>Selanjutnya:</strong>
                <ul>
                    <li>Kami akan mengirim link reset ke email Anda</li>
                    <li>Link berlaku selama 60 menit</li>
                    <li>Gunakan link tersebut untuk membuat password baru</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const { showToast, initGuardedSubmit } = window.ExavroAuth;

        initGuardedSubmit({
            form: document.getElementById('resetForm'),
            button: document.getElementById('resetButton'),
            siteKey: @json(config('services.recaptcha.site_key')),
            action: 'forgot_password',
            onBeforeSubmit() {
                const email = document.getElementById('email').value.trim();
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showToast('error', 'Masukkan alamat email yang valid.', 'Email tidak valid');
                    return false;
                }
                return true;
            },
        });

        @if (session('status'))
            showToast('success', "{{ session('status') }}", 'Link terkirim');
        @endif
        @if (session('error')) showToast('error', "{{ session('error') }}"); @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error) showToast('error', "{{ $error }}"); @endforeach
        @endif
    });
</script>
@endsection