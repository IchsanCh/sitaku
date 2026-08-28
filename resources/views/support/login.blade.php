@extends('support.layout')

@section('title', 'Login Support')

@if (config('services.recaptcha.site_key'))
    @push('head-scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endpush
@endif

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-sm">

        <div class="text-center mb-7">
            <span class="inline-flex w-11 h-11 rounded-xl bg-primary text-primary-content items-center justify-center font-display font-semibold text-lg mb-4">EX</span>
            <h1 class="font-display font-semibold text-[1.7rem] leading-tight">Help Desk</h1>
            <p class="text-sm text-base-content/55 mt-1">Masuk sebagai admin support instansi</p>
        </div>

        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body p-7">

                @if ($errors->any())
                    <div class="alert alert-error mb-4 text-sm py-2.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form id="supportLoginForm" method="POST" action="{{ route('support.login.submit') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="label pb-1.5"><span class="label-text font-medium text-sm">Email</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full" placeholder="nama@instansi.go.id" required autofocus>
                    </div>
                    <div>
                        <label class="label pb-1.5"><span class="label-text font-medium text-sm">Password</span></label>
                        <input type="password" name="password" class="input input-bordered w-full" placeholder="••••••••" required>
                    </div>
                    <label class="label cursor-pointer justify-start gap-2 px-0">
                        <input type="checkbox" name="remember" class="checkbox checkbox-sm">
                        <span class="label-text text-sm">Ingat saya</span>
                    </label>
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                    <button type="submit" id="supportLoginBtn" class="btn btn-primary w-full gap-2">
                        <span id="supportLoginBtnText">Masuk</span>
                        <span id="supportLoginBtnLoading" class="loading loading-spinner loading-sm hidden"></span>
                    </button>
                </form>

                <div class="pt-4 text-center">
                    <a href="{{ route('support.password.request') }}" class="text-sm text-base-content/55 hover:text-primary transition-colors">Lupa password?</a>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-base-content/35 mt-6 font-mono">{{ config('app.name') }} · Panel Admin Support</p>
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