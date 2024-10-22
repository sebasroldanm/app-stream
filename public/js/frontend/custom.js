window.Livewire.on("playVideo", function (data) {

    initializeVideoPlayer(data[0]);
});

window.Livewire.on("initMasonry", function (data) {
    initializeMasonry();
});

function initializeVideoPlayer(video) {
    console.log("Livewire emitió el evento videoLoaded");
    $("#event_trailer").click();

    var format = video.format; // Por ejemplo: 'm3u8' o 'mp4';
    var player = videojs("my_video_1", {
        liveui: true,
    });

    // Configuración del video según el formato
    if (format === ".m3u8") {
        player.src({
            type: "application/x-mpegURL",
            src: video.url,
        });
    } else if (format === ".mp4") {
        player.src({
            type: "video/mp4",
            src: video.url,
        });
    } else {
        console.error("Formato de video no soportado:", format);
        return;
    }

    player.poster(video.cover);
    player.muted(true);
    player.play();
}

function initializeMasonry(item) {
    setTimeout(() => {
        $('.masonry').masonry({
            itemSelector: ".masonry-item",
        });
    }, 100);
}
