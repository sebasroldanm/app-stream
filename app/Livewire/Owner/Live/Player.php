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

    public function render()
    {
        $url = env("URL_HLS") . "/" . $this->owner->id . "/master/" . $this->owner->id . ".m3u8";

        $height = $this->owner->ownerCamBroadcastConfigHeight;
        $width = $this->owner->ownerCamBroadcastConfigWidth;
        $poster = $this->getPoster($this->owner);

        return view('livewire.owner.live.player', [
            'url' => trim($url),
            'poster' => $poster,
            'height' => $height,
            'width' => $width,
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
