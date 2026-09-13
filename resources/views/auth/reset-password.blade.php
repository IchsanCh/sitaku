@extends('user.layout')

@section('title', 'Set New Password')
@section('meta_description', 'Buat password baru untuk akun Exavro Anda dengan aman.')
@section('og_description', 'Masukkan password baru yang kuat untuk mengamankan akun Anda.')

@section('content')
<div class="xv-auth-shell">
    <div class="xv-auth-wrap">
        <a href="{{ route('home') }}" class="xv-auth-brand" title="Exavro">
            <img src="{{ asset('image/logoLotus.png') }}" alt="">
            <span class="xv-wordmark">EXAVRO</span>
        </a>

        <div class="xv-auth-card">
            <div class="text-center mb-6">
                <h1 class="xv-auth-title">Buat password baru</h1>
                <p class="xv-auth-subtitle mt-1">Tinggal satu langkah lagi. Buat password baru untuk akun Anda.</p>
                <p class="xv-status-line mt-2">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Terverifikasi untuk {{ $email }}
                </p>
            </div>

            @if (session('status'))
                <div class="xv-info-box mb-5" style="border-color: var(--xv-signal);">
                    <strong>Berhasil!</strong> {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ old('email', $email) }}">

                <div class="xv-field" id="passwordField">
                    <label class="xv-label" for="password">Password Baru</label>
                    <div class="xv-input-wrap">
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                            placeholder="Masukkan password baru" data-strength-input data-match-password data-autofocus
                            class="xv-input has-icon @error('password') is-invalid @enderror">
                        <button type="button" class="xv-input-icon-btn" data-password-toggle="#password" aria-label="Lihat password">
                            <svg data-eye-open width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg data-eye-closed class="hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/></svg>
                        </button>
                    </div>
                    @error('password') <p class="xv-field-error">{{ $message }}</p> @enderror

                    <div class="mt-2 flex items-center justify-between">
                        <div class="xv-strength-track" data-strength-segments>
                            <span class="xv-strength-seg"></span>
                            <span class="xv-strength-seg"></span>
                            <span class="xv-strength-seg"></span>
                            <span class="xv-strength-seg"></span>
                        </div>
                        <span class="xv-strength-label ml-2" data-strength-label></span>
                    </div>

                    <ul class="xv-req-list mt-3">
                        <li class="xv-req-item" data-req="length"><span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>Minimal 8 karakter</li>
                        <li class="xv-req-item" data-req="upper"><span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>Satu huruf besar</li>
                        <li class="xv-req-item" data-req="lower"><span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>Satu huruf kecil</li>
                        <li class="xv-req-item" data-req="number"><span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>Satu angka</li>
                        <li class="xv-req-item" data-req="symbol"><span class="xv-req-dot"><svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>Satu simbol (!@#$%^&*)</li>
                    </ul>
                </div>

                <div class="xv-field">
                    <label class="xv-label" for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="xv-input-wrap">
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi password baru" data-match-confirm
                            class="xv-input has-icon @error('password_confirmation') is-invalid @enderror">
                        <button type="button" class="xv-input-icon-btn" data-password-toggle="#password_confirmation" aria-label="Lihat password">
                            <svg data-eye-open width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg data-eye-closed class="hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/></svg>
                        </button>
                    </div>
                    <p class="xv-match-note hidden mt-1" data-match-note></p>
                    @error('password_confirmation') <p class="xv-field-error">{{ $message }}</p> @enderror
                </div>

                <button type="submit" id="updateButton" class="xv-btn xv-btn-accent xv-btn-block">
                    <span data-btn-label>Perbarui Password</span>
                    <span data-btn-spinner class="xv-spinner hidden"></span>
                </button>
            </form>

            <p class="xv-auth-footnote mt-5">
                <a href="{{ route('login') }}">← Kembali ke halaman masuk</a>
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const { showToast, initPasswordStrength, initPasswordMatch } = window.ExavroAuth;

        const strength = initPasswordStrength(document.getElementById('passwordField'));
        const match = initPasswordMatch(document.getElementById('resetPasswordForm'));

        document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
            if (strength && strength.getScore() < 4) {
                e.preventDefault();
                showToast('warning', 'Pilih password yang lebih kuat dulu ya.', 'Password lemah');
                return;
            }
            if (match && !match.matches()) {
                e.preventDefault();
                showToast('error', 'Konfirmasi password belum cocok.', 'Tidak cocok');
                return;
            }
            window.ExavroAuth.setButtonLoading(document.getElementById('updateButton'), true);
        });

        @if ($errors->any())
            @foreach ($errors->all() as $error) showToast('error', "{{ $error }}"); @endforeach
        @endif
    });
</script>
@endsection