@extends('support.layout')

@section('title', 'Lupa Password - Support')

@if (config('services.recaptcha.site_key'))
    @push('head-scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endpush
@endif

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-sm">

        <div class="text-center mb-7">
            <span class="inline-flex w-11 h-11 rounded-xl bg-primary text-primary-content items-center justify-center font-display font-semibold text-lg mb-4">S</span>
            <h1 class="font-display font-semibold text-[1.6rem] leading-tight">Lupa Password</h1>
            <p class="text-sm text-base-content/55 mt-1.5 leading-relaxed">Masukkan email akun kamu, link reset bakal dikirim ke situ.</p>
        </div>

        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body p-7">

                @if (session('status'))
                    <div class="alert alert-success mb-4 text-sm py-2.5"><span>{{ session('status') }}</span></div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-error mb-4 text-sm py-2.5"><span>{{ $errors->first() }}</span></div>
                @endif

                <form id="forgotForm" method="POST" action="{{ route('support.password.email') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="label pb-1.5"><span class="label-text font-medium text-sm">Email</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full" placeholder="nama@instansi.go.id" required autofocus>
                    </div>
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                    <button type="submit" id="forgotBtn" class="btn btn-primary w-full gap-2">
                        <span id="forgotBtnText">Kirim Link Reset</span>
                        <span id="forgotBtnLoading" class="loading loading-spinner loading-sm hidden"></span>
                    </button>
                </form>

                <div class="pt-4 text-center">
                    <a href="{{ route('support.login') }}" class="text-sm text-base-content/55 hover:text-primary transition-colors">← Kembali ke login</a>
                </div>
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