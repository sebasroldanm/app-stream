(function () {
    let player = null;
    let hls = null;

    window.Livewire.on("initLive", function (data) {
        // Pequeño delay para asegurar que el DOM esté listo tras el render de Livewire
        setTimeout(() => {
            initLivePlayer(data[0]);
        }, 200);
    });

    function initLivePlayer(data) {
        console.log("Iniciando reproductor LIVE", data);
        
        const videoElement = document.getElementById("live-player");
        if (!videoElement) {
            console.error("ERROR: No se encontró el elemento #live-player en el DOM");
            return;
        }

        const videoSource = data.url;
        const poster = data.cover;
        const height = data.height;
        const width = data.width;
        const ratio = data.ratio;

        // Limpieza robusta de instancias previas
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

        // Plyr Options
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
            muted: true, // Autoplay generalmente requiere mute
            volume: 1,
            ratio: "16:9",
            poster: poster
        };

        if (Hls.isSupported()) {
            console.log("HLS es soportado, inicializando para Live...");
            hls = new Hls();
            hls.loadSource(videoSource);
            
            // Inicializar Plyr antes de atachar HLS para que Plyr tome control del tag
            player = new Plyr(videoElement, plyrOptions);
            hls.attachMedia(player.media);

            hls.on(Hls.Events.MANIFEST_PARSED, function () {
                console.log("HLS: Manifiesto cargado, intentando reproducir Live");
                player.play().catch(error => {
                    console.error("Error al intentar reproducir Live:", error);
                });
            });

            hls.on(Hls.Events.ERROR, function (event, data) {
                 if (data.fatal) {
                    switch (data.type) {
                        case Hls.ErrorTypes.NETWORK_ERROR:
                            console.error("Fatal network error encountered, trying to recover");
                            hls.startLoad();
                            break;
                        case Hls.ErrorTypes.MEDIA_ERROR:
                            console.error("Fatal media error encountered, trying to recover");
                            hls.recoverMediaError();
                            break;
                        default:
                            console.error("Fatal error, cannot recover");
                            hls.destroy();
                            break;
                    }
                }
            });

        } else if (videoElement.canPlayType("application/vnd.apple.mpegurl")) {
            console.log("HLS nativo detectado (Safari)");
            videoElement.src = videoSource;
            player = new Plyr(videoElement, plyrOptions);
            player.play();
        } else {
            console.error("Formato no soportado para Live en este navegador");
            // Mostrar mensaje de error en UI si es necesario
            const errorMsg = document.getElementById('error-message');
            if(errorMsg) errorMsg.style.display = 'block';
        }
    }
})();
