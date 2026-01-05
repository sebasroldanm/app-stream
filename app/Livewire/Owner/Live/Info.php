<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use App\Traits\SyncData;
use Livewire\Component;

class Info extends Component
{
    use SyncData;

    public Owner $owner;

    public $lastPercent = 0;
    public $percent = 0;

    public function render()
    {
        $this->syncOwnerByUsername($this->owner->username);

        $this->owner = Owner::where('id', $this->owner->id)->first();

        $this->owner->data = json_decode($this->owner->data);

        if (isset($this->owner->data->cam->goal->goal) && $this->owner->data->cam->goal->goal > 0) {
            $percent = ($this->owner->data->cam->goal->spent * 100) / $this->owner->data->cam->goal->goal;
            $this->percent = (round($percent) > 100) ? 100 : round($percent, 1);

            if ($this->lastPercent != $percent) {
                $this->lastPercent = $percent;
                $this->dispatch('updateBarInfo', [
                    'left' => $this->owner->data->cam->goal->left,
                    'goal' => $this->owner->data->cam->goal->goal,
                    'spent' => $this->owner->data->cam->goal->spent,
                    'description' => $this->owner->data->cam->goal->description,
                    'percent' => $this->percent,
                ]);
            }
        }

        // Implementar
        // https://design.spiderbees.com/bootstrap5/html-dark/chat.html

        return view('livewire.owner.live.info');
    }
}
