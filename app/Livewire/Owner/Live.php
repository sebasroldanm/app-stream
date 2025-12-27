<?php

namespace App\Livewire\Owner;

use App\Models\Owner;
use Livewire\Component;

class Live extends Component
{
    public Owner $owner;

    public function render()
    {
        return view('livewire.owner.live');
    }
}
