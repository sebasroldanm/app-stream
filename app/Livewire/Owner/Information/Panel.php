<?php

namespace App\Livewire\Owner\Information;

use App\Models\Owner;
use App\Models\Panel as ModelsPanel;
use Livewire\Component;

class Panel extends Component
{

    public Owner $owner;

    public function render()
    {
        $panels = ModelsPanel::where('owner_id', $this->owner->id)->orderBy('order')->orderBy('column')->get();

        // dd($panels);
        return view('livewire.owner.information.panel', [
            'panels' => $panels
        ]);
    }
}
