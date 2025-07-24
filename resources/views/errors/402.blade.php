@extends('user.layout')

@section('title', 'Pembayaran Diperlukan')

@section('content')
    <section class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-xl font-semibold">

                {{-- Ilustrasi --}}
                <div class="mb-8">
                    <img src="{{ asset('image/warning.svg') }}" alt="Bayar Dulu Kak" class="mx-auto w-60">
                </div>

                {{-- Kode Error --}}
                <div class="text-9xl font-black text-error mb-4">
                    402
                </div>

                {{-- Judul --}}
                <h1 class="text-4xl font-bold text-base-content mb-4">
                    Ehh... Kak Belum Bayar Nih 😅
                </h1>

                {{-- Pesan lucu --}}
                <p class="text-lg text-base-content/80 mb-6 leading-relaxed">
                    Waduh, fitur ini cuma buat member premium ya kak~ 💳<br>
                    Jangan sedih, kamu masih bisa nikmatin fitur gratis kok.<br>
                    Tapi kalau mau full akses, yuk traktir kita secangkir kopi ☕😉
                </p>

                {{-- Tombol Aksi --}}
                <a href="/"
                    class="inline-block bg-error text-white px-6 py-3 rounded-lg shadow hover:bg-red-500 transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>
@endsection
