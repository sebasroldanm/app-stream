/**
 * Componente de Video Reutilizable
 * Gestiona la carga diferida de videos Plyr con soporte HLS.
 */

window.initVideoComponent = function(container, videoUrl, videoFormat) {
    if (container.dataset.initialized === 'true') return;
    container.dataset.initialized = 'true';

    // Referencias a elementos internos
    const poster = container.querySelector('.video-component-poster');
    const overlay = container.querySelector('.video-component-overlay');

    // Crear el elemento de video
    const videoElement = document.createElement('video');
    videoElement.style.width = '100%';
    videoElement.style.height = '100%';
    videoElement.style.display = 'block';
    videoElement.playsInline = true;
    
    // Limpiar contenedor y añadir video
    container.innerHTML = '';
    container.appendChild(videoElement);

    // Configuración de Plyr (manteniendo los controles del video.js original)
    const plyrConfig = {
        controls: [
            "play-large",
            "play",
            "progress",
            "duration",
            "mute",
            "volume",
            "fullscreen",
        ],
        debug: false,
        autoplay: true, // Iniciamos inmediatamente al hacer clic
        muted: false,   // Al ser una acción del usuario, activamos el audio
        volume: 1,
        seekTime: 10,
        ratio: "16:9",
        storage: {
            enabled: true,
            key: "plyr",
        },
    };

    const player = new Plyr(videoElement, plyrConfig);

    // Lógica de carga según formato
    if (videoFormat === "m3u8") {
        if (typeof Hls !== 'undefined' && Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(videoUrl);
            hls.attachMedia(videoElement);
            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                videoElement.play();
            });
        } else if (videoElement.canPlayType("application/vnd.apple.mpegurl")) {
            // Soporte nativo de HLS (Safari/iOS)
            videoElement.src = videoUrl;
            videoElement.play();
        } else {
            console.error("HLS no está soportado en este navegador.");
        }
    } else {
        // Formato estándar (mp4, etc)
        player.source = {
            type: "video",
            sources: [
                {
                    src: videoUrl,
                    type: "video/mp4",
                },
            ],
        };
        videoElement.play();
    }

    // Asegurar que el reproductor ocupe el espacio correcto
    player.on('ready', () => {
        // console.log('Video listo');
    });
};
