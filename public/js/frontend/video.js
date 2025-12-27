window.addEventListener("initVideos", () => {
    setTimeout(() => {
        // console.log("initVideos");
        initVideos();
    }, 500);
});

window.Livewire.on("initVideos", () => {
    setTimeout(() => {
        // console.log("initVideos wire");
        initVideos();
    }, 500);
});

function initVideos() {
    // Selecciona todos los videos con la clase .video_feed
    const videos = document.querySelectorAll(".video_feed");

    videos.forEach((videoElement) => {
        // Verificar si ya fue inicializado para evitar duplicados si se llama multiples veces
        if (videoElement.classList.contains('plyr-initialized')) {
            return;
        }

        const videoFormat = videoElement.dataset.format; // Formato de video, ej: 'm3u8', 'mp4'
        const videoSource = videoElement.dataset.video; // URL del video

        // Crea un nuevo reproductor Plyr para cada video sin autoplay
        const player = new Plyr(videoElement, {
            controls: [
                "play-large",
                "play",
                "rewind",
                "fast-forward",
                "progress",
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

        videoElement.classList.add('plyr-initialized');

        // Configura la fuente del video en base al formato
        if (videoFormat === "m3u8") {
            if (Hls.isSupported()) {
                const hls = new Hls();
                hls.loadSource(videoSource);
                hls.attachMedia(videoElement);
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
