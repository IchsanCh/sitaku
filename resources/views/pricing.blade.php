<x-layout>
    @section('title', 'Pricing')
    @section('meta_description',
        'Lihat paket harga Sitaku yang fleksibel untuk berbagai kebutuhan instansi. Mulai dari
        notifikasi otomatis harian hingga sistem pelaporan terjadwal.')
    @section('og_description',
        'Temukan paket harga Sitaku yang cocok untuk instansimu. Layanan notifikasi WhatsApp
        otomatis yang cepat, tepat, dan terintegrasi dengan API instansi.')

        <section class="relative bg-base-100 py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
            {{-- Aksen radial teal tunggal di belakang header -- bukan dekorasi berulang --}}
            <div class="pointer-events-none absolute -top-40 left-1/2 -translate-x-1/2 w-[640px] h-[640px] rounded-full opacity-40 blur-3xl"
                style="background: radial-gradient(circle, #30e3ca 0%, transparent 70%);"></div>

            <div class="max-w-6xl mx-auto relative">
                <!-- Header -->
                <div class="text-center mb-14 max-w-2xl mx-auto">
                    <span class="inline-block text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-5"
                        style="color:#11999e; background-color:#e4f9f5;" data-aos="fade-up" data-aos-duration="600">
                        Paket Langganan
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.05] mb-5"
                        style="color:#40514e;" data-aos="fade-up" data-aos-duration="700">
                        Satu paket buat<br class="hidden md:block"> tiap tahap instansi Anda
                    </h1>
                    <p class="text-lg text-base-content/60 leading-relaxed" data-aos="fade-up" data-aos-duration="800">
                        Semua paket mendukung notifikasi WhatsApp otomatis dan integrasi sistem eksternal —
                        tinggal sesuaikan sama kebutuhan instansi Anda.
                    </p>
                </div>

                <!-- Pricing Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch mb-20">
                    @php $topPrice = $packages->max('price'); @endphp
                    @forelse ($packages as $index => $p)
                        @php $isFeatured = $topPrice > 0 && (int) $p->price === (int) $topPrice; @endphp
                        <div class="relative flex flex-col h-full rounded-2xl overflow-hidden border transition-all duration-300 hover:-translate-y-1.5
                                {{ $isFeatured ? 'border-transparent shadow-2xl md:scale-[1.04]' : 'border-base-300 bg-base-100 shadow-sm hover:shadow-xl' }}"
                            @if ($isFeatured) style="background: linear-gradient(180deg, #e4f9f5 0%, #ffffff 55%);" @endif
                            data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ $index * 80 }}">

                            <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #11999e, #30e3ca);"></div>

                            @if ($isFeatured)
                                <span class="absolute top-5 right-5 text-[11px] font-bold uppercase tracking-wide text-white px-3 py-1 rounded-full"
                                    style="background-color:#236961;">
                                    Paling Lengkap
                                </span>
                            @endif

                            <div class="p-8 flex flex-col flex-1">
                                @if ($p->tier)
                                    <span class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#11999e;">
                                        {{ $p->tier->name }}
                                    </span>
                                @endif

                                <h2 class="text-2xl font-bold mb-2" style="color:#40514e;">{{ $p->name }}</h2>

                                @if ($p->description)
                                    <p class="text-sm text-base-content/60 mb-6 leading-relaxed">{{ $p->description }}</p>
                                @endif

                                <div class="mb-7 pb-7 border-b border-base-300/70">
                                    <span class="text-3xl lg:text-4xl font-black" style="color:#40514e;">
                                        Rp {{ number_format($p->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-base-content/50">/ {{ $p->duration_days }} hari</span>
                                </div>

                                <div class="space-y-3 flex-1 mb-8">
                                    @include('partials.tier-features', ['tier' => $p->tier])
                                </div>

                                <a href="/billing" title="Pilih Paket {{ $p->name }}"
                                    class="btn w-full font-bold border-0 text-white transition-colors"
                                    style="background-color: {{ $isFeatured ? '#11999e' : '#40514e' }};"
                                    onmouseover="this.style.backgroundColor='#236961'"
                                    onmouseout="this.style.backgroundColor='{{ $isFeatured ? '#11999e' : '#40514e' }}'">
                                    Pilih Paket Ini
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full" data-aos="fade-up" data-aos-duration="700">
                            <div class="max-w-md mx-auto text-center rounded-2xl border border-base-300 p-12">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto"
                                    style="background-color:#e4f9f5;">
                                    <svg class="w-8 h-8" style="color:#11999e;" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold mb-3" style="color:#40514e;">Tidak ada paket tersedia</h2>
                                <p class="text-base-content/60 mb-6">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Admin"
                                    class="btn btn-outline" style="border-color:#11999e; color:#11999e;">
                                    <i class="fa-brands fa-whatsapp"></i> Hubungi Admin
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- CTA Section -->
                <div class="rounded-3xl p-10 lg:p-14 text-center bgc5" data-aos="fade-up" data-aos-duration="700">
                    <h3 class="text-3xl lg:text-4xl font-bold mb-3 text-white">Siap untuk memulai?</h3>
                    <p class="text-white/80 mb-8 max-w-xl mx-auto">
                        Jadilah bagian dari instansi yang beralih ke notifikasi otomatis bersama Sitaku.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="/login" title="Mulai Langganan Sekarang"
                            class="btn px-10 font-bold border-0 shadow-lg hover:shadow-xl transition-shadow text-white"
                            style="background-color:#11999e;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                            </svg>
                            Mulai Langganan Sekarang
                        </a>
                        <a href="https://wa.me/6285175112406" target="_blank" class="btn px-8 border-white/30 text-white"
                            style="background-color:transparent;" title="Konsultasi Gratis">
                            <i class="fa-brands fa-whatsapp"></i> Konsultasi Gratis
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </x-layout>