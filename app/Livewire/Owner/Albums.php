<?php

namespace App\Livewire\Owner;

use App\Models\Album;
use App\Models\Owner;
use Livewire\Component;

class Albums extends Component
{
    public Owner $owner;

    public function render()
    {
        $albums = Album::with('photos')
            ->where('owner_id', $this->owner->id)
            ->orderBy('createdAt', 'desc')
            ->orderBy('accessMode', 'asc')
            ->get();

        return view('livewire.owner.albums', [
            'albums' => $albums,
        ]);
    }
}
