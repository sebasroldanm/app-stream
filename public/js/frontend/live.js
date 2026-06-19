document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('video-player');
  if (!container) return;

  const apiUrl = container.dataset.apiUrl || '';   // endpoint para polling
  let pollingTimer = null;

  // Devuelve el intervalo en milisegundos según el estado
  function getPollInterval(state) {
    switch (state) {
      case 'offline': return 60000;   // 60 segundos
      case 'online':  return 30000;   // 30 segundos
      default:        return 5000;    // 5 segundos (private, p2p...)
    }
  }

  /**
   * Construye la interfaz según el estado actual de los data-* del contenedor.
   * Si es "live" -> reproductor HLS/Plyr.
   * Si es otro estado -> plantilla correspondiente.
   * Inicia polling si el estado no es "live" y hay apiUrl.
   */
  function initPlayer() {
    // Detener cualquier polling previo para evitar duplicados
    clearPolling();

    const rawState = container.dataset.state || 'Offline';
    const state = rawState.toLowerCase();
    const streamUrl = container.dataset.streamUrl;
    const text = container.dataset.text || '';
    const date = container.dataset.date || '';

    // Si no es live, mostramos plantilla
    if (state !== 'live') {
      renderTemplate(state, text, date);

      // Iniciar polling solo si hay apiUrl y NO es live (online también entra)
      if (apiUrl) {
        startPolling();
      }
      return;
    }

    // ────────── MODO LIVE (REPRODUCTOR DE VIDEO) ──────────
    if (!streamUrl) {
      container.innerHTML = `
        <div class="player-error">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          Falta la URL del stream (data-stream-url)
        </div>`;
      return;
    }

    let hls = null;
    let player = null;
    let retryCount = 0;
    const MAX_RETRIES = 3;

    // Plantilla inicial (skeleton)
    container.innerHTML = `
      <div class="player-body" id="player-body">
        <div class="skeleton-loading">
          <div class="spinner"></div>
          <div class="loading-text">Conectando…</div>
        </div>
      </div>`;

    const bodyEl = document.getElementById('player-body');
    const skeleton = bodyEl.querySelector('.skeleton-loading');
    const loadingText = skeleton.querySelector('.loading-text');

    // Crear <video>
    const video = document.createElement('video');
    video.id = 'main-video';
    video.playsInline = true;
    video.preload = 'metadata';
    video.style.display = 'none';
    bodyEl.appendChild(video);

    // ─── Funciones internas del reproductor ───
    function destroyHls() {
      if (hls) { hls.destroy(); hls = null; }
    }

    function destroyPlayer() {
      if (player) { player.destroy(); player = null; }
      destroyHls();
    }

    function revealVideo() {
      if (skeleton && skeleton.parentNode) skeleton.remove();
      video.style.display = 'block';
    }

    function showPlayerError(message) {
      if (skeleton && skeleton.parentNode) skeleton.remove();
      if (video.parentNode) video.remove();
      destroyPlayer();

      const errDiv = document.createElement('div');
      errDiv.className = 'player-error';
      errDiv.innerHTML = `
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        ${escapeHtml(message)}
      `;
      bodyEl.appendChild(errDiv);
    }

    function initPlyr() {
      if (player) return;
      player = new Plyr(video, {
        controls: ['play', 'mute', 'volume', 'fullscreen'],
        ratio: '16:9',
        tooltips: { controls: false },
      });
      revealVideo();
      player.play().catch(() => {});
    }

    function setupHls() {
      destroyHls();

      if (Hls.isSupported()) {
        hls = new Hls({
          enableWorker: true,
          lowLatencyMode: true,
          maxBufferLength: 30,
          backBufferLength: 10,
        });

        hls.loadSource(streamUrl);
        hls.attachMedia(video);

        hls.on(Hls.Events.MANIFEST_PARSED, () => {
          retryCount = 0;
          initPlyr();
        });

        hls.on(Hls.Events.ERROR, (event, data) => {
          if (!data.fatal) return;
          if (data.type === Hls.ErrorTypes.NETWORK_ERROR) {
            destroyHls();
            tryReconnect();
          } else {
            showPlayerError('Error fatal al cargar el stream.');
            destroyPlayer();
          }
        });
      } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        video.src = streamUrl;
        video.addEventListener('loadedmetadata', initPlyr, { once: true });
        video.addEventListener('error', () => {
          showPlayerError('Error al cargar el stream (nativo).');
          destroyPlayer();
        }, { once: true });
      } else {
        showPlayerError('HLS no está soportado en este navegador.');
      }
    }

    // Verifica el estado actual con la API antes de reintentar
    async function checkApiBeforeRetry() {
      if (!apiUrl) return false; // sin API, se sigue con reintentos normales

      try {
        const response = await fetch(apiUrl);
        if (!response.ok) return false; // error de API, se reintentará igual

        const data = await response.json();
        const newState = (data.state || '').toLowerCase();

        // Actualizar dataset siempre para reflejar cambios
        if (data.state) container.dataset.state = data.state;
        if (data.streamUrl !== undefined) container.dataset.streamUrl = data.streamUrl;
        if (data.text !== undefined) container.dataset.text = data.text;
        if (data.date !== undefined) container.dataset.date = data.date;

        if (newState !== 'live') {
          // El stream ya no es live: detener todo y reconstruir interfaz
          destroyPlayer();
          initPlayer(); // Esto mostrará la plantilla correspondiente
          return true;  // indica que se manejó el cambio
        }
        // Si sigue live, devolvemos false para continuar con reintentos
        return false;
      } catch (err) {
        console.warn('Error consultando API antes de reintentar:', err);
        return false; // fallo de red, seguimos con reintento normal
      }
    }

    async function tryReconnect() {
      // Antes de reintentar, verificar si el estado cambió vía API
      const stateChanged = await checkApiBeforeRetry();
      if (stateChanged) return; // la interfaz ya fue reconstruida

      if (retryCount >= MAX_RETRIES) {
        showPlayerError('No se pudo conectar al stream');
        return;
      }
      retryCount++;
      const delay = retryCount * 2000;
      if (loadingText) loadingText.textContent = `Reintentando (${retryCount}/${MAX_RETRIES})…`;

      setTimeout(() => {
        setupHls();
      }, delay);
    }

    // Arrancar la carga del stream
    setupHls();

    // Limpieza al cerrar la página
    window.addEventListener('beforeunload', () => {
      destroyPlayer();
    });
  }

  // ────────── POLLING A LA API (para estados no live) ──────────
  async function pollApi() {
    try {
      const response = await fetch(apiUrl);
      if (!response.ok) return;

      const data = await response.json();  // { state, streamUrl, text, date, ... }

      // Actualizar dataset con los nuevos valores
      if (data.state) container.dataset.state = data.state;
      if (data.streamUrl !== undefined) container.dataset.streamUrl = data.streamUrl;
      if (data.text !== undefined) container.dataset.text = data.text;
      if (data.date !== undefined) container.dataset.date = data.date;

      const newState = (data.state || '').toLowerCase();

      if (newState === 'live') {
        // Cambio a live: detener polling y levantar el reproductor
        clearPolling();
        initPlayer();
      } else {
        // Otro estado: refrescar plantilla y reiniciar polling con la nueva frecuencia
        const text = container.dataset.text || '';
        const date = container.dataset.date || '';
        renderTemplate(newState || 'offline', text, date);

        // Reiniciar el polling con el intervalo adecuado al nuevo estado
        clearPolling();
        startPolling();
      }
    } catch (err) {
      console.warn('Error en polling de la API:', err);
    }
  }

  function startPolling() {
    if (!apiUrl) return;
    if (pollingTimer) clearPolling();   // por seguridad

    const currentState = container.dataset.state.toLowerCase();
    const interval = getPollInterval(currentState);
    pollingTimer = setInterval(pollApi, interval);
  }

  function clearPolling() {
    if (pollingTimer) {
      clearInterval(pollingTimer);
      pollingTimer = null;
    }
  }

  // ────────── INICIO ──────────
  initPlayer();
});

// ==================== PLANTILLAS ====================
function renderTemplate(state, text, date) {
  const container = document.getElementById('video-player');
  if (!container) return;

  const s = state.toLowerCase();

  let icon = '';
  let title = '';
  let description = '';

  switch (s) {
    case 'online':
      icon = 'ri-signal-tower-fill ri-4x mb-3 text-success';
      title = 'Online';
      description = 'El usuario está conectado, pero no está transmitiendo en este momento.';
      break;
    case 'offline':
      icon = 'ri-moon-clear-fill ri-4x mb-3 text-white-50';
      title = 'Offline';
      description = 'El usuario se encuentra actualmente desconectado.';
      break;
    default:   // private, p2p, banned, etc.
      icon = 'ri-lock-fill ri-4x mb-3 text-warning';
      title = 'No disponible';
      description = 'Este contenido no está accesible en este momento.';
      text = '';
      date = '';
      break;
  }

  const textHtml = text ? `<h5 class="text-white fst-italic mb-3">${escapeHtml(text)}</h5>` : '';
  const dateHtml = date ? `<p class="small text-muted">Visto por última vez: <span class="text-white">${escapeHtml(date)}</span></p>` : '';

  container.innerHTML = `
    <div class="text-center p-4 bg-dark rounded" style="aspect-ratio: 16/9; display: flex; flex-direction: column; justify-content: center; align-items: center;">
      <i class="${icon}"></i>
      <h3 class="text-white">${escapeHtml(title)}</h3>
      <p class="text-white-50">${escapeHtml(description)}</p>
      ${textHtml}
      ${dateHtml}
    </div>`;
}

function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, c =>
    ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])
  );
}