<x-layout>
    @section('title', 'About')
    @section('meta_description', 'Pelajari lebih lanjut tentang Sitaku, sistem notifikasi otomatis yang mempermudah
        proses komunikasi antara pegawai dan pemohon. Efisien, cepat, dan andal.')
    @section('og_description', 'Sitaku adalah sistem notifikasi otomatis berbasis WhatsApp yang membantu instansi
        menyampaikan informasi penting dengan cepat dan tepat waktu.')
        <section class="bg-base-300 py-16 px-6 md:px-20">
            <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10 items-center overflow-hidden">
                <!-- Gambar Kiri -->
                <div class="order-2 md:order-1" data-aos="fade-right" data-aos-duration="800">
                    <img src="{{ asset('image/about.svg') }}" alt="Ilustrasi build web"
                        class="w-full h-auto rounded-xl shadow-lg" loading="lazy" />
                </div>

                <!-- Narasi Kanan -->
                <div class="order-1 md:order-2" data-aos="fade-left" data-aos-duration="800">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4 text-gray-800">Tentang Sitaku</h2>
                    <p class="text-black leading-relaxed mb-6 font-semibold">
                        Sitaku adalah sistem notifikasi otomatis yang dirancang untuk mempercepat dan menyederhanakan alur
                        pelayanan publik.
                        Dengan mengirimkan notifikasi langsung melalui WhatsApp, Sitaku memastikan bahwa setiap pegawai dan
                        pemohon mendapatkan informasi secara cepat, jelas, dan tepat waktu.
                        Sistem ini membantu mengurangi keterlambatan, mencegah miskomunikasi, dan meningkatkan akuntabilitas
                        dalam setiap tahapan proses.
                        Sitaku bekerja secara otomatis tanpa perlu input manual setiap saat, sehingga memudahkan admin untuk
                        fokus pada hal-hal penting lainnya.
                        Didesain dengan antarmuka yang sederhana dan ringan, Sitaku cocok digunakan oleh siapa saja, bahkan
                        oleh instansi dengan sumber daya teknis yang terbatas.
                    </p>
                </div>
            </div>
        </section>

    </x-layout>
