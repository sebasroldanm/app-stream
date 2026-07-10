document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('video-player');
  if (!container) return;

  const apiUrl = container.dataset.apiUrl || '';
  const posterUrl = container.dataset.poster || '';   // URL de la imagen de fondo
  let pollingTimer = null;

  function getPollInterval(state) {
    switch (state) {
      case 'offline': return 60000;
      case 'online':  return 30000;
      default:        return 5000;
    }
  }

  function initPlayer() {
    clearPolling();

    const rawState = container.dataset.state || 'Offline';
    const state = rawState.toLowerCase();
    const streamUrl = container.dataset.streamUrl;
    const text = container.dataset.text || '';
    const date = container.dataset.date || '';

    // Si no es live, mostramos plantilla (con posible fondo borroso)
    if (state !== 'live') {
      renderTemplate(state, text, date, posterUrl);
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

    // Construir el esqueleto con posible fondo borroso
    const hasPosterClass = posterUrl ? ' has-poster' : '';
    const posterStyle = posterUrl ? `--poster-url: url('${posterUrl.replace(/'/g, "\\'")}');` : '';

    container.innerHTML = `
      <div class="player-body${hasPosterClass}" id="player-body" style="${posterStyle}">
        <div class="skeleton-loading">
          <div class="spinner"></div>
          <div class="loading-text">Conectando…</div>
        </div>
      </div>`;

    const bodyEl = document.getElementById('player-body');
    const skeleton = bodyEl.querySelector('.skeleton-loading');
    const loadingText = skeleton.querySelector('.loading-text');

    const video = document.createElement('video');
    video.id = 'main-video';
    video.playsInline = true;
    video.preload = 'metadata';
    video.style.display = 'none';
    bodyEl.appendChild(video);

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
      // Una vez que el video se muestra, quitamos la clase has-poster para que no estorbe el fondo
      bodyEl.classList.remove('has-poster');
    }

    function showPlayerError(message) {
      if (skeleton && skeleton.parentNode) skeleton.remove();
      if (video.parentNode) video.remove();
      destroyPlayer();
      bodyEl.classList.remove('has-poster');

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

    async function checkApiBeforeRetry() {
      if (!apiUrl) return false;

      try {
        const response = await fetch(apiUrl);
        if (!response.ok) return false;

        const data = await response.json();
        const newState = (data.state || '').toLowerCase();

        if (data.state) container.dataset.state = data.state;
        if (data.streamUrl !== undefined) container.dataset.streamUrl = data.streamUrl;
        if (data.text !== undefined) container.dataset.text = data.text;
        if (data.date !== undefined) container.dataset.date = data.date;
        if (data.poster !== undefined) container.dataset.poster = data.poster; // actualizar también poster

        if (newState !== 'live') {
          destroyPlayer();
          initPlayer(); // reconstruye con los nuevos datos y el nuevo poster
          return true;
        }
        return false;
      } catch (err) {
        console.warn('Error consultando API antes de reintentar:', err);
        return false;
      }
    }

    async function tryReconnect() {
      const stateChanged = await checkApiBeforeRetry();
      if (stateChanged) return;

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

    setupHls();

    window.addEventListener('beforeunload', () => {
      destroyPlayer();
    });
  }

  // ────────── POLLING ──────────
  async function pollApi() {
    try {
      const response = await fetch(apiUrl);
      if (!response.ok) return;

      const data = await response.json();

      if (data.state) container.dataset.state = data.state;
      if (data.streamUrl !== undefined) container.dataset.streamUrl = data.streamUrl;
      if (data.text !== undefined) container.dataset.text = data.text;
      if (data.date !== undefined) container.dataset.date = data.date;
      if (data.poster !== undefined) container.dataset.poster = data.poster;

      const newState = (data.state || '').toLowerCase();

      if (newState === 'live') {
        clearPolling();
        initPlayer();
      } else {
        const text = container.dataset.text || '';
        const date = container.dataset.date || '';
        const poster = container.dataset.poster || '';
        renderTemplate(newState || 'offline', text, date, poster);

        clearPolling();
        startPolling();
      }
    } catch (err) {
      console.warn('Error en polling de la API:', err);
    }
  }

  function startPolling() {
    if (!apiUrl) return;
    if (pollingTimer) clearPolling();
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

  initPlayer();
});

// ==================== PLANTILLAS (con soporte para poster) ====================
function renderTemplate(state, text, date, posterUrl) {
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
    default:
      icon = 'ri-lock-fill ri-4x mb-3 text-warning';
      title = 'No disponible';
      description = 'Este contenido no está accesible en este momento.';
      text = '';
      date = '';
      break;
  }

  const textHtml = text ? `<h5 class="text-white fst-italic mb-3">${escapeHtml(text)}</h5>` : '';
  const dateHtml = date ? `<p class="small text-muted">Visto por última vez: <span class="text-white">${escapeHtml(date)}</span></p>` : '';

  // Configurar el fondo borroso si hay poster
  const hasPosterClass = posterUrl ? ' has-poster' : '';
  const posterStyle = posterUrl ? `--poster-url: url('${posterUrl.replace(/'/g, "\\'")}');` : '';

  container.innerHTML = `
    <div class="template-container p-3${hasPosterClass}" style="${posterStyle}">
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