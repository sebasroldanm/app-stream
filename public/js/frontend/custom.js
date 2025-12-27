window.Livewire.on("playVideo", function (data) {
    initializeVideoPlayer(data[0]);
});

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



Livewire.on('themeApp', ({ theme }) => {
    console.log("Nuevo tema:", theme);
    document.documentElement.dataset.theme = theme;
});

// Listen for system theme changes if no user preference is set
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    // Only update if the user hasn't manually set a theme (we assume manual set creates a session/cookie, 
    // but here we check if the html attribute might match the old system pref or just rely on 'if we want to be smart'. 
    // Actually, getting the session from JS is hard. 
    // We'll trust that if the user cares, they toggled it. 
    // But for a pure "system default" experience, live updating is nice.
    // We'll check if the backend supplied a specific theme? No.
    // Let's just update strictly if we are in "auto" mode? 
    // We don't have an "auto" mode flag. 
    // We'll skip this for now to avoid overwriting manual choices, OR we check if document.documentElement.dataset.theme was set by us initially?
    // Let's keep it simple and safe: ONLY log it or do nothing to avoid fighting the user's manual toggle.
    // The user asked for "default value", not necessarily live sync.
    // I will skip the live listener to be safe and strictly follow the "default value" request.
    console.log("System theme changed to:", event.matches ? "dark" : "light");
});

scrollToTop();

initFullviewer();

var player = null;
var hls = null;

function initializeVideoPlayer(video) {
    console.log("Iniciando reproductor de video", video);
    $("#event_trailer").click();

    setTimeout(() => {
        const videoElement = document.getElementById("player");
        if (!videoElement) {
            console.error("ERROR: No se encontró el elemento #player en el DOM");
            return;
        }

        var videoFormat = video.format;
        var videoSource = video.url;

        console.log("Formato:", videoFormat, "Source:", videoSource);

        // Destruir instancias previas
        if (hls) {
            console.log("Destruyendo instancia HLS previa");
            hls.destroy();
            hls = null;
        }
        if (player) {
            console.log("Destruyendo instancia Plyr previa");
            player.destroy();
            player = null;
        }

        const plyrOptions = {
            controls: [
                "play-large",
                "play",
                "rewind",
                "fast-forward",
                ...(videoFormat === "live" ? [] : ["progress"]),
                "current-time",
                "duration",
                "mute",
                "volume",
                "fullscreen",
            ],
            debug: true,
            autoplay: true,
            muted: true,
            volume: 1,
            seekTime: 10,
            ratio: "16:9",
        };

        if (videoFormat === "m3u8" || videoFormat === "live") {
            if (Hls.isSupported()) {
                console.log("HLS es soportado, inicializando...");
                hls = new Hls();
                hls.loadSource(videoSource);
                
                player = new Plyr(videoElement, plyrOptions);
                hls.attachMedia(player.media);

                hls.on(Hls.Events.MANIFEST_PARSED, function () {
                    console.log("HLS: Manifiesto cargado, intentando reproducir");
                    player.play().catch(error => {
                        console.error("Error al intentar reproducir:", error);
                    });
                });

                hls.on(Hls.Events.ERROR, function (event, data) {
                    if (data.fatal) {
                        console.error("Error FATAL de HLS:", data);
                    } else {
                        console.warn("Error de HLS:", data);
                    }
                });
            } else if (videoElement.canPlayType("application/vnd.apple.mpegurl")) {
                console.log("HLS nativo (Safari?) detectado");
                videoElement.src = videoSource;
                player = new Plyr(videoElement, plyrOptions);
                player.play();
            } else {
                console.error("ERROR: Formato no soportado en este navegador");
            }
        } else if (videoFormat === "mp4") {
            console.log("Inicializando MP4");
            videoElement.src = videoSource;
            player = new Plyr(videoElement, plyrOptions);
            player.play();
        }
    }, 200); // Pequeño delay para asegurar que Livewire insertó el DOM
}

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