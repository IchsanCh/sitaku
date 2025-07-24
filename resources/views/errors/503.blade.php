@extends('user.layout')

@section('title', 'Maintenance Mode')

@section('content')
    <section class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-xl font-semibold">
                {{-- SVG Maintenance Illustration --}}
                <div class="mb-8">
                    <img src="{{ asset('image/bugfix.svg') }}" alt="Maintenance Illustration" class="mx-auto w-60">
                </div>

                {{-- Error Code --}}
                <div class="text-9xl font-black text-warning mb-4">
                    503
                </div>

                {{-- Main Title --}}
                <h1 class="text-4xl font-bold text-base-content mb-4">
                    Lagi disiapin yang terbaik nih ✨
                </h1>

                {{-- Description --}}
                <p class="text-lg text-base-content/80 mb-6 leading-relaxed">
                    Website-nya lagi di-tune up dulu ya, mungkin sedang ada update fitur, perbaikan sistem, atau nambal bug
                    yang nyelip 🐞<br>
                    Sabar sebentar, nanti juga balik lagi lebih kece!
                </p>

                {{-- Button --}}
                <a href="{{ url('/') }}"
                    class="inline-block bg-warning text-white px-6 py-3 rounded-lg shadow hover:bg-yellow-600 transition">
                    🔁 Coba Lagi Nanti
                </a>

                {{-- Optional Alert --}}
                <div class="mt-6 alert alert-info shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="stroke-current shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm">
                        Makasih banyak udah sabar nunggu ya. Tim kami lagi ngebut biar kamu bisa pake lagi secepat mungkin!
                        🚀
                    </span>
                </div>
            </div>
        </div>
    </section>
@endsection
