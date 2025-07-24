@extends('user.layout')

@section('title', 'Not Found')

@section('content')
    <section class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-xl">
                {{-- SVG Image --}}
                <div class="mb-8">
                    <img src="{{ asset('image/404.svg') }}" alt="Ilustrasi 404" class="mx-auto w-60">
                </div>

                {{-- Error Number --}}
                <div class="text-9xl font-black text-error mb-4 animate-bounce">
                    404
                </div>

                {{-- Main Heading --}}
                <h1 class="text-4xl font-bold text-base-content mb-4">
                    Waduh... kamu nyasar 😅
                </h1>

                {{-- Description --}}
                <p class="text-lg text-base-content/80 mb-8 leading-relaxed">
                    Halaman yang kamu cari mungkin pindah, hilang, atau mungkin nggak pernah ada dari awal 🫠
                </p>

                {{-- Action Button --}}
                <div class="mb-8">
                    <a href="{{ url('/') }}" class="btn btn-error btn-lg gap-2 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Balik Aja ke Beranda
                    </a>
                </div>

                {{-- Additional Help Text --}}
                <div class="alert alert-info shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="stroke-current shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm">
                        Atau mungkin kamu salah ketik link-nya? Coba dicek lagi deh~ 😜
                    </span>
                </div>
            </div>
        </div>
    </section>
@endsection
