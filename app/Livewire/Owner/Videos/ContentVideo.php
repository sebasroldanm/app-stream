<?php

namespace App\Livewire\Owner\Videos;

use App\Models\Owner;
use App\Models\Video;
use Livewire\Component;

class ContentVideo extends Component
{

    public Owner $owner;
    public Video $video;

    public function render()
    {
        return view('livewire.owner.videos.content-video');
    }
}
