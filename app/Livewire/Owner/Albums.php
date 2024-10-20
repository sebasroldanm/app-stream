<?php

namespace App\Livewire\Owner;

use App\Models\Album;
use Livewire\Component;

class Albums extends Component
{
    public $idOwner;

    public $id_selected;

    public function mount($idOwner = false)
    {
        $this->idOwner = $idOwner;
    }

    public function render()
    {
        $albums = Album::with('photos')
            ->where('owner_id', $this->idOwner)
            ->orderBy('createdAt', 'desc')
            ->orderBy('accessMode', 'asc')
            ->get();
        $this->id_selected = $albums->first()->id;

        return view('livewire.owner.albums', [
            'albums' => $albums,
        ]);
    }
}
