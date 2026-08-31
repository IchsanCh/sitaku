<x-layout>
    @section('title', 'Exavro')

    <!-- Hero -->
    <section class="xv-hero">
        <div class="relative z-10 max-w-7xl mx-auto px-8 pt-20 pb-16 lg:pt-28 lg:pb-24">
            <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-12">
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="xv-display text-4xl lg:text-6xl font-bold leading-[1.05] mb-6" data-xv-hero-item>
                        Welcome to Exavro
                    </h1>
                    <p class="text-lg lg:text-xl mb-8 max-w-xl mx-auto lg:mx-0" style="color: var(--xv-on-ink-soft);" data-xv-hero-item>
                        Exavro hadir sebagai sistem notifikasi cerdas untuk mempercepat informasi antara pemohon dan
                        pegawai
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start" data-xv-hero-item>
                        <a href="#fitur" title="feature" class="xv-btn xv-btn-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zM256 120c22.1 0 40 17.9 40 40s-17.9 40-40 40s-40-17.9-40-40s17.9-40 40-40zm48 288c0 8.8-7.2 16-16 16h-64c-8.8 0-16-7.2-16-16v-16c0-8.8 7.2-16 16-16h8v-64h-8c-8.8 0-16-7.2-16-16v-16c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v96h8c8.8 0 16 7.2 16 16v16z" />
                            </svg>
                            Pelajari Lebih Lanjut
                        </a>
                        <a href="/docs/getting-started" title="documentation" class="xv-btn xv-btn-outline-onink">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.708V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                            </svg>
                            Lihat Dokumentasi
                        </a>
                    </div>
                    <p class="mt-6 flex items-center justify-center lg:justify-start gap-2 text-sm" style="color: var(--xv-on-ink-soft);" data-xv-hero-item>
                        <span class="xv-pulse"></span>
                        Notifikasi WhatsApp terkirim real-time, tanpa jeda
                    </p>
                </div>
                <div class="flex-shrink-0" data-xv-hero-item>
                    <img src="{{ asset('image/header.svg') }}" alt="header image" class="w-72 lg:w-96 h-auto" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan / Fitur -->
    <section id="fitur" class="xv-section" style="background: var(--xv-paper);">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-4" data-xv-reveal>
                <h2 class="xv-display text-3xl md:text-4xl font-bold mb-4">
                    Mengapa Memilih Exavro?
                </h2>
                <p class="text-lg max-w-2xl mx-auto" style="color: var(--xv-text-soft);">
                    Solusi modern untuk sistem notifikasi otomatis yang membantu meningkatkan efisiensi dan layanan
                </p>
            </div>

            <div class="xv-feature-list mt-12" data-xv-stagger-group>
                <!-- Fitur 1 -->
                <div class="xv-feature-row" data-xv-stagger-item>
                    <svg class="xv-feature-icon w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 8a6 6 0 1 1 12 0c0 3.5 1 5.5 2 7H4c1-1.5 2-3.5 2-7Z" />
                        <path d="M9.5 19a2.5 2.5 0 0 0 5 0" />
                    </svg>
                    <div>
                        <h3 class="xv-display text-xl font-bold mb-2">Notifikasi Tepat Waktu</h3>
                        <p style="color: var(--xv-text-soft);">
                            Exavro mengirim notifikasi otomatis sesuai tahapan proses langsung, tanpa penundaan.
                        </p>
                    </div>
                    <span class="xv-feature-tag">Real-time</span>
                </div>

                <!-- Fitur 2 -->
                <div class="xv-feature-row" data-xv-stagger-item>
                    <svg class="xv-feature-icon w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 12a8 8 0 0 1 13.9-5.4M20 12a8 8 0 0 1-13.9 5.4" />
                        <path d="M17 3v4h-4M7 21v-4h4" />
                    </svg>
                    <div>
                        <h3 class="xv-display text-xl font-bold mb-2">Otomatis &amp; Terkelola</h3>
                        <p style="color: var(--xv-text-soft);">
                            Seluruh pengingat dan pemberitahuan dikelola otomatis dari data sistem. Tanpa input manual,
                            tanpa repot.
                        </p>
                    </div>
                    <span class="xv-feature-tag">Smart Notification System</span>
                </div>

                <!-- Fitur 3 -->
                <div class="xv-feature-row" data-xv-stagger-item>
                    <svg class="xv-feature-icon w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3Z" />
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                    <div>
                        <h3 class="xv-display text-xl font-bold mb-2">Privasi &amp; Keamanan</h3>
                        <p style="color: var(--xv-text-soft);">
                            Sistem Exavro dilengkapi autentikasi aman dan proteksi data, menjaga setiap informasi tetap
                            rahasia.
                        </p>
                    </div>
                    <span class="xv-feature-tag">Enterprise Grade</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="xv-section" style="background: var(--xv-paper);">
        <div class="max-w-5xl mx-auto px-4">
            <div class="xv-cta text-center px-8 py-16 lg:px-16 lg:py-20">
                <div class="relative z-10 space-y-6" data-xv-reveal>
                    <h2 class="xv-display text-3xl md:text-5xl font-bold leading-tight">
                        Siap Mengubah Sistem Notifikasi Anda?
                    </h2>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto" style="color: var(--xv-on-ink-soft);">
                        Gunakan Exavro sekarang dan tingkatkan efektivitas pelayanan Anda dengan teknologi terdepan
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-2">
                        <a href="/login" title="login" class="xv-btn xv-btn-accent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Mulai Sekarang
                        </a>
                        <a href="https://wa.me/6285175112406" target="_blank" title="contact" class="xv-btn xv-btn-outline-onink">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>
                    <div class="flex flex-wrap justify-center items-center gap-x-8 gap-y-3 pt-6 text-sm" style="color: var(--xv-on-ink-soft);">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" style="color: var(--xv-accent);" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                            </svg>
                            Gratis 7 Hari
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" style="color: var(--xv-accent);" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                            </svg>
                            Setup Mudah
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" style="color: var(--xv-accent);" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                            </svg>
                            Privasi Anda Terjaga
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="xv-section" style="background: var(--xv-paper-alt);">
        <div class="mx-auto container px-4 max-w-3xl">
            <div class="text-center mb-12" data-xv-reveal>
                <h2 class="xv-display text-3xl md:text-4xl font-bold mb-3">Frequently Asked Questions</h2>
                <p class="text-lg max-w-2xl mx-auto" style="color: var(--xv-text-soft);">
                    Temukan jawaban atas pertanyaan yang sering diajukan tentang layanan kami. Jika Anda tidak
                    menemukan jawaban yang Anda cari, silakan hubungi kami.
                </p>
            </div>

            <div data-xv-stagger-group>
                <div class="xv-faq-item" data-xv-faq data-xv-stagger-item>
                    <h3>
                        <button type="button" class="xv-faq-trigger" data-xv-faq-trigger aria-controls="faq-panel-1" id="faq-trigger-1">
                            <span class="flex items-center gap-3">
                                <span class="xv-faq-tag">Umum</span>
                                <span>Apa itu Exavro?</span>
                            </span>
                            <span class="xv-faq-plus"></span>
                        </button>
                    </h3>
                    <div id="faq-panel-1" class="xv-faq-panel" data-xv-faq-panel role="region" aria-labelledby="faq-trigger-1">
                        <div class="xv-faq-body">
                            Exavro adalah sistem notifikasi otomatis berbasis WhatsApp yang membantu menyampaikan
                            pemberitahuan penting secara cepat dan efisien kepada pemohon maupun pegawai instansi.
                            Dengan sistem ini, komunikasi menjadi lebih terstruktur, responsif, dan hemat waktu.
                        </div>
                    </div>
                </div>

                <div class="xv-faq-item" data-xv-faq data-xv-stagger-item>
                    <h3>
                        <button type="button" class="xv-faq-trigger" data-xv-faq-trigger aria-controls="faq-panel-2" id="faq-trigger-2">
                            <span class="flex items-center gap-3">
                                <span class="xv-faq-tag">Fitur</span>
                                <span>Apa fitur utama dari Exavro?</span>
                            </span>
                            <span class="xv-faq-plus"></span>
                        </button>
                    </h3>
                    <div id="faq-panel-2" class="xv-faq-panel" data-xv-faq-panel role="region" aria-labelledby="faq-trigger-2">
                        <div class="xv-faq-body">
                            Exavro berfokus pada integrasi sistem notifikasi otomatis berbasis WhatsApp yang
                            menghubungkan pegawai dan pemohon secara real-time. Fitur ini membantu mempercepat
                            proses pelayanan, mengurangi keterlambatan, dan meningkatkan efisiensi kerja secara
                            keseluruhan.
                        </div>
                    </div>
                </div>

                <div class="xv-faq-item" data-xv-faq data-xv-stagger-item>
                    <h3>
                        <button type="button" class="xv-faq-trigger" data-xv-faq-trigger aria-controls="faq-panel-3" id="faq-trigger-3">
                            <span class="flex items-center gap-3">
                                <span class="xv-faq-tag">Proses</span>
                                <span>Bagaimana proses integrasi Exavro ke sistem saya?</span>
                            </span>
                            <span class="xv-faq-plus"></span>
                        </button>
                    </h3>
                    <div id="faq-panel-3" class="xv-faq-panel" data-xv-faq-panel role="region" aria-labelledby="faq-trigger-3">
                        <div class="xv-faq-body">
                            Integrasi Exavro sangat fleksibel dan cepat. Kami menyediakan dokumentasi API dan
                            panduan lengkap agar anda bisa langsung menghubungkan sistem anda dengan
                            notifikasi WhatsApp Exavro.
                        </div>
                    </div>
                </div>

                <div class="xv-faq-item" data-xv-faq data-xv-stagger-item>
                    <h3>
                        <button type="button" class="xv-faq-trigger" data-xv-faq-trigger aria-controls="faq-panel-4" id="faq-trigger-4">
                            <span class="flex items-center gap-3">
                                <span class="xv-faq-tag">Biaya</span>
                                <span>Apakah Exavro berbayar? Bagaimana sistem pembayarannya?</span>
                            </span>
                            <span class="xv-faq-plus"></span>
                        </button>
                    </h3>
                    <div id="faq-panel-4" class="xv-faq-panel" data-xv-faq-panel role="region" aria-labelledby="faq-trigger-4">
                        <div class="xv-faq-body">
                            Kami menyediakan paket langganan fleksibel sesuai kebutuhan. Pembayaran dapat
                            dilakukan melalui transfer bank, e-wallet, atau metode lainnya yang tersedia di
                            Midtrans.
                        </div>
                    </div>
                </div>

                <div class="xv-faq-item" data-xv-faq data-xv-stagger-item>
                    <h3>
                        <button type="button" class="xv-faq-trigger" data-xv-faq-trigger aria-controls="faq-panel-5" id="faq-trigger-5">
                            <span class="flex items-center gap-3">
                                <span class="xv-faq-tag">Kontak</span>
                                <span>Bagaimana cara menghubungi tim Exavro?</span>
                            </span>
                            <span class="xv-faq-plus"></span>
                        </button>
                    </h3>
                    <div id="faq-panel-5" class="xv-faq-panel" data-xv-faq-panel role="region" aria-labelledby="faq-trigger-5">
                        <div class="xv-faq-body max-w-none">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <div class="xv-contact-card">
                                <div class="xv-contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                                        <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold" style="color: var(--xv-text);">Email</h3>
                                    <a href="mailto:info.lotusaja@gmail.com" target="_blank" title="Email Us"
                                        class="font-semibold hover:underline" style="color: var(--xv-text-soft);">info.lotusaja@gmail.com</a>
                                </div>
                            </div>

                            <div class="xv-contact-card">
                                <div class="xv-contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.87 9.87 0 004.75 1.21h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2zm0 18.06a8.1 8.1 0 01-4.14-1.13l-.3-.18-3.14.82.84-3.06-.19-.32a8.15 8.15 0 01-1.25-4.28c0-4.49 3.66-8.15 8.16-8.15 4.49 0 8.15 3.66 8.15 8.15 0 4.5-3.66 8.15-8.13 8.15zm4.47-6.1c-.24-.12-1.44-.71-1.66-.79-.22-.08-.38-.12-.55.12-.16.24-.63.79-.77.95-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.02-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.55-1.32-.75-1.81-.2-.48-.4-.41-.55-.42h-.47c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.7 2.6 4.13 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.44-.59 1.64-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.46-.28z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold" style="color: var(--xv-text);">WhatsApp</h3>
                                    <a href="https://wa.me/6285175112406" target="_blank" title="WhatsApp Us"
                                        class="font-semibold hover:underline" style="color: var(--xv-text-soft);">(+62) 8517-5112-406</a>
                                </div>
                            </div>

                            <div class="xv-contact-card">
                                <div class="xv-contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.24 2.22.4.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.35 1.05.4 2.22.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.24 1.8-.4 2.22-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.05.35-2.22.4-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.24-2.22-.4a3.74 3.74 0 01-1.38-.9 3.74 3.74 0 01-.9-1.38c-.16-.42-.35-1.05-.4-2.22-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.24-1.8.4-2.22.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.05-.35 2.22-.4 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07c-1.28.06-2.15.26-2.91.56a5.9 5.9 0 00-2.14 1.4A5.9 5.9 0 00.6 4.17c-.3.76-.5 1.63-.56 2.91C0 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.28.26 2.15.56 2.91a5.9 5.9 0 001.4 2.14 5.9 5.9 0 002.14 1.4c.76.3 1.63.5 2.91.56C8.33 24 8.74 24 12 24s3.67-.01 4.95-.07c1.28-.06 2.15-.26 2.91-.56a5.9 5.9 0 002.14-1.4 5.9 5.9 0 001.4-2.14c.3-.76.5-1.63.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.28-.26-2.15-.56-2.91a5.9 5.9 0 00-1.4-2.14A5.9 5.9 0 0019.86.63c-.76-.3-1.63-.5-2.91-.56C15.67.01 15.26 0 12 0z" />
                                        <path d="M12 5.84A6.16 6.16 0 1012 18.16 6.16 6.16 0 0012 5.84zm0 10.16a4 4 0 110-8 4 4 0 010 8z" />
                                        <circle cx="18.41" cy="5.59" r="1.44" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold" style="color: var(--xv-text);">Instagram</h3>
                                    <a href="https://www.instagram.com/lotusaja_com" target="_blank" title="Instagram Lotus"
                                        class="font-semibold hover:underline" style="color: var(--xv-text-soft);">@lotusaja_com</a>
                                </div>
                            </div>

                            <div class="xv-contact-card">
                                <div class="xv-contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold" style="color: var(--xv-text);">Website</h3>
                                    <a href="https://www.lotusaja.com" target="_blank" title="Website Lotus"
                                        class="font-semibold hover:underline" style="color: var(--xv-text-soft);">www.lotusaja.com</a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12" data-xv-reveal>
                <p class="mb-4" style="color: var(--xv-text-soft);">Masih punya pertanyaan?</p>
                <div class="flex justify-center gap-4">
                    <a href="https://wa.me/6285175112406" title="Hubungi Kami" class="xv-btn xv-btn-accent" target="_blank">
                        Hubungi Kami
                    </a>
                    <a href="/about" class="xv-btn xv-btn-outline-ink" title="About Us">About Us</a>
                </div>
            </div>
        </div>
    </section>
</x-layout>