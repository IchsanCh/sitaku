@extends('user.layout')

@section('title', 'Terlalu Banyak Permintaan')

@section('content')
    <section class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center font-semibold">
            <div class="max-w-xl">
                {{-- SVG Throttle Illustration --}}
                <div class="mb-8">
                    <img src="{{ asset('image/serverdown.svg') }}" alt="Too Many Requests" class="mx-auto w-60">
                </div>

                {{-- Error Code --}}
                <div class="text-9xl font-black text-error mb-4">
                    429
                </div>

                {{-- Main Title --}}
                <h1 class="text-4xl font-bold text-base-content mb-4">
                    Terlalu Banyak Permintaan
                </h1>

                {{-- Description --}}
                <p class="text-lg text-base-content/80 mb-6 leading-relaxed">
                    Waduh... kamu terlalu semangat! 🤯<br>
                    Sistem mendeteksi terlalu banyak permintaan dalam waktu singkat.<br>
                    Coba istirahat sebentar yaa~
                </p>

                {{-- Tips --}}
                <div class="alert alert-warning shadow-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 w-6 h-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm">
                        Kalau masih muncul terus, coba bersihkan data browser atau cache aplikasi kamu ya.
                        Bisa juga restart browser-nya. Kadang sistem inget kamu terlalu aktif 😅
                    </span>
                </div>

                {{-- Button --}}
                <a href="{{ url('/') }}"
                    class="inline-block bg-error text-white px-6 py-3 rounded-lg shadow hover:bg-red-700 transition">
                    🔄 Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>
@endsection
