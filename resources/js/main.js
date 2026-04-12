import Modal from "bootstrap/js/dist/modal";
import Offcanvas from "bootstrap/js/dist/offcanvas";

// Chiusura drawer mobile: non usare data-bs-dismiss sui <a> — Bootstrap fa preventDefault() e blocca href (tel, link, WhatsApp).
document.addEventListener("DOMContentLoaded", () => {
    const panel = document.getElementById("navOffcanvas");
    if (!panel) return;

    /* Blocca lo scroll della pagina sotto: Bootstrap mette overflow sul body, ma qui
       body ha overflow-x:visible!important — servono html + override espliciti. */
    panel.addEventListener("show.bs.offcanvas", () => {
        document.documentElement.classList.add("nav-offcanvas-open");
    });
    panel.addEventListener("hidden.bs.offcanvas", () => {
        document.documentElement.classList.remove("nav-offcanvas-open");
    });

    panel.addEventListener(
        "click",
        (e) => {
            const link = e.target.closest("a[href]");
            if (!link || !panel.contains(link)) return;
            const inst = Offcanvas.getInstance(panel);
            if (inst) inst.hide();
        },
        true,
    );
});

// animazione reveal
document.addEventListener("DOMContentLoaded", function () {
    const elements = document.querySelectorAll(".reveal");

    if (!elements.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.12,
        },
    );

    elements.forEach((el) => observer.observe(el));
});

// scroll navbar (throttled via requestAnimationFrame)
document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector(".navbar-custom");
    if (!navbar) return;

    const footer = document.querySelector(".footer-minimal");

    let ticking = false;
    const onScroll = () => {
        if (!ticking) {
            ticking = true;
            window.requestAnimationFrame(() => {
                // Sotto lg: niente stato "scrolled" (padding/ombra) così lo scroll della home non "balla" la barra.
                if (window.innerWidth < 992) {
                    navbar.classList.remove("scrolled");
                    navbar.classList.remove("navbar-over-footer");
                    ticking = false;
                    return;
                }

                const scrolled = window.scrollY > 40;
                navbar.classList.toggle("scrolled", scrolled);

                if (footer) {
                    const navBottom = navbar.getBoundingClientRect().bottom;
                    const footerTop = footer.getBoundingClientRect().top;
                    navbar.classList.toggle(
                        "navbar-over-footer",
                        scrolled && footerTop < navBottom + 6,
                    );
                } else {
                    navbar.classList.remove("navbar-over-footer");
                }

                ticking = false;
            });
        }
    };

    document.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll, { passive: true });
    onScroll();
});

// Popup feedback dopo invio modulo contatti (success / warning mail).
function initContactFeedbackModal() {
    const el = document.getElementById("contactFormFeedbackModal");
    if (!el) return;

    el.addEventListener("show.bs.modal", () => {
        document.body.classList.add("contact-feedback-modal-open");
    });
    el.addEventListener("hidden.bs.modal", () => {
        document.body.classList.remove("contact-feedback-modal-open");
    });

    const show = () =>
        Modal.getOrCreateInstance(el, {
            backdrop: "static",
            keyboard: false,
        }).show();

    // Con script type=module il DOM può essere già "interactive"/"complete": in quel caso
    // DOMContentLoaded non scatta più e il listener non verrebbe mai eseguito.
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", () => requestAnimationFrame(show));
    } else {
        requestAnimationFrame(show);
    }
}

initContactFeedbackModal();

// Scroll morbido verso ancore interne (dopo il DOM; id con caratteri speciali tramite CSS.escape).
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            const raw = this.getAttribute("href");
            if (!raw || raw === "#" || raw.length < 2) {
                return;
            }

            const id = raw.slice(1);
            let target = null;
            try {
                target = document.querySelector(`#${CSS.escape(id)}`);
            } catch {
                return;
            }

            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });
});

// tracking eventi base (compatibile con GA4 se presente)
document.addEventListener("DOMContentLoaded", () => {
    const emitTrackEvent = (eventName) => {
        if (!eventName) return;

        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: "ui_interaction",
            action: eventName,
            page_path: window.location.pathname,
        });

        if (typeof window.gtag === "function") {
            window.gtag("event", eventName, {
                event_category: "engagement",
                page_path: window.location.pathname,
            });
        }
    };

    document.querySelectorAll("[data-track]").forEach((el) => {
        el.addEventListener("click", () => emitTrackEvent(el.dataset.track));
    });

    document.querySelectorAll("form[data-track-submit]").forEach((form) => {
        form.addEventListener("submit", () =>
            emitTrackEvent(form.dataset.trackSubmit),
        );
    });
});
