function initializeMasonry() {
    setTimeout(() => {
        if (typeof $ !== "undefined" && $.fn.masonry) {
            $(".masonry").masonry({
                itemSelector: ".masonry-item",
            });
        }
    }, 500);
}

function reloadExplorer() {
    console.log("reloadExplorer");

    const cards = document.querySelectorAll(".card_explorer_image");

    cards.forEach((card) => {
        const imageContainer = card.querySelector(".image-container");
        const seePicExp = card.querySelector(".see_pic_exp");

        if (imageContainer) {
            imageContainer.addEventListener("mouseenter", () => {
                imageContainer.classList.add("show-secondary");
            });
            imageContainer.addEventListener("mouseleave", () => {
                imageContainer.classList.remove("show-secondary");
            });
        }

        if (seePicExp && imageContainer) {
            seePicExp.addEventListener("mouseenter", () => {
                imageContainer.classList.add("show-tertiary");
            });
            seePicExp.addEventListener("mouseleave", () => {
                imageContainer.classList.remove("show-tertiary");
            });
        }
    });
}
