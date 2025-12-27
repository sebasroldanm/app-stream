window.Livewire.on("initMasonry", function (data) {
    initializeMasonry();
    initFullviewer();
});

window.Livewire.on("initExplorer", function (data) {
    setTimeout(() => {
        reloadExplorer();
    }, 500);
});

window.addEventListener("initFullviewer", () => {
    setTimeout(() => {
        initFullviewer();
    }, 500);
});

function initializeMasonry(item) {
    setTimeout(() => {
        $(".masonry").masonry({
            itemSelector: ".masonry-item",
        });
    }, 500);
}

function reloadExplorer() {
    console.log("reloadExplorer");

    const cards = document.querySelectorAll(".card_explorer_image");

    cards.forEach((card) => {
        const imageContainer = card.querySelector(".image-container");
        const seePicExp = card.querySelector(".see_pic_exp");

        imageContainer.addEventListener("mouseenter", () => {
            imageContainer.classList.add("show-secondary");
        });
        imageContainer.addEventListener("mouseleave", () => {
            imageContainer.classList.remove("show-secondary");
        });

        seePicExp.addEventListener("mouseenter", () => {
            imageContainer.classList.add("show-tertiary");
        });
        seePicExp.addEventListener("mouseleave", () => {
            imageContainer.classList.remove("show-tertiary");
        });
    });
}

function scrollToTop() {
    const scrollToTopButton = document.getElementById("scrollToTop");

    // Mostrar el botón solo si el usuario ha hecho scroll hacia abajo
    window.onscroll = function () {
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {
            scrollToTopButton.style.display = "block"; // Mostrar el botón
        } else {
            scrollToTopButton.style.display = "none"; // Ocultar el botón
        }
    };

    // Cuando el usuario haga clic en el botón, desplazarse al principio de la página
    scrollToTopButton.onclick = function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
    };
}

function initFullviewer() {
    // Seleccionar la imagen en miniatura y el modal
    const imagenes = document.querySelectorAll(".fullviewer");
    const modal = document.getElementById("viewer_photo");
    const imagenModal = document.getElementById("imagenModal");
    const cerrarBtn = document.querySelector(".cerrar");

    imagenes.forEach((imagen) => {
        imagen.addEventListener("click", () => {

            const imageSrc = imagen.getAttribute("data-image_vh") || imagen.src;
            imagenModal.src = imageSrc;

            const fullImages  = JSON.parse(imagen.dataset.imagesFull || "[]");
            const thumbImages = JSON.parse(imagen.dataset.imagesThumb || "[]");

            construirThumbs(thumbImages, fullImages, imageSrc);

            modal.style.display = "block";
            document.body.classList.add("no-scroll");
        });
    });

    cerrarBtn.addEventListener("click", () => {
        modal.style.display = "none";
        document.body.classList.remove("no-scroll");
    });

    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
            document.body.classList.remove("no-scroll");
        }
    });
}

function construirThumbs(thumbImages, fullImages, currentImageSrc) {
    const thumbsContainer = document.getElementById("thumbs");
    const imagenModal = document.getElementById("imagenModal");
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
            document.querySelectorAll(".thumb-item")
                .forEach(el => el.classList.remove("active"));

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




searchGlobe();

function searchGlobe() {
    let debounceTimer;

    document.getElementById("searchGlobe").addEventListener("input", function(e) {
        const value = e.target.value.trim();

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {

            // Si está vacío, limpiar resultados y no consultar
            if (!value) {
                document.getElementById("resultSearch").innerHTML = "";
                return;
            }

            fetch("/search?q=" + encodeURIComponent(value))
                .then(r => r.json())
                .then(data => {
                    console.log("API Response:", data);
                    renderResults(data.models || []);
                })
                .catch(err => console.error(err));

        }, 500);
    });
}

function renderResults(models) {
    const container = document.getElementById("resultSearch");

    // Si no hay resultados
    if (!models || models.length === 0) {
        container.innerHTML = "<p>No hay resultados</p>";
        return;
    }

    // Construcción del HTML
    let html = `
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Owners</h4>
            </div>
        </div>
        <div class="card-body">
            <ul class="media-story list-inline m-0 p-0">
    `;

    models.forEach(model => {
        html += `
            <li class="d-flex mb-1 align-items-center">
                <img src="${model.avatarUrl}" 
                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=${model.username}';"
                     alt="story-img" 
                     class="rounded-circle img-fluid">
                <div class="stories-data ms-3">
                    <h5>
                        <a href="/owner/${model.username}" >${model.username}</a>
                    </h5>
                </div>
            </li>
        `;
    });

    html += `
            </ul>
        </div>
    `;

    container.innerHTML = html;
}

initSwiper();

window.Livewire.on("initSwiper", function () {
    setTimeout(() => {
        initSwiper();
    }, 1);
});

function initSwiper() {
    console.log('initSwiper');

    var swiperContainer = document.querySelector('.related-swiper');
    if (swiperContainer && swiperContainer.swiper) {
        console.log('Swiper already initialized, skipping');
        return;
    }

    new Swiper('.related-swiper', {
        slidesPerView: 3,
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 5,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 6,
                spaceBetween: 20,
            },
        },
    });
}