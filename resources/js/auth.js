// Satu modul buat semua 5 halaman auth (login/signup/otp/forgot-password/
// reset-password). Sebelumnya tiap halaman punya salinan sendiri-sendiri dari
// showToast/password-toggle/dll (~700 baris duplikat di signup aja). Sekarang
// satu implementasi, dipanggil lewat window.ExavroAuth dari script inline kecil
// di tiap blade (buat data yang emang cuma ada di server: URL route, pesan
// flash, dsb -- itu gak bisa dipindah ke sini karena butuh Blade).
//
// Sengaja TANPA AOS/animasi scroll -- kartu auth cuma satu viewport, gak ada
// yang di-scroll, jadi library animasi-on-scroll itu bobot yang gak kepake.

function showToast(type, message, title = "") {
    let region = document.getElementById("xv-toast-region");
    if (!region) {
        region = document.createElement("div");
        region.id = "xv-toast-region";
        document.body.appendChild(region);
    }

    const icons = {
        error: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        success:
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        info: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        warning:
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
    };

    const toast = document.createElement("div");
    toast.className = "xv-toast";
    toast.dataset.type = type;
    toast.innerHTML = `
        <span class="xv-toast-icon">${icons[type] || icons.info}</span>
        <div class="flex-1">
            ${title ? `<div class="xv-toast-title">${title}</div>` : ""}
            <div>${message}</div>
        </div>
        <button class="xv-toast-close" aria-label="Tutup">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    `;

    function dismiss() {
        toast.classList.add("is-leaving");
        setTimeout(() => toast.remove(), 200);
    }

    toast.querySelector(".xv-toast-close").addEventListener("click", dismiss);
    region.appendChild(toast);
    setTimeout(dismiss, type === "info" ? 7000 : 5500);
}

// === tombol submit dengan state loading (label <-> spinner) ===============
function setButtonLoading(button, isLoading) {
    if (!button) return;
    const label = button.querySelector("[data-btn-label]");
    const spinner = button.querySelector("[data-btn-spinner]");
    button.disabled = isLoading;
    button.classList.toggle("is-loading", isLoading);
    if (label) label.classList.toggle("hidden", isLoading);
    if (spinner) spinner.classList.toggle("hidden", !isLoading);
}

// === toggle lihat/sembunyi password ========================================
function initPasswordToggles() {
    document.querySelectorAll("[data-password-toggle]").forEach((btn) => {
        const target = document.querySelector(btn.dataset.passwordToggle);
        if (!target) return;
        btn.addEventListener("click", () => {
            const showing = target.type === "text";
            target.type = showing ? "password" : "text";
            btn.querySelectorAll("[data-eye-open]").forEach((el) =>
                el.classList.toggle("hidden", !showing),
            );
            btn.querySelectorAll("[data-eye-closed]").forEach((el) =>
                el.classList.toggle("hidden", showing),
            );
        });
    });
}

// === kekuatan password + checklist requirement =============================
// requirements: 8+ karakter, huruf besar, huruf kecil, angka, simbol.
function passwordScore(password) {
    const checks = {
        length: password.length >= 8,
        upper: /[A-Z]/.test(password),
        lower: /[a-z]/.test(password),
        number: /[0-9]/.test(password),
        symbol: /[^A-Za-z0-9]/.test(password),
    };
    const score = Object.values(checks).filter(Boolean).length;
    return { checks, score };
}

function strengthLevel(score) {
    if (score <= 2)
        return {
            key: "weak",
            label: "Lemah",
            segments:
                score === 0 ? 0 : Math.max(1, Math.round((score / 5) * 4)),
        };
    if (score === 3) return { key: "fair", label: "Cukup", segments: 3 };
    if (score === 4) return { key: "good", label: "Baik", segments: 4 };
    return { key: "strong", label: "Kuat", segments: 4 };
}

// Dipakai di dua halaman (signup + reset-password) yang butuh password kuat.
// container = elemen pembungkus yang punya semua bagian di bawah ini sebagai
// descendant, dicari lewat data-attribute -- jadi satu fungsi ini jalan di
// markup manapun asal atributnya lengkap.
function initPasswordStrength(container) {
    if (!container) return null;

    const input = container.querySelector("[data-strength-input]");
    const segmentsWrap = container.querySelector("[data-strength-segments]");
    const label = container.querySelector("[data-strength-label]");
    const reqItems = container.querySelectorAll("[data-req]");
    if (!input) return null;

    const segments = segmentsWrap ? Array.from(segmentsWrap.children) : [];

    function update() {
        const password = input.value;
        const { checks, score } = passwordScore(password);

        reqItems.forEach((item) => {
            const met = !!checks[item.dataset.req];
            item.classList.toggle("is-met", met);
        });

        if (password.length === 0) {
            segments.forEach((seg) => {
                seg.classList.remove("is-filled");
                seg.removeAttribute("data-level");
            });
            if (label) label.textContent = "";
            input.classList.remove("is-invalid", "is-valid");
            return score;
        }

        const {
            key,
            label: levelLabel,
            segments: filled,
        } = strengthLevel(score);
        segments.forEach((seg, i) => {
            const isFilled = i < filled;
            seg.classList.toggle("is-filled", isFilled);
            if (isFilled) seg.dataset.level = key;
            else seg.removeAttribute("data-level");
        });
        if (label) {
            label.textContent = levelLabel;
            label.style.color = {
                weak: "#b3261e",
                fair: "#b8860b",
                good: "#1f7ae0",
                strong: "var(--xv-signal)",
            }[key];
        }
        input.classList.toggle("is-valid", score >= 4);
        input.classList.toggle("is-invalid", false);

        return score;
    }

    input.addEventListener("input", update);
    return {
        getScore: () => passwordScore(input.value).score,
        refresh: update,
    };
}

// === konfirmasi password cocok ==============================================
function initPasswordMatch(container) {
    if (!container) return null;
    const password = container.querySelector("[data-match-password]");
    const confirm = container.querySelector("[data-match-confirm]");
    const note = container.querySelector("[data-match-note]");
    if (!password || !confirm) return null;

    function update() {
        if (!confirm.value) {
            confirm.classList.remove("is-valid", "is-invalid");
            if (note) {
                note.classList.add("hidden");
            }
            return true;
        }
        const matches = password.value === confirm.value;
        confirm.classList.toggle("is-valid", matches);
        confirm.classList.toggle("is-invalid", !matches);
        if (note) {
            note.classList.remove("hidden");
            note.classList.toggle("is-match", matches);
            note.classList.toggle("is-mismatch", !matches);
            note.textContent = matches
                ? "Password cocok"
                : "Password tidak cocok";
        }
        return matches;
    }

    password.addEventListener("input", update);
    confirm.addEventListener("input", update);
    return {
        matches: () =>
            password.value === confirm.value && confirm.value.length > 0,
    };
}

// === submit form yang dilindungi reCAPTCHA (opsional) ======================
// Kalau siteKey kosong, submit jalan normal (cuma nyalain loading state).
function initGuardedSubmit({ form, button, siteKey, action, onBeforeSubmit }) {
    if (!form || !button) return;

    form.addEventListener("submit", function (e) {
        if (typeof onBeforeSubmit === "function") {
            const ok = onBeforeSubmit();
            if (ok === false) {
                e.preventDefault();
                return;
            }
        }

        if (!siteKey) {
            setButtonLoading(button, true);
            return;
        }

        e.preventDefault();
        setButtonLoading(button, true);

        window.grecaptcha.ready(function () {
            window.grecaptcha
                .execute(siteKey, { action })
                .then(function (token) {
                    const field = form.querySelector(
                        'input[name="g-recaptcha-response"]',
                    );
                    if (field) field.value = token;
                    form.submit();
                })
                .catch(function () {
                    setButtonLoading(button, false);
                    showToast(
                        "error",
                        "Verifikasi keamanan gagal, coba lagi.",
                        "Gagal",
                    );
                });
        });
    });
}

// === input kode OTP: angka doang, auto-submit pas genap 6 digit ===========
function initOtpInput({ input, form }) {
    if (!input || !form) return;

    input.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
        if (this.value.length === 6) form.requestSubmit();
    });

    input.addEventListener("paste", function (e) {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData(
            "text",
        );
        const digits = pasted.replace(/[^0-9]/g, "").slice(0, 6);
        this.value = digits;
        if (digits.length === 6) setTimeout(() => form.requestSubmit(), 100);
    });
}

// === countdown buat tombol resend OTP =======================================
function initResendCountdown({ button, countdownEl, seconds = 60 }) {
    if (!button || !countdownEl) return { restart() {} };
    let timeLeft = seconds;
    let timer = null;

    function tick() {
        timeLeft -= 1;
        countdownEl.textContent = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(timer);
            button.disabled = false;
        }
    }

    function restart() {
        clearInterval(timer);
        timeLeft = seconds;
        countdownEl.textContent = timeLeft;
        button.disabled = true;
        timer = setInterval(tick, 1000);
    }

    restart();
    window.addEventListener("beforeunload", () => clearInterval(timer));
    return { restart };
}

// === validasi ringan on-the-fly (email/nama) -- feedback visual doang,
// validasi beneran tetap di server. ==========================================
function initLiveValidation() {
    document.querySelectorAll("[data-validate]").forEach((input) => {
        input.addEventListener("input", function () {
            const value = this.value.trim();
            if (!value) {
                this.classList.remove("is-valid", "is-invalid");
                return;
            }
            const valid =
                this.dataset.validate === "email"
                    ? /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
                    : /^[a-zA-Z\s]{2,}$/.test(value);
            this.classList.toggle("is-valid", valid);
            this.classList.toggle("is-invalid", !valid);
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initPasswordToggles();
    initLiveValidation();

    // Auto-fokus ke input pertama yang masih kosong -- kenyamanan kecil,
    // gak butuh animasi/delay buatan.
    const firstEmpty = document.querySelector("[data-autofocus]");
    if (firstEmpty && !firstEmpty.value) firstEmpty.focus();
});

window.ExavroAuth = {
    showToast,
    setButtonLoading,
    initPasswordStrength,
    initPasswordMatch,
    initGuardedSubmit,
    initOtpInput,
    initResendCountdown,
    passwordScore,
};
