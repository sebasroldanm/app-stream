<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Actions extends Component
{
    public $message = null;
    public $status = null;

    public function checkNotifications()
    {
        if (Cache::has('Notification')) {
            $this->message = Cache::pull('Notification');
            $this->status = Cache::pull('Status');
            $this->dispatch('notify', message: $this->message);
        }
    }

    public function render()
    {
        return view('livewire.actions');
    }

    public function updateOnline()
    {
        Artisan::call('app:update-online');
        $this->dispatch('updateOnline');
    }

    public function updateAll()
    {
        Artisan::call('app:update-owners-data');
        $this->dispatch('updateAll');
    }

    public function updateFavorites()
    {
        Artisan::call('app:update-favorites');
        $this->dispatch('updateFavorites');
    }

    public function updateFeed()
    {
        Artisan::call('app:update-feed');
        $this->dispatch('updateFeed');
    }
}