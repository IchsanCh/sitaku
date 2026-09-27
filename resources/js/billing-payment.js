// JS khusus halaman checkout billing (Midtrans Snap + modal hasil pembayaran).
// Sengaja baca konfigurasi (snap token, url billing) dari data-attribute di
// tombol, bukan variabel global yang di-inject Blade -- biar file ini murni
// JS statis dan bisa di-bundle Vite kayak file js/ lain.
//
// window.showToast dipakai dari panel.js (sudah di-load bareng exavro-panel
// di layout-checkout.blade.php), jadi gak perlu implementasi toast sendiri
// di sini lagi.

document.addEventListener("DOMContentLoaded", function () {
    const payButton = document.getElementById("pay-button");
    if (!payButton) return;

    const loadingSpinner = document.getElementById("loading-spinner");
    const loadingOverlay = document.getElementById("loading-overlay");
    const successModal = document.getElementById("success-modal");
    const errorModal = document.getElementById("error-modal");
    const pendingModal = document.getElementById("pending-modal");

    const snapToken = payButton.dataset.snapToken;
    const billingUrl = payButton.dataset.billingUrl;

    function showLoading() {
        payButton.disabled = true;
        loadingSpinner?.classList.remove("hidden");
        loadingOverlay?.classList.remove("hidden");
        loadingOverlay?.classList.add("flex");
    }

    function hideLoading() {
        payButton.disabled = false;
        loadingSpinner?.classList.add("hidden");
        loadingOverlay?.classList.add("hidden");
        loadingOverlay?.classList.remove("flex");
    }

    function showModal(modal) {
        hideLoading();
        modal?.showModal();
    }

    // Tombol "Lanjutkan" / "Coba Lagi" / "Periksa Status" di dalam modal --
    // sebelumnya hardcode window.location.href = '/billing', sekarang pakai
    // URL dari route() lewat data-attribute biar gak putus kalau prefix URL
    // berubah.
    document.querySelectorAll("[data-go-billing]").forEach((btn) => {
        btn.addEventListener("click", () => {
            window.location.href = billingUrl;
        });
    });

    payButton.addEventListener("click", function () {
        if (!snapToken || typeof window.snap === "undefined") {
            window.showToast?.(
                "error",
                "Midtrans Snap gagal dimuat. Coba refresh halaman ini.",
            );
            return;
        }

        showLoading();

        window.snap.pay(snapToken, {
            onSuccess: function () {
                showModal(successModal);
            },
            onPending: function () {
                showModal(pendingModal);
            },
            onError: function () {
                showModal(errorModal);
            },
            onClose: function () {
                hideLoading();
                window.showToast?.("warning", "Pembayaran dibatalkan.");
            },
        });
    });
});
