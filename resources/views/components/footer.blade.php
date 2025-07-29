<footer class="bg-black text-white">
    <div class="container mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-12">
        <!-- Brand section -->
        <div class="md:col-span-2 space-y-6">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('image/logoLotus3.jpg') }}" class="h-16" loading="lazy" alt="Logo lotusaja">
                <h2 class="text-3xl font-bold text-white font-sans">
                    SITAKU</h2>
            </div>
            <p class="text-gray-300 max-w-md">
                Sitaku merupakan sistem notifikasi otomatis yang dirancang untuk memberikan pemberitahuan tepat waktu
                kepada pemohon dan pegawai, sehingga setiap tahapan proses dapat berjalan secara efektif dan efisien.
            </p>
            <div class="flex space-x-4 pt-2 items-center">
                <a href="https://instagram.com/lotusaja_com" class="hover:text-red-500 transition-colors"
                    target="_blank" title="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                    </svg>
                </a>
                <a href="https://wa.me/6285175112406" target="_blank" class="hover:text-green-500 transition-colors"
                    title="Whatsapp">
                    <i class="fa-brands fa-whatsapp text-2xl"></i>
                </a>
                <a href="mailto:info.lotusaja@gmail.com" title="Email" target="_blank"
                    class="hover:text-blue-500 transition-colors">
                    <i class="fa-solid fa-envelope text-2xl"></i>
                </a>
                <a href="https://www.tiktok.com/@lotusaja.com" title="Tiktok" target="_blank"
                    class="hover:text-red-500 transition-colors">
                    <i class="fa-brands fa-tiktok text-2xl"></i>
                </a>
                <a href="https://web.facebook.com/profile.php?id=61576738915850" target="_blank"
                    class="hover:text-blue-500 transition-colors" title="Facebook">
                    <i class="fa-brands fa-facebook text-2xl"></i>
                </a>
            </div>
        </div>

        <div>
            <h3 class="text-xl font-bold mb-6 text-gray-300">Navigation</h3>
            <ul class="space-y-4">
                <li><a href="{{ route('home') }}" title="Home"
                        class="block text-gray-300 hover:text-white hover:translate-x-1 transition-all">Home</a></li>
                <li><a href="{{ route('about') }}" title="About Us"
                        class="block text-gray-300 hover:text-white hover:translate-x-1 transition-all">About Us</a>
                </li>
                <li><a href="/docs/getting-started" title="Documentation"
                        class="block text-gray-300 hover:text-white hover:translate-x-1 transition-all">Documentation</a>
                </li>
            </ul>
        </div>
        <div>
            <h3 class="text-xl font-bold mb-6 text-gray-300">Help</h3>
            <ul class="space-y-4">
                <li><a href="/?section=faq" title="FAQ"
                        class="block text-gray-300 hover:text-white hover:translate-x-1 transition-all">FAQ</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="bg-black border-t border-gray-500">
        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">Design by Lotusaja Team</p>
            <p class="text-gray-400 text-sm">© 2025 Sitaku. All rights reserved.</p>
        </div>
    </div>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</footer>
