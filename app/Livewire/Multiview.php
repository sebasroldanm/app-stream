<?php

namespace App\Livewire;

use Livewire\Component;

class Multiview extends Component
{
    public $selectedOwners = [];

    public function toggleOwner($ownerId)
    {
        $ownerId = (int) $ownerId;
        if (($key = array_search($ownerId, $this->selectedOwners)) !== false) {
            unset($this->selectedOwners[$key]);
            $this->selectedOwners = array_values($this->selectedOwners);
        } else {
            if (count($this->selectedOwners) < 12) {
                $this->selectedOwners[] = $ownerId;
            }
        }
    }

    public function render()
    {
        $liveOwners = \App\Models\Owner::where('isLive', true)
            ->where('isActive', true)
            ->orderBy('name')
            ->get();

        return view('livewire.multiview', [
            'liveOwners' => $liveOwners,
        ]);
    }
}
