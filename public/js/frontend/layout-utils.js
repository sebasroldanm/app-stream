function initializeMasonry() {
    setTimeout(() => {
        if (typeof $ !== "undefined" && $.fn.masonry) {
            $(".masonry").masonry({
                itemSelector: ".masonry-item",
            });
        }
    }, 500);
}
