/**
 * Alpine.js Fullviewer Store and Event Delegation
 * Centralizes photo/video previewing across all dynamic content.
 */

document.addEventListener("alpine:init", () => {
    // 1. Register the global viewer store
    Alpine.store("viewer", {
        active: false,
        type: null, // 'image' | 'video'
        src: "",
        videoSrc: "",
        thumbs: [],
        fullImages: [],
        currentIndex: 0,

        openImage(src, fullImages = [], thumbImages = []) {
            this.type = "image";
            this.src = src;
            this.fullImages = fullImages.length ? fullImages : [src];
            this.thumbs = thumbImages.length ? thumbImages : [src];
            
            // Find current image index
            this.currentIndex = this.fullImages.indexOf(src);
            if (this.currentIndex === -1) {
                // Fallback index matching
                this.currentIndex = this.fullImages.findIndex(img => img.includes(src) || src.includes(img));
                if (this.currentIndex === -1) this.currentIndex = 0;
            }
            
            this.active = true;
            document.body.classList.add("no-scroll");
            
            // Hide scrollToTop button if present
            const swipeUpContainer = document.getElementById("swipeUpContainer");
            if (swipeUpContainer) swipeUpContainer.classList.add("d-none");
        },

        openVideo(src) {
            this.type = "video";
            this.videoSrc = src;
            this.active = true;
            document.body.classList.add("no-scroll");
            
            const swipeUpContainer = document.getElementById("swipeUpContainer");
            if (swipeUpContainer) swipeUpContainer.classList.add("d-none");
        },

        close() {
            this.active = false;
            this.type = null;
            this.src = "";
            this.videoSrc = "";
            this.thumbs = [];
            this.fullImages = [];
            this.currentIndex = 0;
            document.body.classList.remove("no-scroll");
            
            const swipeUpContainer = document.getElementById("swipeUpContainer");
            if (swipeUpContainer) swipeUpContainer.classList.remove("d-none");
        },

        selectThumb(index) {
            if (index < 0 || index >= this.fullImages.length) return;
            this.currentIndex = index;
            
            const thumb = this.thumbs[index];
            const full = this.fullImages[index];
            
            // Instantly show the thumbnail as a fast placeholder
            this.src = thumb;

            // Preload the full resolution image in background
            const tempImg = new Image();
            tempImg.onload = () => {
                // Ensure state hasn't changed before assigning full image
                if (this.currentIndex === index && this.active && this.type === "image") {
                    this.src = full;
                }
            };
            tempImg.src = full;
        }
    });

    // 2. Global Event Delegation
    // Captures all clicks on elements with .fullviewer or #fullviewer-video (even if dynamically loaded)
    document.addEventListener("click", (event) => {
        // Handle images (.fullviewer)
        const imageEl = event.target.closest(".fullviewer");
        if (imageEl && imageEl.tagName === "IMG") {
            event.preventDefault();
            
            const imageSrc = imageEl.getAttribute("data-image_vh") || imageEl.src;
            let fullImages = [];
            let thumbImages = [];
            
            try {
                fullImages = JSON.parse(imageEl.dataset.imagesFull || "[]");
                thumbImages = JSON.parse(imageEl.dataset.imagesThumb || "[]");
            } catch (e) {
                console.error("Error parsing images dataset on .fullviewer element", e);
            }
            
            Alpine.store("viewer").openImage(imageSrc, fullImages, thumbImages);
            return;
        }
        
        // Handle videos (#fullviewer-video)
        const videoEl = event.target.closest("#fullviewer-video");
        if (videoEl) {
            event.preventDefault();
            const videoUrl = videoEl.currentSrc || videoEl.src;
            if (videoUrl) {
                Alpine.store("viewer").openVideo(videoUrl);
            }
        }
    });
});
