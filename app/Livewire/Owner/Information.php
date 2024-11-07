<?php

namespace App\Livewire\Owner;

use App\Models\Owner;
use Livewire\Component;

class Information extends Component
{

    public Owner $owner;

    public $showPanel = false;
    public $showDetail = true;
    public $showSnapshots = false;
    public $showSimilarity = false;
    public $showInfoCustom = false;
    public $showMediaCustom = false;

    protected $listeners = ['loadInfoComponent' => 'render'];

    public function loadComponent($component)
    {
        switch ($component) {
            case 'panel':
                $this->showPanel = true;
                $this->showDetail = false;
                $this->showSnapshots = false;
                $this->showSimilarity = false;
                $this->showInfoCustom = false;
                $this->showMediaCustom = false;
                break;
            case 'detail':
                $this->showPanel = false;
                $this->showDetail = true;
                $this->showSnapshots = false;
                $this->showSimilarity = false;
                $this->showInfoCustom = false;
                $this->showMediaCustom = false;
                break;
            case 'snapshots':
                $this->showPanel = false;
                $this->showDetail = false;
                $this->showSnapshots = true;
                $this->showSimilarity = false;
                $this->showInfoCustom = true;
                $this->showMediaCustom = false;
                break;
            case 'similarity':
                $this->showPanel = false;
                $this->showDetail = false;
                $this->showSnapshots = false;
                $this->showSimilarity = true;
                $this->showInfoCustom = false;
                $this->showMediaCustom = false;
                break;
            case 'info-custom':
                $this->showPanel = false;
                $this->showDetail = false;
                $this->showSnapshots = false;
                $this->showSimilarity = false;
                $this->showInfoCustom = true;
                $this->showMediaCustom = false;
                break;
            case 'media-custom':
                $this->showPanel = false;
                $this->showDetail = false;
                $this->showSnapshots = false;
                $this->showSimilarity = false;
                $this->showInfoCustom = false;
                $this->showMediaCustom = true;
                break;
        }
    }

    public function render()
    {
        return view('livewire.owner.information');
    }
}
