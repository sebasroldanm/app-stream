<?php

namespace App\Livewire;

use App\Models\Owner;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Actions extends Component
{
    public function render()
    {
        return view('livewire.actions');
    }

    public function updateOnline()
    {
        Artisan::call('app:update-online');
        $this->dispatch('updateOnline');
    }

    public function updateAll()
    {
        Artisan::call('app:update-owners-data');
        $this->dispatch('updateAll');
    }
}
