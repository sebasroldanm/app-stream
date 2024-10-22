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
        $duration = $this->stringDurationTime($this->video->duration);
        return view('livewire.owner.videos.content-video', [
            'duration' => $duration
        ]);
    }


    public function playTrailer(Video $video)
    {
        $this->dispatch('playVideo', [
            'url' => $video->trailerUrl,
            'cover' => $video->coverUrl,
            'format' => $this->returnFormatByUrl($video->trailerUrl),
        ]);
    }

    public function playVideo(Video $video)
    {
        $this->dispatch('playVideo', [
            'url' => $video->videoUrl,
            'cover' => $video->coverUrl,
            'format' => $this->returnFormatByUrl($video->videoUrl),
        ]);
    }
}
