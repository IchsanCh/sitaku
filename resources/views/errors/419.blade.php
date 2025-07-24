@extends('user.layout')

@section('title', 'Session Expired')

@section('content')
    <section class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-xl font-semibold">

                {{-- Ilustrasi bisa kamu ganti pakai gambar lucu AFK --}}
                <div class="mb-8">
                    <img src="{{ asset('image/warning.svg') }}" alt="Session Expired" class="mx-auto w-60">
                </div>

                {{-- Kode Error --}}
                <div class="text-9xl font-black text-warning mb-4">
                    419
                </div>

                {{-- Judul --}}
                <h1 class="text-4xl font-bold text-base-content mb-4">
                    Halaman Kadaluarsa
                </h1>

                {{-- Deskripsi Bercanda --}}
                <p class="text-lg text-base-content/80 mb-6 leading-relaxed">
                    Waduh... ditinggal AFK ya kak? 😅<br>
                    Session-nya udah expired, webnya ngambek duluan.<br>
                    Coba refresh dulu yaa~
                </p>

                {{-- Tombol Aksi --}}
                <a href="{{ url()->previous() }}"
                    class="inline-block bg-warning text-white px-6 py-3 rounded-lg shadow hover:bg-yellow-600 transition">
                    🔁 Refresh Halaman
                </a>
            </div>
        </div>
    </section>
@endsection
