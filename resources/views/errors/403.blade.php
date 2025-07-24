@extends('user.layout')

@section('title', 'Akses Ditolak')

@section('content')
    <section class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-xl font-semibold">

                {{-- Ilustrasi opsional --}}
                <div class="mb-8">
                    <img src="{{ asset('image/forbidden.svg') }}" alt="Akses Ditolak" class="mx-auto w-60">
                </div>

                {{-- Kode Error --}}
                <div class="text-9xl font-black text-error mb-4">
                    403
                </div>

                {{-- Judul --}}
                <h1 class="text-4xl font-bold text-base-content mb-4">
                    Eits, Dilarang Masuk!
                </h1>

                {{-- Deskripsi Bercanda --}}
                <p class="text-lg text-base-content/80 mb-6 leading-relaxed">
                    Ehh kakak mau ngapain hayo... 👀<br>
                    Ini halaman rahasia khusus admin lho, wleee~ 🙃<br>
                    Balik dulu gih sebelum ketahuan sistem 😏
                </p>

                {{-- Tombol Aksi --}}
                <a href="{{ url('/') }}"
                    class="inline-block bg-error text-white px-6 py-3 rounded-lg shadow hover:bg-red-600 transition">
                    ⬅️ Balik ke Halaman Utama
                </a>
            </div>
        </div>
    </section>
@endsection
