@extends('support.layout')

@section('title', 'Reset Password - Support')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="card w-full max-w-sm bg-base-100 shadow-2xl">
        <div class="card-body">
            <h1 class="text-xl font-bold mb-1">Reset Password</h1>
            <p class="text-sm text-base-content/60 mb-6">Masukin password baru buat akun admin support kamu.</p>

            @if ($errors->any())
                <div class="alert alert-error mb-4 text-sm"><span>{{ $errors->first() }}</span></div>
            @endif

            <form method="POST" action="{{ route('support.password.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" value="{{ old('email', $email) }}" class="input input-bordered w-full" required>
                </div>
                <div>
                    <label class="label"><span class="label-text">Password Baru</span></label>
                    <input type="password" name="password" class="input input-bordered w-full" required minlength="8">
                </div>
                <div>
                    <label class="label"><span class="label-text">Konfirmasi Password</span></label>
                    <input type="password" name="password_confirmation" class="input input-bordered w-full" required minlength="8">
                </div>
                <button type="submit" class="btn btn-primary w-full">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection