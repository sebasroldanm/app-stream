<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use Livewire\Attributes\On;
use Livewire\Component;

class Player extends Component
{
    public Owner $owner;
    public bool $isMultiview = false;

    public function render()
    {
        $owner = Owner::find($this->owner->id);
        $url = env("URL_HLS") . "/b-hls-32/" . $owner->id . "/" . $owner->id . ".m3u8";

        $ratio = $owner->ownerCamBroadcastConfigRatio;
        $height = $owner->ownerCamBroadcastConfigHeight;
        $width = $owner->ownerCamBroadcastConfigWidth;

        if ($this->isMultiview) {
            $this->dispatch('initMultiview', [
                'id' => $owner->id,
                'url' => trim($url),
                'poster' => $owner->preview,
                'ratio' => $ratio,
                'height' => $height,
                'width' => $width,
            ]);
        } else {
            $this->dispatch('initLive', [
                'url' => trim($url),
                'poster' => $owner->preview,
                'ratio' => $ratio,
                'height' => $height,
                'width' => $width,
            ]);
        }
        return view('livewire.owner.live.player', compact('ratio', 'height', 'width'));
    }

    private function aspectRatio($width, $height)
    {
        $gcd = function ($a, $b) use (&$gcd) {
            return $b === 0 ? $a : $gcd($b, $a % $b);
        };

        $divisor = $gcd($width, $height);

        return ($width / $divisor) . ':' . ($height / $divisor);
    }
}
