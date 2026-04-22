<div class="content-video-player" wire:ignore>
    <div class="row">
        <div class="{{ $mainCol }}">
            <livewire:owner.live.player :owner="$owner" />
            <livewire:owner.live.info :owner="$owner" />
        </div>
        <div class="{{ $sideCol }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Chat</h4>
                    </div>
                </div>
                <livewire:owner.live.chat :owner="$owner" />
            </div>
        </div>
    </div>

</div>
