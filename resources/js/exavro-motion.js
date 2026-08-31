/**
 * EXAVRO public-site motion.
 *
 * Same lazy-load philosophy as lazy-aos.js: gsap + ScrollTrigger are only
 * downloaded (dynamic import, own Vite chunk) if the page actually has
 * [data-xv-*] motion hooks, and only after window 'load' so it never
 * competes with critical rendering. Replaces data-aos on the pages that
 * have been migrated to the EXAVRO design system (home/about/pricing);
 * lazy-aos.js keeps serving pages that haven't been migrated yet (auth).
 *
 * Every animation is skipped in favor of the final visible state when the
 * visitor has prefers-reduced-motion: reduce.
 */
export function initExavroMotionIfNeeded() {
    const hasMotionHooks = document.querySelector(
        "[data-xv-hero-item], [data-xv-reveal], [data-xv-stagger-group], [data-xv-faq]",
    );
    if (!hasMotionHooks) {
        return;
    }

    const load = () => {
        Promise.all([import("gsap"), import("gsap/ScrollTrigger")]).then(
            ([{ default: gsap }, { ScrollTrigger }]) => {
                gsap.registerPlugin(ScrollTrigger);
                run(gsap);
            },
        );
    };

    if (document.readyState === "complete") {
        load();
    } else {
        window.addEventListener("load", load, { once: true });
    }
}

function run(gsap) {
    const mm = gsap.matchMedia();

    // --- motion-safe branch ---
    mm.add("(prefers-reduced-motion: no-preference)", () => {
        const heroItems = gsap.utils.toArray("[data-xv-hero-item]");
        if (heroItems.length) {
            gsap.from(heroItems, {
                opacity: 0,
                y: 14,
                duration: 0.5,
                ease: "power1.out",
                stagger: 0.08,
            });
        }

        gsap.utils.toArray("[data-xv-reveal]").forEach((el) => {
            gsap.from(el, {
                opacity: 0,
                y: 16,
                duration: 0.4,
                ease: "power1.out",
                scrollTrigger: {
                    trigger: el,
                    start: "top 88%",
                    toggleActions: "play none none reverse",
                },
            });
        });

        gsap.utils.toArray("[data-xv-stagger-group]").forEach((group) => {
            const items = group.querySelectorAll("[data-xv-stagger-item]");
            if (!items.length) return;
            gsap.from(items, {
                opacity: 0,
                y: 12,
                duration: 0.35,
                ease: "power1.out",
                stagger: 0.06,
                scrollTrigger: {
                    trigger: group,
                    start: "top 85%",
                    toggleActions: "play none none reverse",
                },
            });
        });
    });

    // --- reduced-motion branch: snap straight to the end state ---
    mm.add("(prefers-reduced-motion: reduce)", () => {
        gsap.set(
            "[data-xv-hero-item], [data-xv-reveal], [data-xv-stagger-item]",
            { opacity: 1, y: 0 },
        );
    });

    initFaqAccordion(gsap);
}

/**
 * Progressive-enhancement accordion: without JS every panel is already
 * visible (height: auto in CSS), so the FAQ stays fully readable. With JS,
 * all but the first panel collapse on init and gsap animates height
 * (including the -> 'auto' resize on open, which GSAP measures natively)
 * instead of the old instant <details> snap.
 */
function initFaqAccordion(gsap) {
    const items = document.querySelectorAll("[data-xv-faq]");
    if (!items.length) return;

    const reduced = window.matchMedia(
        "(prefers-reduced-motion: reduce)",
    ).matches;
    const duration = reduced ? 0 : 0.4;

    items.forEach((item, index) => {
        const trigger = item.querySelector("[data-xv-faq-trigger]");
        const panel = item.querySelector("[data-xv-faq-panel]");
        const plus = item.querySelector(".xv-faq-plus");
        if (!trigger || !panel) return;

        const isDefaultOpen = index === 0;
        trigger.setAttribute("aria-expanded", String(isDefaultOpen));
        if (!isDefaultOpen) {
            gsap.set(panel, { height: 0, overflow: "hidden" });
        }
        item.classList.toggle("is-open", isDefaultOpen);

        trigger.addEventListener("click", () => {
            const isOpen = trigger.getAttribute("aria-expanded") === "true";
            if (isOpen) {
                collapse(item, trigger, panel, plus);
                return;
            }
            items.forEach((other) => {
                if (other === item) return;
                const otherTrigger = other.querySelector(
                    "[data-xv-faq-trigger]",
                );
                if (otherTrigger?.getAttribute("aria-expanded") === "true") {
                    collapse(
                        other,
                        otherTrigger,
                        other.querySelector("[data-xv-faq-panel]"),
                        other.querySelector(".xv-faq-plus"),
                    );
                }
            });
            expand(item, trigger, panel, plus);
        });
    });

    function expand(item, trigger, panel, plus) {
        trigger.setAttribute("aria-expanded", "true");
        item.classList.add("is-open");
        gsap.set(panel, { overflow: "hidden" });
        gsap.to(panel, {
            height: "auto",
            duration,
            ease: "power2.inOut",
            onComplete: () => gsap.set(panel, { overflow: "visible" }),
        });
        if (plus) gsap.to(plus, { rotate: 45, duration, ease: "power2.inOut" });
    }

    function collapse(item, trigger, panel, plus) {
        trigger.setAttribute("aria-expanded", "false");
        item.classList.remove("is-open");
        gsap.set(panel, { overflow: "hidden" });
        gsap.to(panel, { height: 0, duration, ease: "power2.inOut" });
        if (plus) gsap.to(plus, { rotate: 0, duration, ease: "power2.inOut" });
    }
}
