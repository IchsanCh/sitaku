document.addEventListener("DOMContentLoaded", () => {
    initDocsDrawer();
    initCopyButtons();
});

function initDocsDrawer() {
    const toggle = document.getElementById("docs-menu-toggle");
    const close = document.getElementById("docs-close-menu");
    const sidebar = document.getElementById("docs-sidebar");
    const overlay = document.getElementById("docs-overlay");
    if (!toggle || !sidebar || !overlay) return;

    const open = () => {
        sidebar.classList.remove("-translate-x-full");
        sidebar.classList.add("translate-x-0");
        overlay.classList.remove("hidden");
        requestAnimationFrame(() => {
            overlay.classList.remove("opacity-0");
            overlay.classList.add("opacity-100");
        });
    };
    const shut = () => {
        sidebar.classList.remove("translate-x-0");
        sidebar.classList.add("-translate-x-full");
        overlay.classList.remove("opacity-100");
        overlay.classList.add("opacity-0");
        setTimeout(() => overlay.classList.add("hidden"), 300);
    };

    toggle.addEventListener("click", open);
    close?.addEventListener("click", shut);
    overlay.addEventListener("click", shut);
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") shut();
    });
    sidebar.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => {
            if (window.innerWidth < 1024) shut();
        });
    });
}

function initCopyButtons() {
    document.querySelectorAll("[data-xv-copy]").forEach((btn) => {
        const label = btn.querySelector("[data-xv-copy-label]");
        const defaultText = label?.textContent ?? "";
        btn.addEventListener("click", async () => {
            const text = btn.getAttribute("data-xv-copy") || "";
            try {
                await navigator.clipboard.writeText(text);
            } catch {
                return;
            }
            if (label) {
                label.textContent = "Tersalin!";
                setTimeout(() => {
                    label.textContent = defaultText;
                }, 1500);
            }
        });
    });
}
