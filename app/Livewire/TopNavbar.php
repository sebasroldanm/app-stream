<?php

namespace App\Livewire;

use Livewire\Component;

class TopNavbar extends Component
{
    public $themeApp = 'light';

    public function mount()
    {
        $this->themeApp = session('themeApp', 'light');
    }

    public function togglethemeApp()
    {
        $this->themeApp = $this->themeApp === 'light' ? 'dark' : 'light';
        session(['themeApp' => $this->themeApp]);

        $this->dispatch('themeApp', theme: $this->themeApp);
    }
    public function render()
    {
        return view('components.layouts.top-navbar');
    }
}
