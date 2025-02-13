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

window.addEventListener("initVideosFeed", () => {
    setTimeout(() => {
        console.log("initVideosFeed");
        initVideosFeed();
    }, 500);
});

scrollToTop();

initFullviewer();

function initializeVideoPlayer(video) {
    console.log("Livewire emitió el evento videoLoaded");
    $("#event_trailer").click();

    var videoFormat = video.format; // Por ejemplo: 'm3u8', 'mp4' o 'live;
    var videoSource = video.url;

    if (player && typeof player.destroy === "function") {
        player.destroy();
    }

    player = new Plyr("#player", {
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
        debug: false,
        autoplay: true,
        muted: true,
        volume: 1,
        seekTime: 10,
        ratio: "16:9",
        storage: {
            enabled: true,
            key: "plyr",
        },
    });

    if (videoFormat === "m3u8") {
        if (Hls.isSupported()) {
            hls = new Hls();
            hls.loadSource(videoSource);
            hls.attachMedia(player.media);

            hls.on(Hls.Events.MANIFEST_PARSED, function () {
                player.play();
            });
        } else if (player.media.canPlayType("application/vnd.apple.mpegurl")) {
            player.source = {
                type: "video",
                sources: [
                    {
                        src: videoSource,
                        type: "application/x-mpegURL",
                    },
                ],
            };
            player.play();
        } else {
            console.error("Formato de video no soportado para HLS");
        }
    } else if (videoFormat === "mp4") {
        player.source = {
            type: "video",
            sources: [
                {
                    src: videoSource,
                    type: "video/mp4",
                },
            ],
        };
    } else if (videoFormat === "live") {
        if (Hls.isSupported()) {
            hls = new Hls();
            hls.loadSource(videoSource);
            hls.attachMedia(player.media);

            const errorMessage = document.getElementById("error-message");

            hls.on(Hls.Events.MANIFEST_PARSED, function () {
                player.play();
            });
            // Escuchar errores para verificar si la respuesta no es 200
            hls.on(Hls.Events.ERROR, function (event, data) {
                console.log("Error de HLS:", data);

                if (data.type === Hls.ErrorTypes.NETWORK_ERROR) {
                    if (data.response && data.response.code !== 200) {
                        console.log(
                            "Error de carga: código de respuesta HTTP:",
                            data.response.code
                        );
                        errorMessage.style.display = "block";
                    } else {
                        console.log(
                            "Error de red al cargar el m3u8:",
                            data.details
                        );
                        errorMessage.style.display = "block";
                    }
                }
            });
        } else if (player.media.canPlayType("application/vnd.apple.mpegurl")) {
            player.source = {
                type: "video",
                sources: [
                    {
                        src: videoSource,
                        type: "application/x-mpegURL",
                    },
                ],
            };
            player.play();
        } else {
            console.error("Formato de video no soportado:", videoFormat);
        }
    } else {
        console.error("Formato de video no soportado:", videoFormat);
    }
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

    // Añadir un evento de clic a cada imagen en miniatura
    imagenes.forEach((imagen) => {
        imagen.addEventListener("click", () => {
            // Asignar la fuente de la imagen en miniatura al modal
            const imageSrc = imagen.getAttribute("data-image_vh") || imagen.src;
            imagenModal.src = imageSrc;

            // Mostrar el modal
            modal.style.display = "block";
            document.body.classList.add("no-scroll");
        });
    });

    // Añadir un evento de clic al botón de cierre
    cerrarBtn.addEventListener("click", () => {
        modal.style.display = "none";
        document.body.classList.remove("no-scroll");
    });

    // Cerrar el modal si se hace clic fuera de la imagen
    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
            document.body.classList.remove("no-scroll");
        }
    });
}

function initVideosFeed() {
    // Selecciona todos los videos con la clase .video_feed
    const videos = document.querySelectorAll(".video_feed");

    videos.forEach((videoElement) => {
        const videoFormat = videoElement.dataset.format; // Formato de video, ej: 'm3u8', 'mp4', 'live'
        const videoSource = videoElement.dataset.video; // URL del video

        // Crea un nuevo reproductor Plyr para cada video sin autoplay
        const player = new Plyr(videoElement, {
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
            debug: false,
            autoplay: false, // Desactiva la reproducción automática
            muted: true,
            volume: 1,
            seekTime: 10,
            ratio: "16:9",
            storage: {
                enabled: true,
                key: "plyr",
            },
        });

        // Configura la fuente del video en base al formato
        if (videoFormat === "m3u8") {
            if (Hls.isSupported()) {
                const hls = new Hls();
                hls.loadSource(videoSource);
                hls.attachMedia(videoElement);
                // Remueve la reproducción automática
            } else if (
                videoElement.canPlayType("application/vnd.apple.mpegurl")
            ) {
                player.source = {
                    type: "video",
                    sources: [
                        {
                            src: videoSource,
                            type: "application/x-mpegURL",
                        },
                    ],
                };
            } else {
                console.error("Formato de video no soportado para HLS");
            }
        } else if (videoFormat === "mp4") {
            player.source = {
                type: "video",
                sources: [
                    {
                        src: videoSource,
                        type: "video/mp4",
                    },
                ],
            };
        }
    });
}
