@props(['stories', 'showRail' => true])

<div id="stories-component-root" class="col-lg-12"
    data-stories="{{ json_encode($stories, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) }}">

    @if ($showRail)
        <div class="card-body stories-rail" id="storiesRail">
            @foreach ($stories as $index => $story)
                <div class="story-circle-item" data-story-index="{{ $index }}">
                    <div class="circle-ring">
                        <div class="story-avatar">
                            <img src="{{ $story['avatar'] }}" alt="{{ $story['username'] }}" loading="lazy">
                        </div>
                    </div>
                    <span class="story-name">{{ $story['username'] }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <!-- ── Modal fullscreen ─────────────────────────────────────── -->
    <div class="stories-fullscreen" id="fullscreenStories" role="dialog" aria-modal="true" aria-label="Historias">

        <!-- Overlay oscuro a los lados del card 9:16 -->
        <div class="stories-backdrop"></div>

        <!-- Card 9:16 centrado -->
        <div class="stories-card">

            <!-- Barras de progreso -->
            <div class="progress-bars" id="progressBarsContainer"></div>

            <!-- Header -->
            <div class="story-header" id="storyHeader">
                <div class="user-info">
                    <img class="header-avatar" id="headerAvatar"
                        src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" alt="Avatar">
                    <div class="header-text">
                        <a href="#" class="header-username" id="headerUsername"></a>
                        <span class="header-time" id="headerTimeAgo"></span>
                    </div>
                </div>
                <div class="header-actions">
                    <!-- Pausa / Reanudar -->
                    <button class="story-btn-icon" id="storyBtnPause" aria-label="Pausar">⏸</button>
                    <!-- Cerrar -->
                    <button class="story-btn-icon" id="closeStoryBtn" aria-label="Cerrar">✕</button>
                </div>
            </div>

            <!-- Slides -->
            <div class="story-custom-container" id="storySwiper">
                <div class="story-custom-wrapper" id="storySwiperWrapper"></div>
            </div>

            <!-- Botones de slide (izquierda / derecha dentro del usuario) -->
            <button class="story-slide-btn story-slide-btn--prev" id="storyBtnSlidePrev" aria-label="Anterior">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </button>
            <button class="story-slide-btn story-slide-btn--next" id="storyBtnSlideNext" aria-label="Siguiente">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
            </button>

        </div><!-- /.stories-card -->

        <!-- Botones de usuario (afuera del card, en el backdrop) -->
        <button class="story-user-btn story-user-btn--prev story-nav-hidden" id="storyBtnPrev"
            aria-label="Usuario anterior">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6" />
            </svg>
        </button>
        <button class="story-user-btn story-user-btn--next story-nav-hidden" id="storyBtnNext"
            aria-label="Usuario siguiente">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
        </button>

    </div><!-- /.stories-fullscreen -->
    @once
        <link rel="stylesheet" href="{{ asset('css/frontend/stories.css') }}">
        <script src="{{ asset('js/frontend/stories.js') }}"></script>
    @endonce
</div>
