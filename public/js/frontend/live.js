document.addEventListener("alpine:init", () => {
    Alpine.data("livePlayer", (config) => ({
        player: null,
        hls: null,
        status: "", // 'warning' | 'danger'
        statusMessage: "",
        transmissionInfo: "",
        logs: [],
        logsOpen: false,
        expanded: false,
        config: config,

        init() {
            // Pequeño delay para asegurar que el DOM esté listo
            setTimeout(() => {
                this.initPlayer();
            }, 100);
        },

        initPlayer() {
            const videoElement = this.$refs.video;
            if (!videoElement) {
                console.error(
                    "ERROR: No se encontró el elemento video ref en el DOM",
                );
                return;
            }

            const plyrOptions = {
                controls: this.config.showControls
                    ? ["play-large", "play", "mute", "volume", "fullscreen"]
                    : [],
                debug: false,
                autoplay: this.config.autoplay,
                muted: this.config.muted,
                volume: 1,
                ratio: "16:9", // Forzamos proporción 16:9 siempre
                poster: this.config.poster,
            };

            if (Hls.isSupported()) {
                this.hls = new Hls();
                this.hls.loadSource(this.config.url);

                this.player = new Plyr(videoElement, plyrOptions);
                this.hls.attachMedia(this.player.media);

                this.hls.on(Hls.Events.MANIFEST_PARSED, () => {
                    this.addLog("HLS: Manifiesto cargado");
                    this.addLog(`URL: ${this.config.url}`);
                    if (this.config.autoplay) {
                        this.player.play().catch((error) => {
                            this.addLog("Autoplay bloqueado por el navegador");
                        });
                    }
                });

                this.hls.on(Hls.Events.LEVEL_SWITCHED, (event, data) => {
                    const level = this.hls.levels[data.level];
                    if (level) {
                        this.transmissionInfo = `${level.width}x${level.height} (${(level.bitrate / 1000).toFixed(0)}kbps)`;
                        this.addLog(`Calidad: ${this.transmissionInfo}`);
                    }
                });

                this.hls.on(Hls.Events.ERROR, (event, data) => {
                    if (data.fatal) {
                        this.status = "danger";
                        const errorDetail = data.networkDetails
                            ? ` (${data.networkDetails.response || data.networkDetails.statusText})`
                            : "";

                        switch (data.type) {
                            case Hls.ErrorTypes.NETWORK_ERROR:
                                this.statusMessage =
                                    "Conexión inestable" + errorDetail;
                                this.addLog(
                                    `Error de red: ${this.statusMessage} - URL: ${this.config.url}`,
                                );
                                this.hls.startLoad();
                                break;
                            case Hls.ErrorTypes.MEDIA_ERROR:
                                this.statusMessage = "Error de medios";
                                this.addLog(
                                    `Error de medios - Recuperando... URL: ${this.config.url}`,
                                );
                                this.hls.recoverMediaError();
                                break;
                            default:
                                this.statusMessage = "Error fatal";
                                this.addLog(
                                    `Error fatal irrecuperable - URL: ${this.config.url}`,
                                );
                                this.hls.destroy();
                                break;
                        }
                    }
                });
            } else if (
                videoElement.canPlayType("application/vnd.apple.mpegurl")
            ) {
                videoElement.src = this.config.url;
                this.player = new Plyr(videoElement, plyrOptions);
                if (this.config.autoplay) this.player.play();
            } else {
                this.status = "danger";
                this.statusMessage = "No soportado";
                this.addLog("Formato no soportado en este navegador");
            }

            if (this.player) {
                this.player.on("playing", () => {
                    this.status = "";
                    this.statusMessage = "";
                    this.addLog("Reproduciendo");
                });

                this.player.on("waiting", () => {
                    this.status = "warning";
                    this.statusMessage = "Cargando...";
                    this.addLog("Buffering");
                });

                this.player.on("pause", () => {
                    this.status = "warning";
                    this.statusMessage = "Pausado";
                    this.addLog("Pausado");
                });

                this.player.on("error", (e) => {
                    this.status = "danger";
                    this.statusMessage = "Error de Plyr";
                    this.addLog("Error del reproductor");
                });
            }
        },

        addLog(msg) {
            const time = new Date().toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit",
                second: "2-digit",
            });
            this.logs.unshift(`${time} - ${msg}`);
            if (this.logs.length > 4) this.logs.pop();
        },

        toggleExpand() {
            this.expanded = !this.expanded;

            // Lógica de expansión de contenedor (anteriormente en custom.js)
            const liveContainer = document.getElementById("container-live");
            if (
                this.config.canExpandLayout &&
                liveContainer &&
                window.innerWidth > 1449
            ) {
                if (this.expanded) {
                    // Expandir
                    if (
                        !document
                            .querySelector(".wrapper-menu")
                            ?.classList.contains("open")
                    ) {
                        sessionStorage.setItem("menu-open", "true");
                        document.querySelector(".wrapper-menu")?.click();
                    }
                    if (
                        !document
                            .querySelector(".right-sidebar-mini")
                            ?.classList.contains("right-sidebar")
                    ) {
                        sessionStorage.setItem("sidebar-open", "true");
                        document
                            .querySelector(".right-sidebar-toggle")
                            ?.click();
                    }
                    liveContainer.classList.remove("container");
                    liveContainer.classList.add("container-fluid");
                } else {
                    // Contraer
                    liveContainer.classList.remove("container-fluid");
                    liveContainer.classList.add("container");
                    if (sessionStorage.getItem("menu-open") === "true") {
                        document.querySelector(".wrapper-menu")?.click();
                        sessionStorage.removeItem("menu-open");
                    }
                    if (sessionStorage.getItem("sidebar-open") === "true") {
                        document
                            .querySelector(".right-sidebar-toggle")
                            ?.click();
                        sessionStorage.removeItem("sidebar-open");
                    }
                }
            }

            this.$dispatch("live-player-toggle-expand", {
                expanded: this.expanded,
                ownerId: this.config.ownerId,
            });
        },

        destroy() {
            if (this.hls) this.hls.destroy();
            if (this.player) this.player.destroy();
        },
    }));
});
