@extends('user.layout')

@section('title', 'Verifikasi OTP')
@section('meta_description', 'Verifikasi kode OTP untuk melanjutkan proses pendaftaran akun Exavro.')
@section('og_description', 'Masukkan kode verifikasi OTP yang telah dikirim ke email Anda.')

@section('content')
<div class="xv-auth-shell">
    <div class="xv-auth-wrap">
        <a href="{{ route('home') }}" class="xv-auth-brand" title="Exavro">
            <img src="{{ asset('image/logoLotus.png') }}" alt="">
            <span class="xv-wordmark">EXAVRO</span>
        </a>

        <div class="xv-auth-card">
            <div class="text-center mb-6">
                <h1 class="xv-auth-title">Verifikasi email Anda</h1>
                <p class="xv-auth-subtitle mt-2">Kode verifikasi sudah dikirim ke</p>
                <p class="font-semibold mt-0.5" style="color: var(--xv-accent)">{{ $email }}</p>
            </div>

            <form method="POST" action="{{ route('signup.verify') }}" id="otpForm" class="space-y-5">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="xv-field">
                    <label class="xv-label" for="otp">Kode Verifikasi</label>
                    <input type="text" id="otp" name="otp" required maxlength="6" pattern="[0-9]{6}"
                        inputmode="numeric" autocomplete="one-time-code" placeholder="000000" data-autofocus
                        class="xv-input xv-otp-input @error('otp') is-invalid @enderror">
                    @error('otp') <p class="xv-field-error text-center">{{ $message }}</p> @enderror
                </div>

                <button type="submit" id="verifyButton" class="xv-btn xv-btn-accent xv-btn-block">
                    <span data-btn-label>Verifikasi Kode</span>
                    <span data-btn-spinner class="xv-spinner hidden"></span>
                </button>
            </form>

            <div class="xv-divider">atau</div>

            <div class="text-center">
                <p class="xv-auth-subtitle mb-3">Belum menerima kode?</p>

                <div class="xv-otp-timer mb-3" id="timerDisplay">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Kirim ulang dalam <strong id="countdown">60</strong> detik
                </div>

                <form method="GET" action="{{ route('signup.otp.resend') }}" id="resendForm">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit" id="resendButton" class="xv-btn xv-btn-outline-ink" style="height: 2.25rem; padding: 0 1rem; font-size: 0.85rem;" disabled>
                        <span data-btn-label>Kirim Ulang Kode</span>
                        <span data-btn-spinner class="xv-spinner hidden" style="width:0.9rem;height:0.9rem;"></span>
                    </button>
                </form>
            </div>

            <p class="xv-auth-footnote mt-6">
                <a href="{{ route('login') }}">← Kembali ke halaman masuk</a>
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const { showToast, initOtpInput, initResendCountdown } = window.ExavroAuth;

        const form = document.getElementById('otpForm');
        const input = document.getElementById('otp');

        initOtpInput({ input, form });

        form.addEventListener('submit', function (e) {
            if (input.value.length !== 6) {
                e.preventDefault();
                showToast('error', 'Masukkan kode 6 digit yang lengkap.', 'Kode belum lengkap');
            }
        });

        const countdown = initResendCountdown({
            button: document.getElementById('resendButton'),
            countdownEl: document.getElementById('countdown'),
            seconds: 60,
        });

        document.getElementById('resendForm').addEventListener('submit', function () {
            setTimeout(() => countdown.restart(), 800);
        });

        @if (session('error')) showToast('error', "{{ session('error') }}"); @endif
        @if (session('success'))
            showToast('success', "{{ session('success') }}");
            countdown.restart();
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error) showToast('error', "{{ $error }}"); @endforeach
        @endif
    });
</script>
@endsection