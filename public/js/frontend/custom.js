window.Livewire.on("playVideo", function (data) {
    initializeVideoPlayer(data[0]);
});

window.Livewire.on("initMasonry", function (data) {
    initializeMasonry();
});

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
            "fullscreen",
        ],
        autoplay: true,
        muted: true,
        volume: 1,
        seekTime: 10,
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
    }, 300);
}
