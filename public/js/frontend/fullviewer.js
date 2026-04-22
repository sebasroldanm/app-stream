function initFullviewer() {
    // Seleccionar la imagen en miniatura y el modal
    const imagenes = document.querySelectorAll(".fullviewer");
    const modal = document.getElementById("viewer_photo");
    const imagenModal = document.getElementById("imagenModal");
    const cerrarBtn = document.querySelector(".cerrar");
    const swipeUpContainer = document.getElementById("swipeUpContainer");

    if (!modal) return;

    imagenes.forEach((imagen) => {
        imagen.addEventListener("click", () => {
            const imageSrc = imagen.getAttribute("data-image_vh") || imagen.src;
            imagenModal.src = imageSrc;

            swipeUpContainer.classList.add("d-none");

            const fullImages = JSON.parse(imagen.dataset.imagesFull || "[]");
            const thumbImages = JSON.parse(imagen.dataset.imagesThumb || "[]");

            construirThumbs(thumbImages, fullImages, imageSrc);

            modal.style.display = "block";
            document.body.classList.add("no-scroll");
        });
    });

    if (cerrarBtn) {
        cerrarBtn.addEventListener("click", () => {
            modal.style.display = "none";
            document.body.classList.remove("no-scroll");
            swipeUpContainer.classList.remove("d-none");
        });
    }

    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
            document.body.classList.remove("no-scroll");
            swipeUpContainer.classList.remove("d-none");
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            modal.style.display = "none";
            document.body.classList.remove("no-scroll");
            swipeUpContainer.classList.remove("d-none");
        }
    });


}

function construirThumbs(thumbImages, fullImages, currentImageSrc) {
    const thumbsContainer = document.getElementById("thumbs");
    const imagenModal = document.getElementById("imagenModal");
    if (!thumbsContainer) return;
    
    thumbsContainer.innerHTML = ""; // limpiar thumbs previos

    thumbImages.forEach((thumb, index) => {
        const full = fullImages[index];

        const img = document.createElement("img");
        img.classList.add("thumb-item");
        img.src = thumb;
        img.dataset.imageFull = full;

        // Marcar la imagen actualmente visible
        if (full === currentImageSrc) {
            img.classList.add("active");
        }

        // Click en el thumb → cambia la imagen del modal
        img.addEventListener("click", () => {
            // Actualizar estado visual
            document
                .querySelectorAll(".thumb-item")
                .forEach((el) => el.classList.remove("active"));

            img.classList.add("active");

            // Primero mostrar el thumb mientras carga la Full
            imagenModal.src = thumb;

            // Cargar la Full en memoria
            const tempImg = new Image();
            tempImg.onload = () => {
                imagenModal.src = full;
            };
            tempImg.src = full;
        });

        thumbsContainer.appendChild(img);
    });
}
