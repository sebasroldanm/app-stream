let relatedSwiperInstance = null;
let ownerCardInstances = [];

const initAllSwipers = () => {
    // 1. INIT (Related Models)
    const relatedContainer = document.querySelector(".related-swiper");
    if (relatedContainer) {
        if (relatedSwiperInstance) relatedSwiperInstance.destroy(true, true);

        relatedSwiperInstance = new Swiper(".related-swiper", {
            pauseOnMouseEnter: true,
            slidesPerView: 2,
            spaceBetween: 15,
            loop: true,
            autoplay: {
                delay: 30000,
                disableOnInteraction: true,
            },
            navigation: {
                nextEl: ".related-models-wrapper .custom-arrow.swiper-button-next",
                prevEl: ".related-models-wrapper .custom-arrow.swiper-button-prev",
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 4 },
                1400: { slidesPerView: 5 },
            },
        });
    }

    // 2. INIT (Images of the owner)
    // Primero destruimos instancias previas para evitar fugas de memoria
    ownerCardInstances.forEach((ins) => ins.destroy(true, true));
    ownerCardInstances = [];

    const cardContainers = document.querySelectorAll(".mySwiperOwner");

    cardContainers.forEach((el) => {
        // Buscamos los botones de navegación ESPECÍFICOS de esta card
        // Esto evita que al hacer clic en una card se muevan todas
        const nextBtn = el.querySelector(".swiper-button-next-owner-info");
        const prevBtn = el.querySelector(".swiper-button-prev-owner-info");

        const ins = new Swiper(el, {
            nested: true, // CLAVE: Permite que funcione dentro del swiper padre
            loop: true,
            autoplay: {
                delay: 10000,
                disableOnInteraction: true,
            },
            allowTouchMove: false,
            simulateTouch: false,
            navigation: {
                nextEl: nextBtn,
                prevEl: prevBtn,
            },
        });
        ownerCardInstances.push(ins);
    });
};

// Initialisation
document.addEventListener("DOMContentLoaded", initAllSwipers);

// Integration with Livewire (Optimized)
document.addEventListener("livewire:init", () => {
    Livewire.on("init-swiper", () => {
        setTimeout(initAllSwipers, 150);
    });
});
