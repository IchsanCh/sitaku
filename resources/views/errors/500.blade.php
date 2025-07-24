@extends('user.layout')

@section('title', 'Internal Server Error')

@section('content')
    <section class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-xl font-semibold">
                {{-- SVG Server Stress atau Debugging --}}
                <div class="mb-8">
                    <img src="{{ asset('image/serverdown.svg') }}" alt="Ilustrasi Server Error" class="mx-auto w-60">
                </div>

                {{-- Kode Error --}}
                <div class="text-9xl font-black text-error mb-4">
                    500
                </div>

                {{-- Judul --}}
                <h1 class="text-4xl font-bold text-base-content mb-4">
                    Santai... Lagi dicek sama tim 😅
                </h1>

                {{-- Deskripsi --}}
                <p class="text-lg text-base-content/80 mb-6 leading-relaxed">
                    Ada error internal di server. Bisa jadi bug, bisa juga servernya baru bangun dan belum ngopi ☕.
                    <br />
                    Kami sedang investigasi dengan penuh cinta dan console log ❤️
                </p>

                {{-- Tombol Ajak Balik --}}
                <a href="{{ url('/') }}"
                    class="inline-block bg-error text-white px-6 py-3 rounded-lg shadow hover:bg-error-content transition duration-200">
                    🔄 Coba Lagi Nanti
                </a>

                {{-- Note Kocak Tapi Kalem --}}
                <div class="mt-6 alert alert-info shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="stroke-current shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-bold">
                        Tenang aja, nggak usah refresh terus-terusan, nanti malah disangka DDoS 😜
                    </span>
                </div>
            </div>
        </div>
    </section>
@endsection
