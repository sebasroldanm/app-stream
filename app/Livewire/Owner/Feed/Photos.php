<?php

namespace App\Livewire\Owner\Feed;

use App\Models\Owner;
use App\Models\Photos as ModelsPhotos;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Photos extends Component
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
        $photos = ModelsPhotos::where('ownerId', $this->owner->id)->where('url', '!=', '')->limit(9)->get();
        return view('livewire.owner.feed.photos', [
            'photos' => $photos,
            'owner' => $this->owner,
        ]);
    }
}