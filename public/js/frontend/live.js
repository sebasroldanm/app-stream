document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('video-player');
  if (!container) return;

  const state = container.dataset.state || 'Offline';
  const streamUrl = container.dataset.streamUrl;
  const text = container.dataset.text || '';
  const date = container.dataset.date || '';

  // ---------- Si no es "Live", mostramos la plantilla correspondiente ----------
  if (state !== 'live') {
    renderTemplate(state, text, date);
    return;
  }

  // ---------- Modo Live: reproductor de video ----------
  if (!streamUrl) {
    container.innerHTML = `<div class="player-error">
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

  container.innerHTML = `
    <div class="player-body" id="player-body">
      <div class="skeleton-loading">
        <div class="spinner"></div>
        <div class="loading-text">Conectando…</div>
      </div>
    </div>
  `;

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

  function tryReconnect() {
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

  // ========== Utilidades ==========
  function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, c =>
      ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])
    );
  }
});

// ========== Plantillas para estados NO Live ==========
function renderTemplate(state, text, date) {
  const container = document.getElementById('video-player');
  if (!container) return;

  let icon = '';
  let title = '';
  let description = '';

  switch (state) {
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
      // En este caso ignoramos text y date a menos que quieras mostrarlos
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
    </div>
  `;
}

// Función escapeHtml (global para que también la use renderTemplate)
function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, c =>
    ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])
  );
}