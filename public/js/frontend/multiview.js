(function () {
    const instances = {};

    window.Livewire.on("initMultiview", function (payload) {
        // En Livewire 3, el payload puede venir directamente o envuelto en un array/detail
        const data = Array.isArray(payload) ? payload[0] : (payload.detail ? (Array.isArray(payload.detail) ? payload.detail[0] : payload.detail) : payload);
        
        console.log("Evento initMultiview recibido:", data);

        setTimeout(() => {
            initMultiviewPlayer(data);
        }, 400);
    });

    function initMultiviewPlayer(data) {
        if (!data || !data.id) {
            console.error("ERROR: Datos invalidos recibidos en initMultiview", data);
            return;
        }

        const ownerId = data.id;
        const elementId = `live-player-${ownerId}`;
        const videoElement = document.getElementById(elementId);

        if (!videoElement) {
            console.error(`ERROR: No se encontró el elemento #${elementId} en el DOM`);
            return;
        }

        const videoSource = data.url;
        
        // Si ya existe una instancia para este owner con la misma URL, no tocamos nada
        if (instances[ownerId] && instances[ownerId].url === videoSource) {
            console.log(`Stream para ${ownerId} ya está activo. Saltando reinicio.`);
            return;
        }

        // Si existe instancia previa (diferente URL o refresh), destruimos
        if (instances[ownerId]) {
            destroyInstance(ownerId);
        }

        console.log(`Inicializando reproductor para ${ownerId}`);
        const poster = data.poster;
        const ratio = data.ratio || "16:9";

        const plyrOptions = {
            controls: [
                "play-large",
                "play",
                "mute",
                "volume",
                "fullscreen",
            ],
            debug: false,
            autoplay: true,
            muted: true,
            volume: 1,
            ratio: ratio,
            poster: poster
        };

        let hls = null;
        let player = null;

        if (Hls.isSupported()) {
            hls = new Hls();
            hls.loadSource(videoSource);
            
            player = new Plyr(videoElement, plyrOptions);
            hls.attachMedia(player.media);

            hls.on(Hls.Events.MANIFEST_PARSED, function () {
                player.play().catch(error => {
                    console.error(`Error al reproducir Multiview [${ownerId}]:`, error);
                });
            });

            hls.on(Hls.Events.ERROR, function (event, errorData) {
                if (errorData.fatal) {
                    switch (errorData.type) {
                        case Hls.ErrorTypes.NETWORK_ERROR:
                            hls.startLoad();
                            break;
                        case Hls.ErrorTypes.MEDIA_ERROR:
                            hls.recoverMediaError();
                            break;
                        default:
                            hls.destroy();
                            break;
                    }
                }
            });
        } else if (videoElement.canPlayType("application/vnd.apple.mpegurl")) {
            videoElement.src = videoSource;
            player = new Plyr(videoElement, plyrOptions);
            player.play();
        }

        instances[ownerId] = { hls, player, url: videoSource };
    }

    function destroyInstance(ownerId) {
        if (instances[ownerId]) {
            if (instances[ownerId].hls) {
                instances[ownerId].hls.destroy();
            }
            if (instances[ownerId].player) {
                instances[ownerId].player.destroy();
            }
            delete instances[ownerId];
        }
    }
})();
