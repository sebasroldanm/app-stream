<?php

namespace App\Livewire\Owner;

use App\Models\Owner;
use Livewire\Component;

class Live extends Component
{
    public Owner $owner;
    public $mainCol = 'col-9';
    public $sideCol = 'col-3';

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
        $this->owner->data = json_decode($this->owner->data);
        $this->broadcastSettings = $this->owner->data->cam->broadcastSettings;

        if ($this->owner->isMobile) {
            $this->mainCol = 'col-8';
            $this->sideCol = 'col-4';
        }

        return view('livewire.owner.live');
    }
}
