<?php

namespace App\Livewire\Owner;

use App\Models\Owner;
use Livewire\Component;

class Live extends Component
{

    public Owner $owner;

    public function mount()
    {
        $owner = $this->owner;
        $url = env("URL_HLS") . "/b-hls-32/" . $owner->id . "/" . $owner->id . ".m3u8";

        $this->dispatch('initLive', [
            'url' => trim($url),
            'cover' => $owner->preview,
            'format' => "live",
        ]);
    }

    public function render()
    {
        $owner = $this->owner;
        $url = env("URL_HLS") . "/b-hls-32/" . $owner->id . "/" . $owner->id . ".m3u8";

        return view('livewire.owner.live', [
            'url' => $url,
        ]);
    }
}
