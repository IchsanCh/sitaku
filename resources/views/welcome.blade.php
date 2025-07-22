<x-layout>
    @section('title', 'Sitaku')
    <div class="w-full pt-0 lg:pt-24 bgc5 header md:pb-8">
        <div class="hero lg:pb-24 bgc5">
            <div class="hero-content flex-col lg:flex-row-reverse justify-between items-center w-full max-w-7xl px-8">
                <!-- Image Section -->
                <div class="flex-shrink-0 mb-8 lg:mb-0 lg:ml-8 overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('image/header.svg') }}" alt="header image" data-aos="fade-left"
                            data-aos-duration="800" class="w-80 lg:w-96 h-auto" loading="lazy">
                    </div>
                </div>
                <div class="flex-1 text-center text-white lg:text-left">
                    <div class="max-w-2xl">
                        <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6" data-aos="fade-up"
                            data-aos-duration="800">
                            Welcome To Sitaku
                        </h1>
                        <p class="text-xl lg:text-2xl font-medium mb-8 text-white leading-relaxed" data-aos="fade-up"
                            data-aos-duration="800">
                            Sitaku hadir sebagai sistem notifikasi cerdas untuk mempercepat informasi antara pemohon dan
                            pegawai
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start" data-aos="fade-up"
                            data-aos-duration="800">
                            <a href="#fitur" title="feature"
                                class="btn btn-success btn-lg shadow-lg hover:shadow-xl hover:shadow-accent/50 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="currentColor"
                                    viewBox="0 0 512 512" class="w-5 h-5">
                                    <path
                                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zM256 120c22.1 0 40 17.9 40 40s-17.9 40-40 40s-40-17.9-40-40s17.9-40 40-40zm48 288c0 8.8-7.2 16-16 16h-64c-8.8 0-16-7.2-16-16v-16c0-8.8 7.2-16 16-16h8v-64h-8c-8.8 0-16-7.2-16-16v-16c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v96h8c8.8 0 16 7.2 16 16v16z" />
                                </svg>
                                Pelajari Lebih Lanjut
                            </a>
                            <a href="/docs" title="documentation" class="btn btn-outline btn-lg">
                                <i class="fa-solid fa-book mr-2"></i>
                                Lihat Dokumentasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keunggulan / Fitur -->
    <section id="fitur" class="bg-base-100 py-20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-base-content mb-4" data-aos="fade-up"
                    data-aos-duration="800">
                    Mengapa Memilih <span class="c5">Sitaku</span>?
                </h2>
                <p class="text-lg text-base-content max-w-2xl mx-auto" data-aos="fade-up" data-aos-duration="800">
                    Solusi modern untuk sistem notifikasi otomatis yang membantu meningkatkan efisiensi dan layanan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Fitur 1 -->
                <div class="card card-compact bg-base-100 shadow-xl border border-primary/20 hover:shadow-2xl hover:scale-105 transition-all duration-300 group"
                    data-aos="flip-left" data-aos-duration="800">
                    <div class="card-body items-center text-center">
                        <div
                            class="w-16 h-16 bg-warning rounded-2xl flex items-center justify-center mb-4 group-hover:rotate-12 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                            </svg>
                        </div>
                        <h3 class="card-title text-xl font-bold text-base-content mb-2">Notifikasi Tepat Waktu</h3>
                        <p class="text-base-content font-semibold leading-relaxed">
                            Sitaku mengirim notifikasi otomatis sesuai tahapan proses langsung, tanpa penundaan.
                        </p>
                        <div class="badge badge-warning badge-sm mt-2 font-semibold">Real-time</div>
                    </div>
                </div>

                <!-- Fitur 2 -->
                <div class="card card-compact bg-base-100 shadow-xl border border-primary/20 hover:shadow-2xl hover:scale-105 transition-all duration-300 group"
                    data-aos="flip-left" data-aos-duration="800">
                    <div class="card-body items-center text-center">
                        <div
                            class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mb-4 group-hover:rotate-12 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" />
                            </svg>
                        </div>
                        <h3 class="card-title text-xl font-bold text-base-content mb-2">Otomatis & Terkelola</h3>
                        <p class="text-base-content font-semibold leading-relaxed">
                            Seluruh pengingat dan pemberitahuan dikelola otomatis dari data sistem. Tanpa input manual,
                            tanpa repot.
                        </p>
                        <div class="badge badge-primary badge-sm mt-2 font-semibold">Smart Notification System</div>
                    </div>
                </div>

                <!-- Fitur 3 -->
                <div class="card card-compact bg-base-100 shadow-xl border border-primary/20 hover:shadow-2xl hover:scale-105 transition-all duration-300 group"
                    data-aos="flip-left" data-aos-duration="800">
                    <div class="card-body items-center text-center">
                        <div
                            class="w-16 h-16 bg-success rounded-2xl flex items-center justify-center mb-4 group-hover:rotate-12 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="card-title text-xl font-bold text-base-content mb-2">Privasi & Keamanan</h3>
                        <p class="text-base-content leading-relaxed font-semibold">
                            Sistem Sitaku dilengkapi autentikasi aman dan proteksi data, menjaga setiap informasi tetap
                            rahasia.
                        </p>
                        <div class="badge badge-success badge-sm mt-2 font-semibold">Enterprise Grade</div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA -->
    <section class="py-20 bgc5 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4">
            <div class="space-y-6">
                <h2 class="text-4xl md:text-6xl font-black mb-6 leading-tight" data-aos="fade-up"
                    data-aos-duration="800">
                    Siap Mengubah Sistem Notifikasi Anda?
                </h2>
                <p class="text-xl md:text-2xl text-white/90 font-medium max-w-2xl mx-auto leading-relaxed"
                    data-aos="fade-up" data-aos-duration="800">
                    Gunakan Sitaku sekarang dan tingkatkan efektivitas pelayanan Anda dengan teknologi terdepan
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4" data-aos="fade-up"
                    data-aos-duration="800">
                    <a href="/login" title="login"
                        class="btn btn-accent btn-lg px-12 shadow-2xl hover:shadow-accent/50 transition-all duration-300 font-bold">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Mulai Sekarang
                    </a>
                    <a href="https://wa.me/6285175112406" target="_blank" title="contact"
                        class="btn btn-ghost btn-lg border-2 border-white text-white hover:bg-white hover:text-black transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
                <div class="flex justify-center items-center space-x-8 pt-8 text-white" data-aos="fade-up"
                    data-aos-duration="800">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                        </svg>
                        <span class="text-sm font-medium">Gratis 7 Hari</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                        </svg>
                        <span class="text-sm font-medium">Setup Mudah</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                        </svg>
                        <span class="text-sm font-medium">Privasi Anda Terjaga</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="faq">
        <div class="w-full bg-base-100">
            <div class="mx-auto container px-4 py-16 max-w-4xl">
                <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="text-4xl font-bold mb-3 c5">Frequently Asked Questions</h2>
                    <p class="text-lg text-base-content max-w-2xl mx-auto">Temukan jawaban atas pertanyaan yang sering
                        diajukan tentang layanan kami. Jika Anda tidak menemukan jawaban yang Anda cari, silakan hubungi
                        kami.
                    </p>
                </div>
                <div class="space-y-4">
                    <div class="collapse collapse-plus bg-base-300 hoversan rounded-box shadow-md hover:shadow-lg">
                        <input type="checkbox" class="peer" name="faq1" />
                        <div class="collapse-title text-base md:text-lg font-semibold">
                            <div class="flex items-center">
                                <span class="badge bgc1 text-white mr-3">Umum</span>
                                <span>Apa itu Sitaku?</span>
                            </div>
                        </div>
                        <div class="collapse-content peer-checked:pt-2 transition-all duration-300 ease-in-out">
                            <p class="py-2">
                                Sitaku adalah sistem notifikasi otomatis berbasis WhatsApp yang membantu menyampaikan
                                pemberitahuan penting secara cepat dan efisien kepada pemohon maupun pegawai instansi.
                                Dengan sistem ini, komunikasi menjadi lebih terstruktur, responsif, dan hemat waktu.
                            </p>
                        </div>
                    </div>


                    <div class="collapse collapse-plus bg-base-300 hoversan rounded-box shadow-md">
                        <input type="checkbox" class="peer" name="faq2" />
                        <div class="collapse-title text-base md:text-lg font-semibold">
                            <div class="flex items-center">
                                <span class="badge bgc1 text-white mr-3">Fitur</span>
                                <span>Apa fitur utama dari Sitaku?</span>
                            </div>
                        </div>
                        <div class="collapse-content peer-checked:pt-2 transition-all duration-300 ease-in-out">
                            <div class="py-2 space-y-4">
                                <p>
                                    Sitaku berfokus pada integrasi sistem notifikasi otomatis berbasis WhatsApp yang
                                    menghubungkan pegawai dan pemohon secara real-time. Fitur ini membantu mempercepat
                                    proses pelayanan, mengurangi keterlambatan, dan meningkatkan efisiensi kerja secara
                                    keseluruhan.
                                </p>

                            </div>
                        </div>
                    </div>

                    <div class="collapse collapse-plus bg-base-300 hoversan rounded-box shadow-md">
                        <input type="checkbox" class="peer" name="faq3" />
                        <div class="collapse-title text-base md:text-lg font-semibold">
                            <div class="flex items-center">
                                <span class="badge bgc1 text-white mr-3">Proses</span>
                                <span>Bagaimana proses integrasi Sitaku ke sistem saya?</span>
                            </div>
                        </div>
                        <div class="collapse-content peer-checked:pt-2 transition-all duration-300 ease-in-out">
                            <div class="py-2 space-y-4">
                                <p>Integrasi Sitaku sangat fleksibel dan cepat. Kami menyediakan dokumentasi API dan
                                    panduan lengkap agar anda bisa langsung menghubungkan sistem anda dengan
                                    notifikasi WhatsApp Sitaku.</p>
                            </div>
                        </div>
                    </div>

                    <div class="collapse collapse-plus bg-base-300 hoversan rounded-box shadow-md">
                        <input type="checkbox" class="peer" name="faq4" />
                        <div class="collapse-title text-base font-semibold">
                            <div class="flex items-center">
                                <span class="badge bgc1 text-white mr-3">Biaya</span>
                                <span>Apakah Sitaku berbayar? Bagaimana sistem pembayarannya?</span>
                            </div>
                        </div>
                        <div class="collapse-content peer-checked:pt-2 transition-all duration-300 ease-in-out">
                            <div class="py-2 space-y-4">
                                <p>Kami menyediakan paket langganan fleksibel sesuai kebutuhan. Pembayaran dapat
                                    dilakukan melalui transfer bank, e-wallet, atau metode lainnya yang tersedia di
                                    Midtrans.</p>
                            </div>
                        </div>
                    </div>

                    <div class="collapse collapse-plus bg-base-300 hoversan rounded-box shadow-md">
                        <input type="checkbox" class="peer" name="faq5" />
                        <div class="collapse-title text-base font-semibold">
                            <div class="flex items-center">
                                <span class="badge bgc1 text-white mr-3">Kontak</span>
                                <span>Bagaimana cara menghubungi tim Sitaku?</span>
                            </div>
                        </div>
                        <div class="collapse-content peer-checked:pt-2 transition-all duration-300 ease-in-out">
                            <div class="py-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="card bg-base-100">
                                        <div class="card-body p-4">
                                            <div class="flex gap-4 items-center">
                                                <div class="avatar placeholder">
                                                    <div
                                                        class="c1 text-white text-center rounded-full w-12 text-3xl items-center flex justify-items-center content-center">
                                                        <i class="fa-solid fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold">Email</h3>
                                                    <a href="mailto:info.lotusaja@gmail.com" target="_blank"
                                                        class="c1 hover:underline font-semibold">info.lotusaja@gmail.com</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-base-100">
                                        <div class="card-body p-4">
                                            <div class="flex gap-4 items-center">
                                                <div class="avatar placeholder">
                                                    <div
                                                        class="c1 text-white rounded-full content-center flex justify-items-center items-center w-12">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-8">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold">WhatsApp</h3>
                                                    <a href="https://wa.me/6285175112406" target="_blank"
                                                        class="c1 hover:underline font-semibold">(+62)
                                                        8517-5112-406</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-base-100">
                                        <div class="card-body p-4">
                                            <div class="flex gap-4 items-center">
                                                <div class="avatar placeholder">
                                                    <div
                                                        class="c1 text-white rounded-full w-12 text-4xl text-center items-center flex justify-items-center content-center">
                                                        <i class="fa-brands fa-instagram"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold">Instagram</h3>
                                                    <a href="https://www.instagram.com/lotusaja_com" target="_blank"
                                                        class="c1 hover:underline font-semibold">@lotusaja_com</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-base-100">
                                        <div class="card-body p-4">
                                            <div class="flex gap-4 items-center">
                                                <div class="avatar placeholder">
                                                    <div class="c1 text-white rounded-full w-12">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-12">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold">Website</h3>
                                                    <a href="https://www.lotusaja.com" target="_blank"
                                                        title="Website Lotus"
                                                        class="c1 hover:underline font-semibold">www.lotusaja.com</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-12">
                    <p class="mb-4">Masih punya pertanyaan?</p>
                    <div class="flex justify-center gap-4">
                        <a href="https://wa.me/6285175112406" class="btn bgc1 text-white" target="_blank">Hubungi
                            Kami</a>
                        <a href="/about" class="btn btn-outline">About Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all the collapse elements
            const collapseItems = document.querySelectorAll('.collapse');

            // Function to close all other collapse items
            function closeOthers(currentItem) {
                collapseItems.forEach(item => {
                    if (item !== currentItem && item.querySelector('input').checked) {
                        item.querySelector('input').checked = false;
                    }
                });
            }

            // Add event listeners to each collapse item
            collapseItems.forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');

                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        closeOthers(item);
                    }
                });
            });
        });
    </script>
</x-layout>
