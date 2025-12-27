<div class="content-video-player" wire:ignore>
    <div class="row">
        <div class="col-9">
            <livewire:owner.live.player :owner="$owner" />
            <livewire:owner.live.data :owner="$owner" />
        </div>
        <div class="col-3">
            <livewire:owner.live.chat :owner="$owner" />
        </div>
    </div>

</div>
