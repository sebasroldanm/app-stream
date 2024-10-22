window.Livewire.on("playVideo", function (data) {
    console.log(data[0]); // Muestra el objeto completo en la consola

    initializeVideoPlayer(data[0]); // Usa data.url directamente
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
        return; // Termina la ejecución si el formato no es soportado
    }

    player.poster(video.cover);
    player.muted(true); // Mute como booleano, no como string
    player.play();
}
