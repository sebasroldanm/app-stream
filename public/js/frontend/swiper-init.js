let swiperInstance = null;

const initSwiper = () => {
    const container = document.querySelector(".related-swiper");
    if (!container) return;

    if (swiperInstance) {
        swiperInstance.destroy(true, true);
    }

    swiperInstance = new Swiper(".related-swiper", {
        pauseOnMouseEnter: true,
        slidesPerView: 2,
        spaceBetween: 15,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: { slidesPerView: 3 },
            1024: { slidesPerView: 5 },
            1400: { slidesPerView: 6 },
        },
    });
};

// Inicialización inicial
initSwiper();

// Integración con Livewire
if (window.Livewire) {
    window.Livewire.on("init-swiper-related", () => {
        setTimeout(() => {
            initSwiper();
        }, 100);
    });
} else {
    document.addEventListener("livewire:init", () => {
        Livewire.on("init-swiper-related", () => {
            setTimeout(() => {
                initSwiper();
            }, 100);
        });
    });
}
