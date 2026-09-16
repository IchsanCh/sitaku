import Pusher from "pusher-js";

// Diekspos global biar script inline di tiap blade (inbox.blade.php,
// chat.blade.php) bisa langsung pakai `new Pusher(...)` tanpa perlu
// masing-masing halaman jadi entry point/module Vite sendiri-sendiri.
window.Pusher = Pusher;

// === Favicon badge (buletan notif chat masuk) ===============================
// Gambar ulang favicon + buletan oranye pojok kanan-atas pas ada pesan baru
// dari pemohon SAAT TAB LAGI GAK DIFOKUS -- balik ke favicon polos begitu tab
// difokus lagi. Dipanggil dari inbox.blade.php (room.updated) & chat.blade.php
// (message.sent) lewat window.FaviconBadge.show()/.clear().
(function () {
    const faviconLink = document.getElementById("faviconLink");
    if (!faviconLink) return;

    const baseHref = faviconLink.href;
    let baseImage = null;
    let isBadged = false;

    function loadBaseImage(callback) {
        if (baseImage) return callback(baseImage);
        const img = new Image();
        img.onload = () => {
            baseImage = img;
            callback(img);
        };
        img.onerror = () => {}; // favicon gagal dimuat -- diemin, gak kritis
        img.src = baseHref;
    }

    function showBadge() {
        if (isBadged) return;
        loadBaseImage((img) => {
            const size = 32;
            const canvas = document.createElement("canvas");
            canvas.width = size;
            canvas.height = size;
            const ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0, size, size);

            const r = size * 0.28;
            const cx = size - r * 0.85;
            const cy = r * 0.85;
            ctx.beginPath();
            ctx.arc(cx, cy, r, 0, Math.PI * 2);
            ctx.fillStyle = "#ffffff"; // cincin putih tipis biar buletannya kebaca di favicon warna apa pun
            ctx.fill();
            ctx.beginPath();
            ctx.arc(cx, cy, r * 0.72, 0, Math.PI * 2);
            ctx.fillStyle = "#ff5a2e";
            ctx.fill();

            faviconLink.href = canvas.toDataURL("image/png");
            isBadged = true;
        });
    }

    function clearBadge() {
        if (!isBadged) return;
        faviconLink.href = baseHref;
        isBadged = false;
    }

    document.addEventListener("visibilitychange", function () {
        if (!document.hidden) clearBadge();
    });
    window.addEventListener("focus", clearBadge);

    window.FaviconBadge = { show: showBadge, clear: clearBadge };
})();
