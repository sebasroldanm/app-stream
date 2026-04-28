<?php

namespace App\Livewire\Owner;

use App\Models\Customer;
use App\Models\Owner;
use App\Services\Owner\OwnerRelatedService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\Attributes\Lazy;

#[Lazy]
class Related extends Component
{
    public function placeholder()
    {
        return view('livewire.owner.related-placeholder');
    }
    public $owner;
    public $related;

    public function mount(Owner $owner, OwnerRelatedService $relatedService)
    {
        $this->owner = $owner;
        $this->related = $relatedService->getRelated($owner->username) ?? [];
    }

    public function render()
    {
        $user = Auth::guard('customer')->user();
        $favs = $user ? Customer::find($user->id)->getOwnerFavoriteIds()->toArray() : [];

        if (!empty($this->related) && count($this->related->models) > 0) {
            $this->dispatch('init-swiper');
        }

        return view('livewire.owner.related', [
            'favs' => $favs
        ]);
    }
}
