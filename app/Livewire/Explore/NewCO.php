<?php

namespace App\Livewire\Explore;

use App\Services\Explore\ExploreService;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NewCO extends Component
{
    
    public $data;
    public $owners = [];
    public $limit = 60;
    public $offset = 0;
    public $endResults = false;


    public function render()
    {
        $this->loadData();

        $favs = Customer::find(Auth::guard('customer')->user()->id)->getOwnerFavoriteIds()->toArray();

        $this->dispatch('initExplorer');

        return view('livewire.explore.new-c-o', [
            'favs' => $favs
        ]);
    }

    public function nextPage()
    {
        $this->offset += 60;
    }

    private function loadData()
    {
        $this->data = app(ExploreService::class)->filterSearch(
            $this->limit,
            $this->offset,
            [['tagLanguageColombian'], ['autoTagNew']],
            'autoTagNew'
        );

        if ($this->data && isset($this->data->models)) {
            array_push($this->owners, ...$this->data->models);
            if (count($this->data->models) !== $this->limit) {
                $this->endResults = true;
            }
        } else {
            $this->data = false;
        }
    }
}
