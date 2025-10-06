<?php

namespace App\Livewire\Owner;

use App\Models\Owner;
use Livewire\Component;

class Information extends Component
{
    public Owner $owner;

    public string $activeTab = 'detail';

    private array $validTabs = [
        'detail', 'panel', 'snapshots', 'similarity', 'info-custom', 'media-custom',
    ];

    public function loadComponent(string $tab)
    {
        if (in_array($tab, $this->validTabs)) {
            $this->activeTab = $tab;
        }
    }

    public function render()
    {
        return view('livewire.owner.information');
    }
}
