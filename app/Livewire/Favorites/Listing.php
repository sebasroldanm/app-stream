<?php

namespace App\Livewire\Favorites;

use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Listing extends Component
{
    public function placeholder()
    {
        return view('livewire.favorites.listing-placeholder');
    }

    public function render()
    {
        return view('livewire.favorites.listing', [
            'favorites' => $this->getFavorites(),
            'favs' => $this->getFavorites()->pluck('id')->toArray()
        ]);
    }

    private function getFavorites()
    {
        return Owner::favoritedByCustomers(Auth::guard('customer')->user()->id)
            ->whereNotNull('username')
            ->where('username', '!=', '')
            ->orderByDesc('isLive')
            ->orderByDesc('statusChangedAt')
            ->get();
    }
}
