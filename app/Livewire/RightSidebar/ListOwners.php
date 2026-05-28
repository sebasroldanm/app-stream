<?php

namespace App\Livewire\RightSidebar;

use App\Models\Owner;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;

#[Lazy]
class ListOwners extends Component
{
    public $owners = [];

    protected int $onlineLimit = 15;
    protected int $offlineLimit = 10;

    public function mount()
    {
        $this->owners = $this->getCachedOwners();
    }

    public function placeholder()
    {
        return view('components.layouts.right-sidebar.list-owners-placeholder');
    }

    public function render()
    {
        return view('components.layouts.right-sidebar.list-owners', [
            'owners' => $this->owners,
        ]);
    }

    #[On('owners-updated')]
    public function refresh()
    {
        Cache::forget($this->getCacheKey(Auth::guard('customer')->id()));
        $this->owners = $this->getCachedOwners();
    }

    protected function getCachedOwners()
    {
        $customerId = Auth::guard('customer')->id();

        return Cache::remember(
            $this->getCacheKey($customerId),
            now()->addSeconds(20),
            fn() => $this->loadOwners($customerId)
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
            ->orderByDesc('isLive')
            ->orderByDesc('statusChangedAt')
            ->get();
    }

    protected function getNonFavOnlineOwners(int $customerId)
    {
        return Owner::where('isOnline', true)
            ->notFavoritedByCustomer($customerId)
            ->orderByDesc('isLive')
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
