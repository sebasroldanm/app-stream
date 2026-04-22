<?php

namespace App\Livewire\Owner;

use App\Models\Owner;
use Livewire\Component;

class Live extends Component
{
    public Owner $owner;
    public $mainCol = 'col-12 col-sm-9';
    public $sideCol = 'col-12 col-sm-3';

    public $broadcastSettings = [];

    protected $listeners = ['ownerUpdated' => 'refreshOwner'];

    public function refreshOwner()
    {
        $this->owner->refresh();

        // Example logic: You can adjust columns based on owner state here
        // if ($this->owner->isMobile) {
        //     $this->mainCol = 'col-8';
        //     $this->sideCol = 'col-4';
        // }
    }

    public function render()
    {
        $this->broadcastSettings = $this->owner->ownerCamBroadcastConfig;
        if ($this->owner->isMobile) {
            $this->mainCol = 'col-12 col-sm-8';
            $this->sideCol = 'col-12 col-sm-4';
        }

        $this->dispatch('initFullviewer');

        return view('livewire.owner.live');
    }
}
