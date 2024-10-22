<?php

namespace App\Livewire\Owner\Albums;

use App\Models\Album;
use App\Models\Owner;
use Livewire\Component;

class ContentAlbum extends Component
{
    public Owner $owner;
    public Album $album;

    public function render()
    {
        $this->dispatch('initMasonry');

        $this->album->data = json_decode($this->album->data, true);
        return view('livewire.owner.albums.content-album');
    }
}
