/**
 * Lazy-load AOS (Animate On Scroll).
 *
 * AOS gak diimpor statis di app.js -- dia baru di-download (JS + CSS,
 * lewat dynamic import, jadi ke-split Vite jadi chunk terpisah) kalau:
 *   1. Halaman yang lagi dibuka emang punya elemen [data-aos], DAN
 *   2. window sudah selesai 'load' (biar gak ngerebut bandwidth/main-thread
 *      dari render konten utama & aset kritikal lain).
 *
 * Dipanggil dari app.js.
 */
export function initAOSIfNeeded() {
    if (!document.querySelector("[data-aos]")) {
        return;
    }

    const load = () => {
        Promise.all([import("aos"), import("aos/dist/aos.css")]).then(
            ([{ default: AOS }]) => {
                AOS.init({
                    duration: 300,
                    once: false,
                });
            },
        );
    };

    if (document.readyState === "complete") {
        load();
    } else {
        window.addEventListener("load", load, { once: true });
    }
}
