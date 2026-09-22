// JS khusus panel dashboard -- SENGAJA gak import ./bootstrap (yang narik
// axios + laravel-echo + pusher-js). Dicek dulu: gak ada satu pun halaman
// panel yang makai axios/window.Echo/Pusher (semua AJAX di panel pakai
// fetch() polos) -- jadi 3 library itu cuma beban tanpa manfaat kalau
// ikut ke-load di sini. Real-time/websocket itu punya support.js sendiri.

document.addEventListener("DOMContentLoaded", function () {
    const drawerToggle = document.getElementById("drawer-toggle");
    const menuLinks = document.querySelectorAll(".drawer-side a");

    menuLinks.forEach((link) => {
        link.addEventListener("click", function () {
            if (window.innerWidth < 1024) {
                drawerToggle.checked = false;
            }
        });
    });
});

// Dipanggil dari menu/tombol yang dikunci fitur tier (mis. Custom Pesan,
// Balasan Cepat di sidebar) lewat onclick="" inline di HTML. Vite nge-bundle
// file ini sebagai ES module -- function biasa gak otomatis nempel ke
// `window` kayak <script> polos, jadi HARUS di-attach manual biar
// onclick="showFeatureLockedAlert()" di blade nemu function-nya.
window.showFeatureLockedAlert = function () {
    document.getElementById("modal-feature-locked").showModal();
};
