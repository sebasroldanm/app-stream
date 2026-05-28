let relatedSwiperInstance = null;
let ownerCardInstances = [];

const initAllSwipers = () => {
    const relatedContainer = document.querySelector(".related-swiper");
    if (relatedContainer) {
        if (relatedSwiperInstance) relatedSwiperInstance.destroy(true, true);

        const slides = relatedContainer.querySelectorAll(".swiper-slide");
        // El loop de Swiper requiere más slides que el máximo slidesPerView configurado (5 en este caso)
        const canLoop = slides.length > 5;

        relatedSwiperInstance = new Swiper(".related-swiper", {
            pauseOnMouseEnter: true,
            slidesPerView: 2,
            slidesPerGroup: 2,
            spaceBetween: 15,
            loop: canLoop,
            autoplay: canLoop
                ? {
                      delay: 30000,
                      disableOnInteraction: true,
                  }
                : false,
            navigation: {
                nextEl: ".related-models-wrapper .custom-arrow.swiper-button-next",
                prevEl: ".related-models-wrapper .custom-arrow.swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    slidesPerGroup: 2,
                },
                1024: {
                    slidesPerView: 4,
                    slidesPerGroup: 3,
                },
                1400: {
                    slidesPerView: 5,
                    slidesPerGroup: 3,
                },
            },
        });
    }

    ownerCardInstances.forEach((ins) => ins.destroy(true, true));
    ownerCardInstances = [];

    const cardContainers = document.querySelectorAll(".mySwiperOwner");

    cardContainers.forEach((el) => {
        const nextBtn = el.querySelector(".swiper-button-next-owner-info");
        const prevBtn = el.querySelector(".swiper-button-prev-owner-info");

        const settings = JSON.parse(el.getAttribute("data-settings") || "{}");
        const slides = el.querySelectorAll(".swiper-slide");
        const canLoop = slides.length > 1;

        const ins = new Swiper(el, {
            nested: true,
            loop: canLoop,
            autoplay: canLoop
                ? {
                      delay: 10000,
                      disableOnInteraction: true,
                  }
                : false,
            ...settings,
            navigation: {
                nextEl: nextBtn,
                prevEl: prevBtn,
            },
        });
        ownerCardInstances.push(ins);
    });
};

document.addEventListener("DOMContentLoaded", initAllSwipers);

document.addEventListener("livewire:init", () => {
    Livewire.on("init-swiper", () => {
        setTimeout(initAllSwipers, 150);
    });
});
