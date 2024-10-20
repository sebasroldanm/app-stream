<?php

namespace App\Livewire\Owner;

use Livewire\Component;

class Information extends Component
{

    protected $listeners = ['loadInfoComponent' => 'render'];

    public function render()
    {
        return view('livewire.owner.information');
    }
}
