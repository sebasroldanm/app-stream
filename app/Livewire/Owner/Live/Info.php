<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use App\Traits\SyncData;
use Livewire\Component;

class Info extends Component
{
    use SyncData;

    public Owner $owner;
    
    public function render()
    {
        $this->syncOwnerByUsername($this->owner->username);

        $this->owner = Owner::where('id', $this->owner->id)->first();
        
        $this->dispatch('ownerUpdated');

        $this->owner->data = json_decode($this->owner->data);

        return view('livewire.owner.live.info');
    }
}