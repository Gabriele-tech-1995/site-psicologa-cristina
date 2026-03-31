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

// scroll navbar
document.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar-custom");

    if (!navbar) return;

    if (window.scrollY > 40) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});

// animazione invio form
document.addEventListener("DOMContentLoaded", function () {
    const successAlert = document.querySelector(".alert-success");
    const toast = document.getElementById("toast");

    if (successAlert && toast) {
        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);
    }
});

// scroll fluido anchor
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        const target = document.querySelector(this.getAttribute("href"));

        if (target) {
            e.preventDefault();
            target.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    });
});
