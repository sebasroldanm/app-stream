document.addEventListener('DOMContentLoaded', function () {
    const grid = document.getElementById('video-grid');
    const activePlayers = new Map(); // ownerId -> { player, hls, container, button }

    const MAX_STREAMS = 9; // Límite de streams simultáneos

    // --- Contador de streams activos (opcional: añade <span id="stream-count"> en tu HTML) ---
    function updateStreamCount() {
        const counter = document.getElementById('stream-count');
        if (!counter) return;
        const n = activePlayers.size;
        counter.textContent = n;
        counter.style.display = n > 0 ? 'inline-flex' : 'none';
    }

    // --- Crear tarjeta de carga (skeleton) ---
    function createLoadingCard(ownerId, username, status) {
        const col = document.createElement('div');
        col.className = 'col stream-col';
        col.dataset.ownerId = ownerId;
        col.style.animation = 'fadeSlideIn 0.25s ease both';

        col.innerHTML = `
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-2">
                    <div class="stream-loading position-relative bg-black rounded" style="aspect-ratio:16/9">
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <div class="spinner-border spinner-border-sm mb-1" role="status"></div>
                            <div style="font-size:0.7rem;opacity:0.7">Conectando…</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2 px-1" style="font-size:0.8rem">
                        <span class="fw-semibold text-truncate me-2">${escapeHtml(username)}</span>
                        <span class="badge rounded-pill bg-danger bg-opacity-75 me-auto">${escapeHtml(status)}</span>
                        <button class="btn btn-sm btn-link text-danger p-0 remove-btn" data-owner-id="${ownerId}" aria-label="Cerrar stream de ${escapeHtml(username)}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>
            </div>`;

        col.querySelector('.remove-btn').addEventListener('click', e => {
            e.stopPropagation();
            removePlayer(ownerId);
        });

        grid.appendChild(col);
        return col;
    }

    // --- Reemplazar skeleton con el video real (debe ocurrir ANTES de attachMedia/Plyr) ---
    function mountVideo(col, video) {
        const skeleton = col.querySelector('.stream-loading');
        // El video se inserta oculto detrás del skeleton hasta que esté listo
        video.style.display = 'none';
        if (skeleton) skeleton.insertAdjacentElement('afterend', video);
        else col.querySelector('.card-body').prepend(video);
    }

    // --- Revelar el video y quitar el skeleton, una vez que ya está reproduciendo ---
    function revealVideo(col, video) {
        const skeleton = col.querySelector('.stream-loading');
        if (skeleton) skeleton.remove();
        video.style.display = 'block';
    }

    // --- Mostrar error dentro de la tarjeta ---
    function showCardError(col, message) {
        const skeleton = col.querySelector('.stream-loading');
        const hiddenVideo = col.querySelector('video');
        const target = skeleton || hiddenVideo;
        if (!target) return;
        const err = document.createElement('div');
        err.className = 'bg-black rounded d-flex align-items-center justify-content-center text-danger text-center p-3';
        err.style.cssText = 'aspect-ratio:16/9;font-size:0.8rem';
        err.innerHTML = `<div>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <br>${escapeHtml(message)}
        </div>`;
        target.replaceWith(err);
        // Si el video seguía oculto detrás del skeleton, eliminarlo también
        if (skeleton && hiddenVideo) hiddenVideo.remove();
    }

    // --- Crear y activar un player ---
    function createPlayer(ownerId, username, streamUrl, status, buttonElement) {
        if (activePlayers.has(ownerId)) return;

        if (activePlayers.size >= MAX_STREAMS) {
            showToast(`Máximo de ${MAX_STREAMS} streams simultáneos alcanzado.`, 'warning');
            return;
        }

        // Registrar entrada temporal para bloquear doble-clic mientras carga
        activePlayers.set(ownerId, null);
        updateStreamCount();
        setButtonActive(buttonElement, true);

        const col = createLoadingCard(ownerId, username, status);

        const video = document.createElement('video');
        video.id = `player-${ownerId}`;
        video.className = 'w-100 rounded';
        video.playsInline = true;
        video.preload = 'metadata';

        // CRÍTICO: el <video> debe existir en el DOM real antes de que
        // hls.js haga attachMedia y antes de que Plyr lo envuelva.
        // Si se crea el MediaSource sobre un nodo "flotante" y luego se
        // mueve al DOM, el blob: del MediaSource se invalida
        // (ERR_FILE_NOT_FOUND) y el video nunca carga.
        mountVideo(col, video);

        let hls = null;
        let player = null;
        let retryCount = 0;
        const MAX_RETRIES = 3;

        function initPlyr() {
            player = new Plyr(video, {
                controls: ['play', 'mute', 'volume', 'fullscreen'],
                ratio: '16:9',
                tooltips: { controls: false },
            });
            revealVideo(col, video);
            player.play().catch(() => {}); // Autoplay bloqueado en algunos navegadores
            activePlayers.set(ownerId, { player, hls, container: col, button: buttonElement });
        }

        function tryReconnect() {
            if (retryCount >= MAX_RETRIES) {
                showCardError(col, 'No se pudo conectar al stream');
                activePlayers.delete(ownerId);
                updateStreamCount();
                setButtonActive(buttonElement, false);
                return;
            }
            retryCount++;
            const delay = retryCount * 2000;
            updateLoadingText(col, `Reintentando (${retryCount}/${MAX_RETRIES})…`);
            setTimeout(() => {
                if (!activePlayers.has(ownerId)) return; // Fue cerrado mientras esperaba
                hls.stopLoad();
                hls.startLoad();
            }, delay);
        }

        if (Hls.isSupported()) {
            hls = new Hls({
                enableWorker: true,
                lowLatencyMode: true,
                maxBufferLength: 30,
                backBufferLength: 10,
            });

            hls.loadSource(streamUrl);
            hls.attachMedia(video);

            hls.on(Hls.Events.MANIFEST_PARSED, function () {
                retryCount = 0;
                initPlyr();
            });

            hls.on(Hls.Events.ERROR, function (event, data) {
                if (!data.fatal) return;
                if (data.type === Hls.ErrorTypes.NETWORK_ERROR) {
                    tryReconnect();
                } else {
                    showCardError(col, 'Error al cargar el stream');
                    cleanup(ownerId, false);
                }
            });

        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            // Safari: HLS nativo
            video.src = streamUrl;
            video.addEventListener('loadedmetadata', initPlyr, { once: true });
            video.addEventListener('error', () => showCardError(col, 'Error al cargar el stream'), { once: true });

        } else {
            showCardError(col, 'HLS no soportado en este navegador');
            cleanup(ownerId, false);
        }
    }

    // --- Eliminar player y limpiar recursos ---
    function cleanup(ownerId, removeFromMap = true) {
        const entry = activePlayers.get(ownerId);
        if (!entry) {
            if (removeFromMap) activePlayers.delete(ownerId);
            updateStreamCount();
            return;
        }
        if (entry.player) entry.player.destroy();
        if (entry.hls) entry.hls.destroy();
        if (entry.button) setButtonActive(entry.button, false);
        if (removeFromMap) activePlayers.delete(ownerId);
    }

    function removePlayer(ownerId) {
        const entry = activePlayers.get(ownerId);
        if (!entry && !activePlayers.has(ownerId)) return;

        const col = entry?.container || grid.querySelector(`.stream-col[data-owner-id="${ownerId}"]`);
        cleanup(ownerId);

        if (col) {
            col.style.animation = 'fadeSlideOut 0.2s ease both';
            col.addEventListener('animationend', () => col.remove(), { once: true });
        }
        updateStreamCount();
    }

    // --- Helpers de UI ---
    function setButtonActive(btn, active) {
        if (!btn) return;
        btn.classList.toggle('btn-outline-light', !active);
        btn.classList.toggle('btn-danger', active);
        btn.setAttribute('aria-pressed', active ? 'true' : 'false');
    }

    function updateLoadingText(col, text) {
        const hint = col.querySelector('.stream-loading div div:last-child');
        if (hint) hint.textContent = text;
    }

    function escapeHtml(str) {
        return String(str).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    }

    // --- Toast de notificación ---
    function showToast(message, type = 'info') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.cssText = 'position:fixed;bottom:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:0.5rem';
            document.body.appendChild(container);
        }
        const toast = document.createElement('div');
        const colors = { warning: '#f59e0b', info: '#3b82f6', error: '#ef4444' };
        toast.style.cssText = `background:#1e1e1e;color:#fff;padding:0.6rem 1rem;border-left:3px solid ${colors[type]||colors.info};border-radius:6px;font-size:0.8rem;max-width:260px;box-shadow:0 4px 12px rgba(0,0,0,.35);animation:fadeSlideIn 0.2s ease both`;
        toast.textContent = message;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.animation = 'fadeSlideOut 0.2s ease both';
            toast.addEventListener('animationend', () => toast.remove(), { once: true });
        }, 3500);
    }

    // --- Toggle en cada botón ---
    document.querySelectorAll('.owner-btn').forEach(button => {
        button.setAttribute('aria-pressed', 'false');
        button.addEventListener('click', function () {
            const { ownerId, username, status = 'Live', streamUrl } = this.dataset;
            if (!streamUrl) { console.warn('URL de stream no definida para:', ownerId); return; }

            if (activePlayers.has(ownerId)) {
                removePlayer(ownerId);
            } else {
                createPlayer(ownerId, username, streamUrl, status, this);
            }
        });
    });

    // --- Limpieza global al salir ---
    window.addEventListener('beforeunload', () => {
        for (const [id] of activePlayers) cleanup(id, false);
        activePlayers.clear();
    });

    // --- CSS de animaciones (se inyecta una sola vez) ---
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeSlideIn  { from { opacity:0; transform:translateY(8px) } to { opacity:1; transform:translateY(0) } }
        @keyframes fadeSlideOut { from { opacity:1; transform:scale(1)        } to { opacity:0; transform:scale(.96) } }
    `;
    document.head.appendChild(style);
});