<?php

namespace App\Livewire;

use Livewire\Component;

class Timeline extends Component
{
    public function render()
    {
        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.timeline');

        return $view->layoutData(['title' => ' | Timeline']);
    }
}
