<?php

namespace App\Livewire;

use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Multiview extends Component
{
    public $selectedOwners = [];

    public function render()
    {
        $liveOwners = Owner::favoritedByCustomers(Auth::guard('customer')->user()->id)
            ->where('isLive', true)
            ->orderBy('statusChangedAt', 'desc')
            ->limit(50)
            ->get();
        
        return view('livewire.multiview', [
            'liveOwners' => $liveOwners,
        ]);
    }
}
