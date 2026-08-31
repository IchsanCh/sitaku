<x-layout>
    @section('title', 'About')
    @section('meta_description',
        'Pelajari lebih lanjut tentang Exavro, sistem notifikasi otomatis yang mempermudah
        proses komunikasi antara pegawai dan pemohon. Efisien, cepat, dan andal.')
    @section('og_description',
        'Exavro adalah sistem notifikasi otomatis berbasis WhatsApp yang membantu instansi
        menyampaikan informasi penting dengan cepat dan tepat waktu.')
        <section class="xv-section" style="background: var(--xv-paper);">
            <div class="max-w-6xl mx-auto px-6 md:px-10 grid md:grid-cols-2 gap-14 items-center overflow-hidden" data-xv-stagger-group>
                <!-- Gambar Kiri -->
                <div class="order-2 md:order-1" data-xv-stagger-item>
                    <img src="{{ asset('image/about.svg') }}" alt="Ilustrasi build web"
                        class="w-full h-auto rounded-2xl" style="box-shadow: var(--xv-shadow-lg);" loading="lazy" />
                </div>

                <!-- Narasi Kanan -->
                <div class="order-1 md:order-2" data-xv-stagger-item>
                    <h2 class="xv-display text-3xl md:text-4xl font-bold mb-5" style="color: var(--xv-text);">
                        Tentang Exavro
                    </h2>
                    <p class="leading-relaxed max-w-xl" style="color: var(--xv-text-soft);">
                        Exavro adalah sistem notifikasi otomatis yang dirancang untuk mempercepat dan menyederhanakan alur
                        pelayanan publik.
                        Dengan mengirimkan notifikasi langsung melalui WhatsApp, Exavro memastikan bahwa setiap pegawai dan
                        pemohon mendapatkan informasi secara cepat, jelas, dan tepat waktu.
                        Sistem ini membantu mengurangi keterlambatan, mencegah miskomunikasi, dan meningkatkan akuntabilitas
                        dalam setiap tahapan proses.
                        Exavro bekerja secara otomatis tanpa perlu input manual setiap saat, sehingga memudahkan admin untuk
                        fokus pada hal-hal penting lainnya.
                        Didesain dengan antarmuka yang sederhana dan ringan, Exavro cocok digunakan oleh siapa saja, bahkan
                        oleh instansi dengan sumber daya teknis yang terbatas.
                    </p>
                </div>
            </div>
        </section>
    </x-layout> 