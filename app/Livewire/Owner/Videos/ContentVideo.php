<?php

namespace App\Livewire\Owner\Videos;

use App\Models\Owner;
use App\Models\Video;
use App\Traits\OwnerProp;
use Livewire\Component;

class ContentVideo extends Component
{
    use OwnerProp;

    public Owner $owner;
    public Video $video;

    public function render()
    {
        $this->dispatch('initVideos');
        $duration = $this->stringDurationTime($this->video->duration);
        return view('livewire.owner.videos.content-video', [
            'duration' => $duration
        ]);
    }
}
