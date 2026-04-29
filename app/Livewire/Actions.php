<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Actions extends Component
{
    public string $message = '';
    public string $status = '';
    public $lastUpdate;

    public function checkNotifications()
    {
        if (Cache::has('Notification')) {
            $this->message = Cache::pull('Notification');
            $this->status = Cache::pull('Status');
            $this->dispatch('notify', message: $this->message);
            $this->dispatch('owners-updated');
        }
    }

    public function render()
    {
        if ($this->lastUpdate < now()->subMinutes(2)) {
            $this->updateFavorites();
            $this->updateOnline();
        }

        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.actions');
        return $view->layoutData(['title' => ' | Acciones']);
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
        $this->lastUpdate = now();
        Artisan::call('app:update-favorites');
        $this->dispatch('updateFavorites');
    }

    public function updateFeed()
    {
        Artisan::call('app:update-feed');
        $this->dispatch('updateFeed');
    }
}