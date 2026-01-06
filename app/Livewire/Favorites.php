<?php

namespace App\Livewire;

use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Favorites extends Component
{
    public function render()
    {
        $favs = Owner::favoritedByCustomers(Auth::guard('customer')->user()->id)
            ->whereNotNull('username')
            ->where('username', '!=', '')
            ->orderBy('statusChangedAt', 'desc')
            ->get();        

        return view('livewire.favorites', [
            'favorites' => $favs,
            'favs' => $favs->pluck('id')->toArray()
        ]);
    }
}
