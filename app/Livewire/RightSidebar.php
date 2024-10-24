<?php

namespace App\Livewire;

use App\Models\Owner;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class RightSidebar extends Component
{

    public $owners = [];
    public $limit = 10;

    public function render()
    {
        $this->loadData();
        return view('components.layouts.right-sidebar', [
            'owners' => $this->owners
        ]);
    }

    public function loadData()
    {
        $this->owners = Cache::remember('owners_right_sidebar', 300, function () {
            return Owner::with('latestSnapshots')
                ->orderBy('isLive', 'DESC')
                ->orderBy('isOnline', 'DESC')
                ->limit(10)
                ->get();
        });
    }
}
