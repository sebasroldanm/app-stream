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
        $owner = Owner::find($this->owner->id);
        $url = env("URL_HLS") . "/b-hls-32/" . $owner->id . "/" . $owner->id . ".m3u8";

        $this->dispatch('initLive', [
            'url' => trim($url),
            'cover' => $owner->preview,
            'format' => "live",
        ]);
        return view('livewire.owner.live.player');
    }
}
