let relatedSwiperInstance = null;
let ownerCardInstances = [];

const initAllSwipers = () => {
    const relatedContainer = document.querySelector(".related-swiper");
    if (relatedContainer) {
        if (relatedSwiperInstance) relatedSwiperInstance.destroy(true, true);

        relatedSwiperInstance = new Swiper(".related-swiper", {
            pauseOnMouseEnter: true,
            slidesPerView: 2, 
            slidesPerGroup: 2, 
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
                640: { 
                    slidesPerView: 2,
                    slidesPerGroup: 2 
                },
                1024: { 
                    slidesPerView: 4, 
                    slidesPerGroup: 3 
                },
                1400: { 
                    slidesPerView: 5, 
                    slidesPerGroup: 3 
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

        const ins = new Swiper(el, {
            nested: true, // CLAVE: Permite que funcione dentro del swiper padre
            loop: true,
            autoplay: {
                delay: 10000,
                disableOnInteraction: true,
            },
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
