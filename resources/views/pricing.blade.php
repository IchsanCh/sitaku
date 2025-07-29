<x-layout>
    @section('title', 'Pricing')
    @section('meta_description',
        'Lihat paket harga Sitaku yang fleksibel untuk berbagai kebutuhan instansi. Mulai dari
        notifikasi otomatis harian hingga sistem pelaporan terjadwal.')
    @section('og_description',
        'Temukan paket harga Sitaku yang cocok untuk instansimu. Layanan notifikasi WhatsApp
        otomatis yang cepat, tepat, dan terintegrasi dengan API instansi.')

        <section class="min-h-screen bg-base-100 py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Header Section -->
                <div class="text-center mb-16">
                    <h1 class="text-3xl lg:text-6xl font-black c1 mb-8">
                        Paket Langganan Sitaku
                    </h1>
                    <p class="text-xl font-semibold lg:text-2xl mb-8 text-black max-w-3xl mx-auto leading-relaxed">
                        Sesuaikan paket dengan kebutuhan instansi Anda. Semua paket mendukung notifikasi WhatsApp otomatis
                        dan integrasi sistem eksternal.
                    </p>
                </div>

                <!-- Pricing Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    @forelse ($packages as $index => $p)
                        <div class="group">
                            <div
                                class="card bg-base-100 shadow-xl border border-base-300 hover:shadow-2xl hover:border-primary/30 transition-all duration-300 group-hover:-translate-y-2 relative overflow-hidden">
                                <div class="card-body p-8">
                                    <!-- Package Icon -->
                                    <div class="w-16 h-16 bgc5 rounded-2xl flex items-center justify-center mb-4 mx-auto">
                                        <span class="text-2xl">
                                            <svg class="w-10 h-10 text-white inline-block" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </span>
                                    </div>

                                    <h2 class="card-title text-3xl font-bold justify-center mb-2">{{ $p->name }}</h2>

                                    <!-- Price -->
                                    <div class="text-center mb-6">
                                        <div class="text-2xl lg:text-3xl font-black c2 mb-2">
                                            Rp {{ number_format($p->price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-base text-base-content/80 font-medium">
                                            per {{ $p->duration_days }} hari
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-base-content/80 text-center mb-8 leading-relaxed">
                                        {{ $p->description }}
                                    </p>

                                    <!-- Features -->
                                    <div class="space-y-3 mb-8">
                                        <div class="flex items-center gap-3">
                                            <div class="w-5 h-5 bg-success rounded-full flex items-center justify-center">
                                                <svg class="w-3 h-3 text-success-content" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm text-base-content/70">Notifikasi WhatsApp Otomatis</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-5 h-5 bg-success rounded-full flex items-center justify-center">
                                                <svg class="w-3 h-3 text-success-content" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm text-base-content/70">Integrasi API Sistem</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-5 h-5 bg-success rounded-full flex items-center justify-center">
                                                <svg class="w-3 h-3 text-success-content" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm text-base-content/70">Support 24/7</span>
                                        </div>
                                    </div>

                                    <!-- CTA Button -->
                                    <div class="card-actions justify-center">
                                        <a href="/billing" title="Pilih Paket {{ $p->name }}"
                                            class="btn san btn-lg w-full font-bold group-hover:scale-105 transition-transform">
                                            Pilih Paket Ini
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="card bg-base-100 shadow-xl border border-base-300 max-w-md mx-auto">
                                <div class="card-body text-center p-12">
                                    <div
                                        class="w-20 h-20 bg-warning rounded-full flex items-center justify-center mb-6 mx-auto">
                                        <span class="text-4xl">
                                            <svg class="w-10 h-10 text-white inline-block" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </span>
                                    </div>
                                    <h2 class="card-title text-2xl font-bold justify-center mb-4">Tidak ada paket tersedia
                                    </h2>
                                    <p class="text-base-content/80 font-semibold mb-6">Silakan hubungi admin untuk informasi
                                        lebih lanjut.
                                    </p>
                                    <a href="https://wa.me/6285175112406" target="_blank" title="Hubungi Admin"
                                        class="btn btn-outline btn-primary">
                                        <i class="fa-brands fa-whatsapp"></i> Hubungi Admin</a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- CTA Section -->
                <div class="text-center">
                    <div class="bgc5 p-8 lg:p-12" style="border-radius: 1.5rem;">
                        <h3 class="text-3xl lg:text-4xl font-bold mb-4 text-white">Siap untuk memulai?</h3>
                        <p class="text-lg text-white mb-8 max-w-2xl mx-auto font-semibold">
                            Jadilah bagian dari instansi yang beralih ke notifikasi otomatis bersama Sitaku.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="/login" title="Mulai Langganan Sekarang"
                                class="btn btn-success px-10 font-bold shadow-lg hover:shadow-xl transition-shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                </svg>
                                Mulai Langganan Sekarang
                            </a>
                            <a href="https://wa.me/6285175112406" target="_blank" class="btn san px-8"
                                title="Konsultasi Gratis">
                                <i class="fa-brands fa-whatsapp"></i> Konsultasi Gratis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-layout>
