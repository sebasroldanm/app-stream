<?php

namespace App\Livewire\Owner\Information;

use App\Models\Owner;
use App\Models\Snapshot;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Snapshots extends Component
{
    public Owner $owner;

    public function render()
    {
        $snapshots = Snapshot::where('owner_id', $this->owner->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($snapshot) {
                // Agrupa por día usando solo la fecha (sin la hora)
                return Carbon::parse($snapshot->created_at)->format('Y-m-d');
            });

        $this->dispatch('initFullviewer');

        return view('livewire.owner.information.snapshots', [
            'snapshots' => $snapshots
        ]);
    }
}
