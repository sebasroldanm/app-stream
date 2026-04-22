function initializeMasonry() {
    if (typeof $ !== "undefined" && $.fn.masonry) {
        for (let index = 0; index < 3; index++) {
            setTimeout(() => {
                $(".masonry").masonry({
                    itemSelector: ".masonry-item",
                });
            }, 500 * (index * 2));
        }
    }
}
