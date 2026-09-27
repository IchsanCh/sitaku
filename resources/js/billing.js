// JS khusus halaman billing index: submit paket di modal "Pilih Paket" +
// riwayat billing. Toast pakai window.showToast() dari panel.js (dipakai
// bareng semua halaman panel) -- implementasi toast lokal yang sebelumnya
// nge-copy ulang logic yang sama udah dibuang dari sini.
//
// Ripple effect & smooth-scroll global yang sebelumnya ada di sini juga
// dibuang: ripple gak nambah kejelasan apa-apa buat form submission biasa,
// dan smooth-scroll dipasang ke SEMUA halaman lewat document.documentElement
// tanpa scoping -- efeknya bocor ke halaman lain di luar billing kalau
// script ini keload duluan / di-cache browser.

document.addEventListener("DOMContentLoaded", function () {
    const packageForms = document.querySelectorAll(".pricing-card form");
    const overlay = document.getElementById("billing-processing-overlay");

    function setProcessing(activeForm) {
        overlay?.classList.remove("hidden");
        overlay?.classList.add("flex");

        packageForms.forEach((form) => {
            const btn = form.querySelector('button[type="submit"]');
            if (!btn) return;

            btn.disabled = true;

            if (form === activeForm) {
                btn.dataset.originalHtml = btn.innerHTML;
                btn.innerHTML =
                    '<span class="loading loading-spinner loading-sm"></span> Menyiapkan pembayaran...';
            }
        });
    }

    packageForms.forEach((form) => {
        form.addEventListener("submit", function () {
            // Cuma submit sekali -- klik kedua sebelum redirect kelar diabaikan,
            // ini yang benerin "user bisa double klik pilih paket" (server-side
            // fix-nya di BillingController@pay, ini lapis kedua di browser).
            setProcessing(form);
        });
    });

    // Kalau user balik ke halaman ini lewat tombol back (bfcache), pastiin
    // tombol gak nyangkut disabled/loading dari submit sebelumnya.
    window.addEventListener("pageshow", function (event) {
        if (!event.persisted) return;

        overlay?.classList.add("hidden");
        overlay?.classList.remove("flex");

        packageForms.forEach((form) => {
            const btn = form.querySelector('button[type="submit"]');
            if (!btn) return;
            btn.disabled = false;
            if (btn.dataset.originalHtml) {
                btn.innerHTML = btn.dataset.originalHtml;
            }
        });
    });
});
