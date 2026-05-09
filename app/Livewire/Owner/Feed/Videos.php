<?php

namespace App\Livewire\Owner\Feed;

use App\Models\Owner;
use App\Models\Video;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Videos extends Component
{
    public Owner $owner;

    public function mount(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function placeholder()
    {
        return view('livewire.owner.feed.media-placeholder');
    }

    public function render()
    {
        $videos = Video::where('owner_id', $this->owner->id)->where('coverUrl', '!=', '')->limit(9)->get();
        return view('livewire.owner.feed.videos', [
            'videos' => $videos,
            'owner' => $this->owner,
        ]);
    }
}