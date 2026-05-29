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

    public function render()
    {
        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.actions');
        return $view->layoutData(['title' => ' | Acciones']);
    }

    public function updateOnline()
    {
        Artisan::call('app:update-online');
    }

    public function updateAll()
    {
        Artisan::call('app:update-owners-data');
    }

    public function updateFavorites()
    {
        $this->lastUpdate = now();
        Artisan::call('app:update-favorites');
    }

    public function updateFeed()
    {
        Artisan::call('app:update-feed');
    }

    public function updateConversations()
    {
        Artisan::call('app:update-conversation');
    }
}
