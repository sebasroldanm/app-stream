<?php

namespace App\Livewire;

use Livewire\Component;

class NoticeAge extends Component
{

    public $notice_age;

    public function mount()
    {
        if (session()->has('notice_age')) {
            $this->notice_age = session('notice_age');
        } else {
            $this->notice_age = !env('PARENTAL_CONTROL', true);
        }
    }

    public function render()
    {
        $title = env('PARENTAL_TITLE');
        $message = env('PARENTAL_MESSAGE');
        return view('components.layouts.notice-age', compact('title', 'message'));
    }

    public function confirmAge()
    {
        session()->put('notice_age', true);
        $this->notice_age = true;
        $this->dispatch('notice-age-confirmed');
    }
}
