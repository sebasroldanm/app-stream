<div class="content-video-player" wire:ignore>
    <div class="row">
        <div class="{{ $mainCol }}">
            <livewire:owner.live.player :owner="$owner" />
            <livewire:owner.live.info :owner="$owner" lazy/>
        </div>
        <div class="{{ $sideCol }}">
            <livewire:owner.live.chat :owner="$owner" lazy />
        </div>
    </div>

</div>
