@extends('support.layout')

@section('title', 'Login Support')

@if (config('services.recaptcha.site_key'))
    @push('head-scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endpush
@endif

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="card w-full max-w-sm bg-base-100 shadow-2xl">
        <div class="card-body">
            <h1 class="text-xl font-bold mb-1">Login Admin Support</h1>
            <p class="text-sm text-base-content/60 mb-6">Khusus buat agent live support instansi.</p>

            @if ($errors->any())
                <div class="alert alert-error mb-4 text-sm">
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form id="supportLoginForm" method="POST" action="{{ route('support.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full" required autofocus>
                </div>
                <div>
                    <label class="label"><span class="label-text">Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full" required>
                </div>
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="checkbox" name="remember" class="checkbox checkbox-sm">
                    <span class="label-text">Ingat saya</span>
                </label>
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                <button type="submit" id="supportLoginBtn" class="btn btn-primary w-full">
                    <span id="supportLoginBtnText">Masuk</span>
                    <span id="supportLoginBtnLoading" class="loading loading-spinner loading-sm hidden"></span>
                </button>
            </form>
            <div class="pt-2 text-center">
                <a href="{{ route('support.password.request') }}" class="text-sm text-base-content/60 hover:underline">Lupa password?</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const supportLoginForm = document.getElementById('supportLoginForm');
    const supportLoginBtn = document.getElementById('supportLoginBtn');
    const supportLoginBtnText = document.getElementById('supportLoginBtnText');
    const supportLoginBtnLoading = document.getElementById('supportLoginBtnLoading');

    supportLoginForm.addEventListener('submit', function (e) {
        @if (config('services.recaptcha.site_key'))
            e.preventDefault();
            supportLoginBtn.disabled = true;
            supportLoginBtnText.classList.add('hidden');
            supportLoginBtnLoading.classList.remove('hidden');

            grecaptcha.ready(function () {
                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'login' })
                    .then(function (token) {
                        document.getElementById('g-recaptcha-response').value = token;
                        supportLoginForm.submit();
                    })
                    .catch(function () {
                        supportLoginBtn.disabled = false;
                        supportLoginBtnText.classList.remove('hidden');
                        supportLoginBtnLoading.classList.add('hidden');
                    });
            });
        @else
            supportLoginBtn.disabled = true;
            supportLoginBtnText.classList.add('hidden');
            supportLoginBtnLoading.classList.remove('hidden');
        @endif
    });
</script>
@endsection