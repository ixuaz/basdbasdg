function scrollToTop() {
    window.scrollTo({ top: 0, behavior: "smooth" });
}

document.documentElement.classList.add("js-ready");

document.addEventListener("DOMContentLoaded", function () {
    // Borang demo memaparkan makluman dan tidak menghantar data.
    const demoForms = document.querySelectorAll(".demo-form");
    demoForms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            alert(form.dataset.message);
            form.reset();
        });
    });

    // Tunjuk emoji sementara jika foto galeri belum dimasukkan.
    const galleryImages = document.querySelectorAll(".gallery-photo img");
    galleryImages.forEach(function (image) {
        function showFallback() {
            image.hidden = true;
            const fallback = image.nextElementSibling;
            if (fallback) fallback.hidden = false;
        }
        image.addEventListener("error", showFallback);
        if (image.complete && image.naturalWidth === 0) showFallback();
    });

    // Animasi ringkas apabila kad masuk ke dalam paparan.
    const items = document.querySelectorAll(".reveal");
    if ("IntersectionObserver" in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-visible");
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        items.forEach(function (item) { observer.observe(item); });
    } else {
        items.forEach(function (item) { item.classList.add("is-visible"); });
    }
});
