<?php

namespace App\Livewire;

use Livewire\Component;

class Explore extends Component
{
    public function render()
    {
        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.explore');
        return $view->layoutData(['title' => ' | Explorar']);
    }
}
