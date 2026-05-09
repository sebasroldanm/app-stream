<?php

namespace App\Livewire\Timeline;

use App\Models\Customer;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Favorites extends Component
{
    public function placeholder()
    {
        return view('livewire.timeline.favorites-placeholder');
    }

    public function render()
    {
        return view('livewire.timeline.favorites', [
            'favorites' => $this->getFavorites(),
        ]);
    }

    private function getFavorites()
    {
        $favs = Customer::find(Auth::guard('customer')->user()->id)->getOwnerFavoriteIds()->toArray();

        return Cache::remember('timeline_favs', 20, function () use ($favs) {
            return Owner::whereIn('id', $favs)
                ->where('isOnline', true)
                ->limit(6)
                ->orderBy('favoritedCount', 'desc')
                ->get();
        });
    }
}
