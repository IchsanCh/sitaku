<x-layout>
    @section('title', 'Pricing')
    @section('meta_description',
        'Lihat paket harga Exavro yang fleksibel untuk berbagai kebutuhan instansi. Mulai dari
        notifikasi otomatis harian hingga sistem pelaporan terjadwal.')
    @section('og_description',
        'Temukan paket harga Exavro yang cocok untuk instansimu. Layanan notifikasi WhatsApp
        otomatis yang cepat, tepat, dan terintegrasi dengan API instansi.')

        <section class="relative py-20 px-4 sm:px-6 lg:px-8 overflow-hidden" style="background: var(--xv-paper);">
            {{-- Aksen radial oranye tunggal di belakang header -- bukan dekorasi berulang --}}
            <div class="xv-radial-glow -top-40 left-1/2 -translate-x-1/2 w-[640px] h-[640px]"></div>

            <div class="max-w-6xl mx-auto relative">
                <!-- Header -->
                <div class="text-center mb-14 max-w-2xl mx-auto" data-xv-reveal>
                    <h1 class="xv-display text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight leading-[1.05] mb-5"
                        style="color: var(--xv-text);">
                        Solusi yang tumbuh<br class="hidden md:block"> bersama kebutuhan anda
                    </h1>
                    <p class="text-lg leading-relaxed" style="color: var(--xv-text-soft);">
                        Pilih paket layanan yang fleksibel dan sesuaikan dengan kebutuhan notifikasi instansi Anda.
                    </p>
                </div>

                <!-- Pricing Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch mb-20" data-xv-stagger-group>
                    @php $topPrice = $packages->max('price'); @endphp
                    @forelse ($packages as $index => $p)
                        @php $isFeatured = $topPrice > 0 && (int) $p->price === (int) $topPrice; @endphp
                        <div class="xv-price-card {{ $isFeatured ? 'xv-price-card--featured' : '' }}" data-xv-stagger-item>

                            <div class="xv-price-bar"></div>

                            @if ($isFeatured)
                                <span class="xv-price-badge">Paling Lengkap</span>
                            @endif

                            <div class="p-8 flex flex-col flex-1">
                                @if ($p->tier)
                                    <span class="xv-price-tier mb-2">{{ $p->tier->name }}</span>
                                @endif

                                <h2 class="xv-display text-2xl font-bold mb-2" style="color: var(--xv-text);">{{ $p->name }}</h2>

                                @if ($p->description)
                                    <p class="text-sm mb-6 leading-relaxed" style="color: var(--xv-text-soft);">{{ $p->description }}</p>
                                @endif

                                <div class="mb-7 pb-7" style="border-bottom: 1px solid var(--xv-line);">
                                    <span class="xv-display text-3xl lg:text-4xl font-bold" style="color: var(--xv-text);">
                                        Rp {{ number_format($p->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm" style="color: var(--xv-text-soft);">/ {{ $p->duration_days }} hari</span>
                                </div>

                                <div class="space-y-3 flex-1 mb-8">
                                    @include('partials.tier-features', ['tier' => $p->tier])
                                </div>

                                <a href="/billing" title="Pilih Paket {{ $p->name }}"
                                    class="xv-btn w-full {{ $isFeatured ? 'xv-btn-accent' : 'xv-btn-ink' }}">
                                    Pilih Paket Ini
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full" data-xv-reveal>
                            <div class="max-w-md mx-auto text-center rounded-2xl p-12" style="border: 1px solid var(--xv-line);">
                                <div class="xv-empty-icon mb-6 mx-auto">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <h2 class="xv-display text-xl font-bold mb-3" style="color: var(--xv-text);">Tidak ada paket tersedia</h2>
                                <p class="mb-6" style="color: var(--xv-text-soft);">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Admin"
                                    class="xv-btn xv-btn-outline-ink">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.87 9.87 0 004.75 1.21h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2zm0 18.06a8.1 8.1 0 01-4.14-1.13l-.3-.18-3.14.82.84-3.06-.19-.32a8.15 8.15 0 01-1.25-4.28c0-4.49 3.66-8.15 8.16-8.15 4.49 0 8.15 3.66 8.15 8.15 0 4.5-3.66 8.15-8.13 8.15zm4.47-6.1c-.24-.12-1.44-.71-1.66-.79-.22-.08-.38-.12-.55.12-.16.24-.63.79-.77.95-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.02-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.55-1.32-.75-1.81-.2-.48-.4-.41-.55-.42h-.47c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.7 2.6 4.13 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.44-.59 1.64-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.46-.28z" />
                                    </svg>
                                    Hubungi Admin
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- CTA Section -->
                <div class="xv-cta text-center px-8 py-16 lg:px-14 lg:py-16">
                    <div class="relative z-10" data-xv-reveal>
                        <h3 class="xv-display text-3xl lg:text-4xl font-bold mb-3">Siap untuk memulai?</h3>
                        <p class="mb-8 max-w-xl mx-auto" style="color: var(--xv-on-ink-soft);">
                            Jadilah bagian dari instansi yang beralih ke notifikasi otomatis bersama Exavro.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="/login" title="Mulai Langganan Sekarang" class="xv-btn xv-btn-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                </svg>
                                Mulai Langganan Sekarang
                            </a>
                            <a href="https://wa.me/6285175112406" target="_blank" class="xv-btn xv-btn-outline-onink"
                                title="Konsultasi Gratis">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.87 9.87 0 004.75 1.21h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2zm0 18.06a8.1 8.1 0 01-4.14-1.13l-.3-.18-3.14.82.84-3.06-.19-.32a8.15 8.15 0 01-1.25-4.28c0-4.49 3.66-8.15 8.16-8.15 4.49 0 8.15 3.66 8.15 8.15 0 4.5-3.66 8.15-8.13 8.15zm4.47-6.1c-.24-.12-1.44-.71-1.66-.79-.22-.08-.38-.12-.55.12-.16.24-.63.79-.77.95-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.02-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.55-1.32-.75-1.81-.2-.48-.4-.41-.55-.42h-.47c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.7 2.6 4.13 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.44-.59 1.64-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.46-.28z" />
                                </svg>
                                Konsultasi Gratis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-layout>