<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Owner;
use App\Traits\SyncData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Home extends Component
{
    use SyncData;

    public $owners;

    public $favs;

    public $orderBy = 'statusChangedAt';
    // public $orderBy = 'created_at';
    public $orderDir = 'desc';
    public $listLives = false;
    public $listFavs = null;

    public $limit = 24;

    public $search = '';

    public $newOwner;

    public function mount()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.logout');
        }
    }

    public function moreLimit()
    {
        $this->limit += 18;
    }

    public function lessLimit()
    {
        $this->limit -= 18;
        if ($this->limit < 6) {
            $this->limit = 6;
        }
    }

    public function listLivesChange() {
        $this->listLives = !$this->listLives;
    }

    public function ListFavorites() {
        $this->listFavs = !$this->listFavs;
    }

    public function order()
    {
        $this->orderDir = ($this->orderDir == 'asc') ? 'asc' : 'desc';
    }

    public function searchByText()
    {
        $this->search = trim($this->search);
    }

    public function render()
    {
        $this->favs = Customer::find(Auth::guard('customer')->user()->id)->getOwnerFavoriteIds()->toArray();
        
        if ($this->search != '') {
            $this->owners = Owner::whereRaw("MATCH(username) AGAINST(? IN BOOLEAN MODE)", ['"' . $this->search . '"'])->get();
            if ($this->owners->count() == 1) {
                return view('livewire.home');
            }
            $this->owners = Owner::select('*')
                ->with('latestSnapshots')
                ->where('username', 'like', '%' . $this->search . '%')
                ->orderBy($this->orderBy, $this->orderDir)
                ->limit($this->limit)
                ->get();
        } else {
            $this->owners = Owner::select('*')
                ->with('latestSnapshots')
                ->when($this->listLives, function ($query) {
                    $query->where('isLive', true);
                })
                ->when($this->listFavs !== null && $this->listFavs != false, function ($query) {
                    $favs = Customer::find(Auth::guard('customer')->user()->id)->getOwnerFavoriteIds()->toArray();
                    $query->whereIn('id', $favs);
                })
                // ->orderBy('isLive', 'DESC')
                // ->orderBy('isOnline', 'DESC')
                ->orderBy($this->orderBy, $this->orderDir)
                ->limit($this->limit)
                ->get();
        }

        return view('livewire.home');
    }

    public function addOwner()
    {
        $this->syncOwnerByUsername($this->newOwner);
    }
}
