<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use Livewire\Attributes\On;
use Livewire\Component;

class Player extends Component
{
    public Owner $owner;

    public function render()
    {
        $url = trim(env("URL_HLS") . "/" . $this->owner->id . "/master/" . $this->owner->id . ".m3u8");
        $poster = $this->getPoster($this->owner);

        $height = $this->owner->ownerCamBroadcastConfigHeight;
        $width = $this->owner->ownerCamBroadcastConfigWidth;

        if ($this->owner->isLive) {
            if ($this->owner->show_mode == null) {
                $state = 'live';
            } else {
                $state = $this->owner->show_mode;
            }
        } else if ($this->owner->isOnline) {
            $state = 'online';
        } else {
            $state = 'offline';
        }
        
        $statusChangedAt = $this->owner->statusChangedAt?->diffForHumans() ?? '';
        $offlineStatusUpdatedAt = $this->owner->offlineStatusUpdatedAt?->diffForHumans() ?? '';

        return view('livewire.owner.live.player', [
            'url' => $url,
            'poster' => $poster,
            'height' => $height,
            'width' => $width,
            'state' => $state,
            'offlineText' => $this->owner->offlineText,
            'statusChangedAt' => $statusChangedAt,
            'offlineStatusUpdatedAt' => $offlineStatusUpdatedAt
        ]);
    }

    private function getPoster(Owner $owner)
    {
        return $owner->data->user->user->snapshotTimestamp && $owner->data->user->user->snapshotTimestamp != ''
            ? 'https://img.doppiocdn.net/thumbs/' . $owner->data->user->user->snapshotTimestamp . '/' . $owner->id
            : $owner->preview;
    }
}
