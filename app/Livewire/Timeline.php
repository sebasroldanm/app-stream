<?php

namespace App\Livewire;

use App\Models\Feed as ModelsFeed;
use Livewire\Component;

class Timeline extends Component
{
    public $feeds = [];
    public $limit = 30;

    public function render()
    {
        $this->feeds = ModelsFeed::with(["owner", "albumFeed.photos", "videoFeed", "postFeed.mediaPostFeeds"])
            ->orderBy("updatedAt", "desc")
            ->limit($this->limit)
            ->get();
        
        return view('livewire.timeline');
    }
}
