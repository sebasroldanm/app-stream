<?php

namespace App\Livewire;

use App\Models\Owner;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class RightSidebar extends Component
{

    public $owners = [];
    public $countOnline = 0;
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
        // Cache::forget('online_right_sidebar');
        $this->countOnline = Cache::remember('online_right_sidebar', 20, function () {
            return Owner::where('isOnline', true)->count();
        });

        // Cache::forget('owners_right_sidebar');
        $this->owners = Cache::remember('owners_right_sidebar', 20, function () {
            // return Owner::with('latestSnapshots')
            return Owner::orderBy('isLive', 'DESC')
                ->orderBy('isOnline', 'DESC')
                ->limit($this->limit + $this->countOnline)
                ->get();
        });
    }
}
