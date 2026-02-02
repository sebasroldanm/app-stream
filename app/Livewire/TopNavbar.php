<?php

namespace App\Livewire;

use App\Models\Owner;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class TopNavbar extends Component
{
    public $themeApp;
    public $online_app = 0;

    public function mount()
    {
        if (session()->has('themeApp')) {
            $this->themeApp = session('themeApp');
        } else {
            session()->put('themeApp', env('THEME_APP', 'light'));
            $this->themeApp = session('themeApp');
        }

        $this->online_app = Cache::remember('online_app', 60, function () {
            return Owner::where('isOnline', true)->count();
        });
    }

    public function togglethemeApp()
    {
        $this->themeApp = $this->themeApp === 'light' ? 'dark' : 'light';
        session()->put('themeApp', $this->themeApp);

        $this->dispatch('themeApp', theme: $this->themeApp);
    }
    public function render()
    {
        return view('components.layouts.top-navbar');
    }
}
