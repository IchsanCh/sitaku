@extends('support.layout')

@section('title', 'Lupa Password - Support')

@if (config('services.recaptcha.site_key'))
    @push('head-scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endpush
@endif

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="card w-full max-w-sm bg-base-100 shadow-2xl">
        <div class="card-body">
            <h1 class="text-xl font-bold mb-1">Lupa Password</h1>
            <p class="text-sm text-base-content/60 mb-6">Masukkan email akun admin support kamu, link reset bakal dikirim ke situ.</p>

            @if (session('status'))
                <div class="alert alert-success mb-4 text-sm"><span>{{ session('status') }}</span></div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error mb-4 text-sm"><span>{{ $errors->first() }}</span></div>
            @endif

            <form id="forgotForm" method="POST" action="{{ route('support.password.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full" required autofocus>
                </div>
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                <button type="submit" id="forgotBtn" class="btn btn-primary w-full">
                    <span id="forgotBtnText">Kirim Link Reset</span>
                    <span id="forgotBtnLoading" class="loading loading-spinner loading-sm hidden"></span>
                </button>
            </form>
            <div class="pt-2 text-center">
                <a href="{{ route('support.login') }}" class="text-sm text-base-content/60 hover:underline">← Kembali ke login</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const forgotForm = document.getElementById('forgotForm');
    const forgotBtn = document.getElementById('forgotBtn');
    const forgotBtnText = document.getElementById('forgotBtnText');
    const forgotBtnLoading = document.getElementById('forgotBtnLoading');

    forgotForm.addEventListener('submit', function (e) {
        @if (config('services.recaptcha.site_key'))
            e.preventDefault();
            forgotBtn.disabled = true;
            forgotBtnText.classList.add('hidden');
            forgotBtnLoading.classList.remove('hidden');

            grecaptcha.ready(function () {
                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'forgot_password' })
                    .then(function (token) {
                        document.getElementById('g-recaptcha-response').value = token;
                        forgotForm.submit();
                    })
                    .catch(function () {
                        forgotBtn.disabled = false;
                        forgotBtnText.classList.remove('hidden');
                        forgotBtnLoading.classList.add('hidden');
                    });
            });
        @endif
    });
</script>
@endsection