<?php

namespace App\Livewire\Timeline;

use App\Models\Feed;
use App\Traits\OwnerProp;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Post extends Component
{
    use OwnerProp;
    
    public $limit = 10;

    public function placeholder()
    {
        return view('livewire.timeline.post-placeholder');
    }

    public function render()
    {
        $feeds = $this->getFeeds();

        $this->dispatch('initFullviewer');

        $this->dispatch('initVideos');

        return view('livewire.timeline.post', [
            'feeds' => $feeds
        ]);
    }

    public function loadMore()
    {
        $this->limit += 10;
    }

    private function getFeeds()
    {
        return Cache::remember('timeline_limit_' . $this->limit, 1, function () {
            return Feed::with(["owner", "albumFeed.photos", "videoFeed", "postFeed.mediaPostFeeds"])
                ->orderBy("updatedAt", "desc")
                ->orderBy("id", "desc")
                ->limit($this->limit)
                ->get();
        });
    }
}
