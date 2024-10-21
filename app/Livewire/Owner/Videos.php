<?php

namespace App\Livewire\Owner;

use App\Models\Owner;
use App\Models\Video;
use Livewire\Component;

class Videos extends Component
{

    public Owner $owner;

    public function render()
    {
        $videos = Video::where('owner_id', $this->owner->id)->get();

        return view('livewire.owner.videos', [
            'videos' => $videos
        ]);
    }
}
