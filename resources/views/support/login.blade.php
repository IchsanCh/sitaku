@extends('support.layout')

@section('title', 'Login Support')

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

            <form method="POST" action="{{ route('support.login.submit') }}" class="space-y-4">
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
                <button type="submit" class="btn btn-primary w-full">Masuk</button>
            </form>
        </div>
    </div>
</div>
@endsection