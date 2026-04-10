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
            ->orderByDesc('isLive')
            ->orderByDesc('statusChangedAt')
            ->get();

        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.favorites', [
            'favorites' => $favs,
            'favs' => $favs->pluck('id')->toArray()
        ]);
        return $view->layoutData(['title' => ' | Favoritos']);
    }
}
