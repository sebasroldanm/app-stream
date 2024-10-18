<?php

namespace App\Livewire;

use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Home extends Component
{
    public $mods;

    public $orderBy = 'created_at';
    public $orderDir = 'asc';
    public $textOrder = 'Descendente';

    public $limit = 24;

    public $search = '';

    public function mount() {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.logout');
        }
    }

    public function moreLimit() {
        $this->limit += 18;
    }

    public function lessLimit() {
        $this->limit -= 18;
        if ($this->limit < 6) {
            $this->limit = 6;
        }
    }

    public function order() {
        $this->orderDir = ($this->orderDir == 'asc') ? 'asc' : 'desc';
    }

    public function searchByText() {
        $this->search = trim($this->search);
    }

    public function render()
    {
        if ($this->search != '') {
            $this->mods = Owner::select('*')
                ->where('username', 'like', '%' . $this->search . '%')
                ->orderBy($this->orderBy, $this->orderDir)
                ->limit($this->limit)
                ->get();
        } else {
            $this->mods = Owner::select('*')
                ->orderBy($this->orderBy, $this->orderDir)
                ->limit($this->limit)
                ->get();
        }

        return view('livewire.home');
    }
}
