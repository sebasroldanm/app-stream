<?php

namespace App\Livewire\Owner\Information;

use App\Models\Owner;
use Carbon\Carbon;
use Livewire\Component;

class Detail extends Component
{

    public Owner $owner;

    public function render()
    {
        $this->owner->data = json_decode($this->owner->data);
        if (isset($this->owner->data)) {
            $age = Carbon::now()->diff(Carbon::parse($this->owner->data->user->user->birthDate))->y;
            return view('livewire.owner.information.detail', [
                'age' => $age
            ]);
        }

        return view('livewire.owner.information.detail');
    }
}
