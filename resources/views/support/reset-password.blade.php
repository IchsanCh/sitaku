@extends('support.layout')

@section('title', 'Reset Password - Support')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-sm">

        <div class="text-center mb-7">
            <span class="inline-flex w-11 h-11 rounded-xl bg-primary text-primary-content items-center justify-center font-display font-semibold text-lg mb-4">S</span>
            <h1 class="font-display font-semibold text-[1.6rem] leading-tight">Reset Password</h1>
            <p class="text-sm text-base-content/55 mt-1.5">Masukin password baru buat akun kamu.</p>
        </div>

        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body p-7">

                @if ($errors->any())
                    <div class="alert alert-error mb-4 text-sm py-2.5"><span>{{ $errors->first() }}</span></div>
                @endif

                <form method="POST" action="{{ route('support.password.update') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div>
                        <label class="label pb-1.5"><span class="label-text font-medium text-sm">Email</span></label>
                        <input type="email" name="email" value="{{ old('email', $email) }}" class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label class="label pb-1.5"><span class="label-text font-medium text-sm">Password Baru</span></label>
                        <input type="password" name="password" class="input input-bordered w-full" required minlength="8">
                    </div>
                    <div>
                        <label class="label pb-1.5"><span class="label-text font-medium text-sm">Konfirmasi Password</span></label>
                        <input type="password" name="password_confirmation" class="input input-bordered w-full" required minlength="8">
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection