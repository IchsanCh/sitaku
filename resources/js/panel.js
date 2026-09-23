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

// Toast notif -- shared, dipake semua halaman panel. Sebelumnya fungsi ini
// di-copy-paste identik di 12 file blade berbeda; dipindah ke sini biar 1
// sumber kebenaran. Halaman yang belum sempat dirapiin (masih punya definisi
// lokal sendiri) tetap aman -- definisi lokal itu cuma nimpa punya sini di
// scope-nya sendiri, gak bentrok.
window.showToast = function (type, message, title = "") {
    const toastContainer = document.getElementById("toastContainer");
    if (!toastContainer) return;

    const alertClass =
        type === "error"
            ? "alert-error"
            : type === "success"
              ? "alert-success"
              : type === "warning"
                ? "alert-warning"
                : "alert-info";

    const icon =
        type === "error"
            ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            : type === "success"
              ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
              : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

    const toast = document.createElement("div");
    toast.className = `alert ${alertClass} shadow-lg mb-4`;
    toast.innerHTML = `
        <div class="flex items-start gap-3">
            ${icon}
            <div class="flex-1">
                ${title ? `<div class="font-bold">${title}</div>` : ""}
                <div class="text-sm">${message}</div>
            </div>
            <button class="btn btn-ghost btn-sm" onclick="this.parentElement.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    `;

    toastContainer.appendChild(toast);
    setTimeout(() => {
        if (toast.parentElement) toast.remove();
    }, 5000);
};

// Dipanggil dari menu/tombol yang dikunci fitur tier (mis. Custom Pesan,
// Balasan Cepat di sidebar) lewat onclick="" inline di HTML. Vite nge-bundle
// file ini sebagai ES module -- function biasa gak otomatis nempel ke
// `window` kayak <script> polos, jadi HARUS di-attach manual biar
// onclick="showFeatureLockedAlert()" di blade nemu function-nya.
window.showFeatureLockedAlert = function () {
    document.getElementById("modal-feature-locked").showModal();
};
