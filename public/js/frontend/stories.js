class StoryManager {
    constructor() {
        this.data         = [];
        this.userIndex    = 0;
        this.slideIndex   = 0;
        this.rafId        = null;
        this.isPaused     = false;
        this.pausedAt     = 0;
        this.slideStart   = 0;
        this._ns          = "";

        this._init();
    }

    destroy() {
        this._stopProgress();
        this._pauseVideos();
        this.data = [];
    }

    _init() {
        const root = document.getElementById("stories-component-root");
        if (!root) return;
        try { 
            this.data = JSON.parse(root.dataset.stories || "[]"); 
        } catch (e) { 
            console.error("[StoryManager] JSON parse error:", e); 
        }

        this._bindUI();
    }

    _bindUI() {
        // Los eventos ahora se manejan vía Alpine.js en el Blade (x-on:click)
        // para máxima compatibilidad con Livewire.
    }

    // ─── OPEN / CLOSE ────────────────────────────────────────────────────────

    open(userIndex, startSlide = 0) {
        const root = document.getElementById("stories-component-root");
        if (!root) return;
        try { this.data = JSON.parse(root.dataset.stories || "[]"); } catch { return; }

        const user = this.data[userIndex];
        if (!user?.contents?.length) return;

        this._stopProgress();

        this.userIndex  = userIndex;
        this.slideIndex = Math.min(startSlide, user.contents.length - 1);
        this.isPaused   = false;
        this.pausedAt   = 0;

        const modal = document.getElementById("fullscreenStories");
        if (!modal) return;
        modal.classList.add("active");
        document.body.style.overflow = "hidden";

        this._buildDOM(user);
        this._renderSlide(this.slideIndex, true);
    }

    close() {
        this._stopProgress();
        this._pauseVideos();

        const modal = document.getElementById("fullscreenStories");
        if (modal) modal.classList.remove("active");
        document.body.style.overflow = "";

        const wrapper = document.getElementById("storySwiperWrapper");
        const bars    = document.getElementById("progressBarsContainer");
        if (wrapper) wrapper.innerHTML = "";
        if (bars)    bars.innerHTML    = "";

        this._setPauseIcon(false);
    }

    _buildDOM(user) {
        const wrapper = document.getElementById("storySwiperWrapper");
        const bars    = document.getElementById("progressBarsContainer");
        if (!wrapper || !bars) return;

        wrapper.innerHTML = "";
        bars.innerHTML    = "";

        this._ns = `u${this.userIndex}`;

        user.contents.forEach((content, i) => {
            const slide = document.createElement("div");
            slide.className = "story-custom-slide";
            slide.id        = `${this._ns}-slide-${i}`;

            if (content.type === "image") {
                const img     = document.createElement("img");
                img.src       = content.url || "";
                img.className = "story-media";
                img.alt       = "";
                slide.appendChild(img);
            } else if (content.type === "video") {
                const vid         = document.createElement("video");
                vid.src           = content.url || "";
                vid.className     = "story-media";
                vid.muted         = true;
                vid.playsInline   = true;
                vid.preload       = "metadata";
                vid.setAttribute("webkit-playsinline", "");
                slide.appendChild(vid);
            } else {
                const wrap = document.createElement("div");
                wrap.className = "text-story-container";
                const txt = document.createElement("div");
                txt.className = "dynamic-text";
                txt.innerHTML = (content.textContent || "").replace(/\n/g, "<br>");
                wrap.appendChild(txt);
                slide.appendChild(wrap);
            }

            wrapper.appendChild(slide);

            const seg  = document.createElement("div");
            seg.className = "progress-segment";
            const fill = document.createElement("div");
            fill.className = "progress-fill";
            fill.id        = `${this._ns}-fill-${i}`;
            seg.appendChild(fill);
            bars.appendChild(seg);
        });
    }

    _renderSlide(index, immediate = false) {
        const user = this.data[this.userIndex];
        if (!user) return;

        this._stopProgress();
        this._pauseVideos();

        this.slideIndex = index;
        this.isPaused   = false;
        this.pausedAt   = 0;
        this._setPauseIcon(false);

        const wrapper = document.getElementById("storySwiperWrapper");
        if (wrapper) {
            wrapper.style.transition = immediate ? "none" : "transform 0.22s ease";
            wrapper.style.transform  = `translateX(-${index * 100}%)`;
        }

        user.contents.forEach((_, i) => {
            const fill = this._fill(i);
            if (!fill) return;
            fill.style.transition = "none";
            fill.style.width      = i < index ? "100%" : "0%";
        });

        this._updateHeader(user, index);
        this._updateNavButtons();

        requestAnimationFrame(() => requestAnimationFrame(() => this._activateSlide(index)));
    }

    _activateSlide(index) {
        const capturedUser  = this.userIndex;
        const capturedSlide = index;
        const isActive      = () => this.userIndex === capturedUser && this.slideIndex === capturedSlide;

        const user    = this.data[this.userIndex];
        const content = user?.contents[index];
        if (!content) return;

        const defaultDuration = parseInt(content.duration) || 8000;

        if (content.type === "video") {
            const slide = document.getElementById(`${this._ns}-slide-${index}`);
            const vid   = slide?.querySelector("video");

            if (vid) {
                vid.currentTime = 0;
                const startVideo = () => {
                    if (!isActive()) return;
                    const dur = vid.duration > 0 ? vid.duration * 1000 : defaultDuration;
                    vid.play().catch(() => {});
                    this._startProgress(index, dur);
                };

                if (vid.readyState >= 1) {
                    startVideo();
                } else {
                    vid.addEventListener("loadedmetadata", startVideo, { once: true });
                    setTimeout(() => {
                        if (isActive() && !this.rafId) {
                            vid.play().catch(() => {});
                            this._startProgress(index, defaultDuration);
                        }
                    }, 2000);
                }
                return;
            }
        }
        this._startProgress(index, defaultDuration);
    }

    _startProgress(index, duration) {
        this._stopProgress();
        const fill = this._fill(index);
        if (!fill) return;

        this.slideStart = performance.now();
        this.pausedAt   = 0;

        const tick = (now) => {
            if (this.isPaused) {
                this.rafId = requestAnimationFrame(tick);
                return;
            }

            const elapsed = this.pausedAt + (now - this.slideStart);
            const pct     = Math.min((elapsed / duration) * 100, 100);
            fill.style.width = pct + "%";

            if (pct < 100) {
                this.rafId = requestAnimationFrame(tick);
            } else {
                this.rafId = null;
                this._next();
            }
        };
        this.rafId = requestAnimationFrame(tick);
    }

    _stopProgress() {
        if (this.rafId) {
            cancelAnimationFrame(this.rafId);
            this.rafId = null;
        }
    }

    _togglePause() {
        const modal = document.getElementById("fullscreenStories");
        if (!modal?.classList.contains("active")) return;
        this.isPaused ? this._resume() : this._pause();
    }

    _pause() {
        if (this.isPaused) return;
        this.pausedAt  += performance.now() - this.slideStart;
        this.isPaused   = true;
        this._setPauseIcon(true);
        this._pauseVideos();
    }

    _resume() {
        if (!this.isPaused) return;
        this.slideStart = performance.now();
        this.isPaused   = false;
        this._setPauseIcon(false);

        const content = this.data[this.userIndex]?.contents[this.slideIndex];
        if (content?.type === "video") {
            const slide = document.getElementById(`${this._ns}-slide-${this.slideIndex}`);
            slide?.querySelector("video")?.play().catch(() => {});
        }
    }

    _setPauseIcon(paused) {
        const btn = document.getElementById("storyBtnPause");
        if (!btn) return;
        btn.textContent = paused ? "▶" : "⏸";
        btn.setAttribute("aria-label", paused ? "Reanudar" : "Pausar");
    }

    _next() {
        const user = this.data[this.userIndex];
        if (!user) return;
        if (this.slideIndex < user.contents.length - 1) {
            this._renderSlide(this.slideIndex + 1);
        } else {
            this._nextUser();
        }
    }

    _prev() {
        if (this.slideIndex > 0) {
            this._renderSlide(this.slideIndex - 1);
        } else {
            this._prevUser();
        }
    }

    _nextUser() {
        if (this.userIndex + 1 < this.data.length) {
            this.open(this.userIndex + 1, 0);
        } else {
            this.close();
        }
    }

    _prevUser() {
        if (this.userIndex > 0) {
            this.open(this.userIndex - 1, 0);
        }
    }

    _fill(index) {
        return document.getElementById(`${this._ns}-fill-${index}`);
    }

    _pauseVideos() {
        const wrapper = document.getElementById("storySwiperWrapper");
        if (wrapper) {
            wrapper.querySelectorAll("video").forEach(v => v.pause());
        }
    }

    _updateHeader(user, index) {
        const modal = document.getElementById("fullscreenStories");
        if (!modal) return;
        const avatar = modal.querySelector(".header-avatar");
        const username = modal.querySelector(".header-username");
        const time = modal.querySelector(".header-time");
        
        if (avatar) avatar.src = user.avatar || "";
        if (username) username.textContent = user.username || "";
        if (username) username.href = '/owner/' + user.username;
        const story = user.contents[index];
        if (time) time.textContent = story?.timeAgo || "";
    }

    _updateNavButtons() {
        const prev = document.getElementById("storyBtnPrev");
        const next = document.getElementById("storyBtnNext");
        if (prev) prev.classList.toggle("story-nav-hidden", this.userIndex === 0);
        if (next) next.classList.toggle("story-nav-hidden", this.userIndex >= this.data.length - 1);
    }
}

// ─── Bootstrap ───────────────────────────────────────────────────────────────
function initStoryManager() {
    if (window.storyManager) {
        window.storyManager.destroy();
    }
    window.storyManager = new StoryManager();
}

window.initStoryManager = initStoryManager;

document.addEventListener("DOMContentLoaded", initStoryManager);
document.addEventListener("livewire:navigated", initStoryManager);
document.addEventListener("livewire:init", initStoryManager);

// Auto-inicialización inmediata si el componente ya está en el DOM
if (document.getElementById("stories-component-root")) {
    initStoryManager();
}