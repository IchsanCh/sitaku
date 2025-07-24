@extends('user.layout')

@section('title', 'Belum Login Nih!')

@section('content')
    <section class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center font-semibold">
            <div class="max-w-xl">

                {{-- Ilustrasi --}}
                <div class="mb-8">
                    <img src="{{ asset('image/login.svg') }}" alt="Belum Login" class="mx-auto w-60">
                </div>

                {{-- Kode Error --}}
                <div class="text-9xl font-black text-warning mb-4">
                    401
                </div>

                {{-- Judul --}}
                <h1 class="text-4xl font-bold text-base-content mb-4">
                    Ehh Belum Login Kak!
                </h1>

                {{-- Deskripsi Bercanda --}}
                <p class="text-lg text-base-content/80 mb-6 leading-relaxed">
                    Waduhh kak, kamu nyasar ke tempat yang butuh izin dulu~ 😅<br>
                    Coba login dulu deh, siapa tau kamu emang punya akses 😉<br>
                    Jangan asal nyelonong yaa...
                </p>

                {{-- Tombol Aksi --}}
                <a href="{{ route('login') }}"
                    class="inline-block bg-warning text-white px-6 py-3 rounded-lg shadow hover:bg-yellow-500 transition">
                    🔐 Login Dulu Yuk!
                </a>
            </div>
        </div>
    </section>
@endsection
