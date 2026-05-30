/**
 * Alpine.js Masonry Integration and Layout Utilities
 */

document.addEventListener("alpine:init", () => {
    Alpine.data("masonry", () => ({
        msnry: null,
        observer: null,

        init() {
            this.$nextTick(() => {
                this.initialize();
                this.bindImages();

                this.observer = new MutationObserver(() => {
                    this.bindImages();
                    this.layout();
                });
                this.observer.observe(this.$el, {
                    childList: true,
                    subtree: true,
                });
            });
        },

        initialize() {
            if (typeof Masonry !== "undefined") {
                this.msnry = new Masonry(this.$el, {
                    itemSelector: ".masonry-item",
                    percentPosition: true,
                });
            } else if (typeof $ !== "undefined" && $.fn.masonry) {
                $(this.$el).masonry({
                    itemSelector: ".masonry-item",
                });
            }
        },

        bindImages() {
            const images = this.$el.querySelectorAll("img");
            images.forEach((img) => {
                if (img.dataset.masonryListenerAdded) return;
                img.dataset.masonryListenerAdded = "true";

                if (img.complete) {
                    this.layout();
                } else {
                    img.addEventListener("load", () => this.layout());
                    img.addEventListener("error", () => this.layout());
                }
            });
        },

        layout() {
            this.$nextTick(() => {
                if (this.msnry) {
                    this.msnry.layout();
                } else if (typeof $ !== "undefined" && $.fn.masonry) {
                    $(this.$el).masonry("layout");
                }
            });
        },

        destroy() {
            if (this.observer) this.observer.disconnect();
            if (this.msnry) {
                if (typeof this.msnry.destroy === "function") {
                    this.msnry.destroy();
                }
            }
        },
    }));
});
