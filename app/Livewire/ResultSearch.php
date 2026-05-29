<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Services\Owner\OwnerSearchService;
use App\Traits\OwnerProp;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ResultSearch extends Component
{
    use OwnerProp;

    public ?string $keyword;

    public function mount()
    {
        $this->keyword = request()->q;
    }

    public function render(OwnerSearchService $ownerSearchService)
    {
        $response = $ownerSearchService->searchAll($this->keyword);
        $owners = collect($response->groups?->username ?? []);

        $user = Auth::guard('customer')->user();
        $favs = $user ? Customer::find($user->id)->getOwnerFavoriteIds()->toArray() : [];

        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.result-search', compact('owners', 'favs'));
        return $view->layoutData([
            'title' => ' | Resultados para ' . $this->keyword,
        ]);
    }
}
