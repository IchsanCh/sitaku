import { initAOSIfNeeded } from "./lazy-aos";

// Sengaja dipisah dari public.js walau isinya sama sekarang -- biar auth flow
// (login/signup/otp/forgot-password/reset-password) punya entry sendiri kalau
// nanti butuh JS spesifik (mis. validasi form) tanpa nambahin bobot ke
// halaman marketing (welcome/about/pricing), atau sebaliknya.
document.addEventListener("DOMContentLoaded", () => {
    initAOSIfNeeded();
});
