<?php

namespace App\Livewire;

use Livewire\Component;

class Favorites extends Component
{
    public function render()
    {
        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.favorites');

        return $view->layoutData(['title' => ' | Favoritos']);
    }
}
