<?php

namespace App\Livewire;

use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class RightSidebar extends Component
{
    public $owners = [];

    protected int $onlineLimit = 15;
    protected int $offlineLimit = 10;

    public function mount()
    {
        $this->owners = $this->getCachedOwners();
    }

    public function render()
    {
        return view('components.layouts.right-sidebar', [
            'owners' => $this->owners,
        ]);
    }

    protected function getCachedOwners()
    {
        $customerId = Auth::guard('customer')->id();

        return Cache::remember(
            $this->getCacheKey($customerId),
            now()->addSeconds(20),
            fn () => $this->loadOwners($customerId)
        );
    }

    protected function getCacheKey(int $customerId): string
    {
        return "owners:right-sidebar:customer:{$customerId}";
    }

    protected function loadOwners(int $customerId)
    {
        return $this->getFavOnlineOwners($customerId)
            ->concat($this->getNonFavOnlineOwners($customerId))
            ->concat($this->getOfflineOwners());
    }

    protected function getFavOnlineOwners(int $customerId)
    {
        return Owner::favoritedByCustomers($customerId)
            ->where('isOnline', true)
            ->orderByDesc('statusChangedAt')
            ->get();
    }

    protected function getNonFavOnlineOwners(int $customerId)
    {
        return Owner::where('isOnline', true)
            ->notFavoritedByCustomer($customerId)
            ->orderByDesc('statusChangedAt')
            ->limit($this->onlineLimit)
            ->get();
    }

    protected function getOfflineOwners()
    {
        return Owner::where('isOnline', false)
            ->orderByDesc('statusChangedAt')
            ->limit($this->offlineLimit)
            ->get();
    }
}
