<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use Livewire\Attributes\On;
use Livewire\Component;

class Player extends Component
{
    public Owner $owner;
    public bool $isMultiview = false;
    public bool $showInfo = true;
    public bool $showControls = true;
    public bool $autoplay = true;
    public bool $muted = true;
    public bool $canExpandLayout = false;
    public bool $showExpandButton = true;
    public bool $showLogs = true;
    
    // Status properties for reactivity
    public bool $isLive = false;
    public bool $isOnline = false;
    public $inShow = false;
    public string $statusChangedAt = '';
    public string $offlineStatusUpdatedAt = '';
    public string $url = '';
    public string $poster = '';

    public function render()
    {
        $this->url = trim(env("URL_HLS") . "/" . $this->owner->id . "/master/" . $this->owner->id . ".m3u8");

        $height = $this->owner->ownerCamBroadcastConfigHeight;
        $width = $this->owner->ownerCamBroadcastConfigWidth;
        $this->poster = $this->getPoster($this->owner);
        
        $this->isLive = (bool) $this->owner->isLive;
        $this->isOnline = (bool) $this->owner->isOnline;
        $this->statusChangedAt = $this->owner->statusChangedAt?->diffForHumans() ?? '';
        $this->offlineStatusUpdatedAt = $this->owner->offlineStatusUpdatedAt?->diffForHumans() ?? '';
        $this->inShow = $this->owner->show_mode;

        return view('livewire.owner.live.player', [
            'url' => $this->url,
            'poster' => $this->poster,
            'height' => $height,
            'width' => $width,
            'isLive' => $this->isLive,
            'isOnline' => $this->isOnline,
            'statusChangedAt' => $this->statusChangedAt,
            'offlineStatusUpdatedAt' => $this->offlineStatusUpdatedAt,
            'inShow' => $this->inShow,
        ]);
    }

    #[On('owner-status-updated')]
    public function refreshOwner()
    {
        $this->owner->refresh();
    }

    private function getPoster(Owner $owner)
    {
        return $owner->data->user->user->snapshotTimestamp && $owner->data->user->user->snapshotTimestamp != ''
            ? 'https://img.doppiocdn.net/thumbs/' . $owner->data->user->user->snapshotTimestamp . '/' . $owner->id
            : $owner->preview;
    }
}
