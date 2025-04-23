<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Feed;
use App\Models\Owner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Timeline extends Component
{
    public $feeds = [];
    public $owner_birthday = [];
    public $owner_fav = [];
    public $limit = 30;

    public function render()
    {
        $favs = Customer::find(Auth::guard('customer')->user()->id)->getOwnerFavoriteIds()->toArray();

        $this->feeds = Feed::with(["owner", "albumFeed.photos", "videoFeed", "postFeed.mediaPostFeeds"])
            ->orderBy("updatedAt", "desc")
            ->limit($this->limit)
            ->get();
            
        $today = Carbon::now();
        // Cache::forget('timeline_birthdays');
        $this->owner_birthday = Cache::remember('timeline_birthdays', 20, function() use($today) {
            return Owner::whereNotNull('data->user->user->birthDate')
            ->limit(5)
            ->get();
        });
        
        // Cache::forget('timeline_favs');
        $this->owner_fav = Cache::remember('timeline_favs', 20, function() use($favs) {
            return Owner::whereIn('id', $favs)
                ->where('isOnline', true)
                ->limit(6)
                ->get();
        });
        
        return view('livewire.timeline');
    }
}
