<div x-data="livePlayer({
    url: '{{ $url }}',
    poster: '{{ $poster }}',
    autoplay: {{ $autoplay ? 'true' : 'false' }},
    muted: {{ $muted ? 'true' : 'false' }},
    showControls: {{ $showControls ? 'true' : 'false' }},
    canExpandLayout: {{ $canExpandLayout ? 'true' : 'false' }},
    ownerId: {{ $owner->id }}
})" class="live-player-wrapper">
    <div class="card bg-dark overflow-hidden mb-1 position-relative">
        <video x-ref="video" class="plyr-video" playsinline poster="{{ $poster }}"></video>
    </div>

    @if ($showInfo)
        <div class="player-footer bg-dark border border-secondary rounded p-2 small">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <!-- Left: Status/Error messages -->
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <template x-if="status">
                        <div class="d-flex align-items-center gap-1 status-text"
                            :class="status === 'danger' ? 'text-danger' : 'text-warning'">
                            <i :class="status === 'danger' ? 'ri-error-warning-fill' : 'ri-alert-fill'"></i>
                            <span x-text="statusMessage"></span>
                        </div>
                    </template>
                    <span class="text-white-50 transmission-info" x-show="transmissionInfo"
                        x-text="transmissionInfo"></span>
                </div>

                <!-- Right: Buttons -->
                <div class="d-flex align-items-center gap-1">
                    @if ($showLogs)
                        <button @click="logsOpen = !logsOpen"
                            class="btn btn-sm px-1 py-0 border border-secondary-subtle"
                            :class="logsOpen ? 'btn-primary' : 'btn-dark'" title="Ver logs">
                            <i class="ri-bug-line"></i>
                        </button>
                    @endif

                    @if ($showExpandButton)
                        <button @click="toggleExpand()" class="btn btn-primary btn-sm px-2 py-0">
                            <span x-text="expanded ? 'Contraer' : 'Ampliar'"></span>
                        </button>
                    @endif
                </div>
            </div>

            @if ($showLogs)
                <div x-show="logsOpen" x-transition
                    class="player-logs bg-black p-1 rounded border border-secondary-subtle mt-2">
                    <div class="text-success-emphasis mb-1 border-bottom border-secondary-subtle pb-1 logs-title">Log del reproductor: {{ $url }}</div>
                    <template x-for="(log, index) in logs" :key="index">
                        <div class="text-muted log-item" x-text="log"></div>
                    </template>
                    <div x-show="logs.length === 0" class="text-muted italic no-logs">No hay logs
                        registrados.</div>
                </div>
            @endif
        </div>
    @endif

</div>
