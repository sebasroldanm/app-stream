<?php

namespace App\Livewire\Owner;

use App\Models\Owner;
use Livewire\Component;

class Live extends Component
{

    public Owner $owner;

    public function render()
    {
        $owner = $this->owner;

        $url = env("URL_HLS") . "/hls/" . $owner->id . "/" . $owner->id . ".m3u8";

        $this->dispatch('playVideo', [
            'url' => $url,
            'cover' => $owner->preview,
            'format' => "live",
        ]);

        return view('livewire.owner.live', ['url' => $url]);
    }
}
