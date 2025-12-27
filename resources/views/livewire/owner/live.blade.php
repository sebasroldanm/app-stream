<div class="content-video-player" wire:ignore>
    <div class="row">
        <div class="col-9">
            <div class="card">
                <video id="live-player">
                </video>
            </div>
            <div class="overlay-text" id="error-message" style="display: none;">
                Intente más tarde
            </div>
        </div>
        <div class="col-3">
            <livewire:owner.live.chat :owner="$owner" />
        </div>
    </div>

</div>
