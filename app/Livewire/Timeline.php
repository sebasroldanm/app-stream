<?php

namespace App\Livewire;

use App\Models\Feed;
use App\Traits\OwnerProp;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Timeline extends Component
{
    use OwnerProp;
    public $limit = 10;

    public function loadMore()
    {
        $this->limit += 10;
    }

    public function render()
    {
        // Cache depends on limit now
        $feeds = Cache::remember('timeline_limit_' . $this->limit, 1, function () {
            return Feed::with(["owner", "albumFeed.photos", "videoFeed", "postFeed.mediaPostFeeds"])
                ->orderBy("updatedAt", "desc")
                ->orderBy("id", "desc")
                ->limit($this->limit)
                ->get();
        });

        $this->dispatch('initFullviewer');

        $this->dispatch('initVideos');

        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.timeline', [
            'feeds' => $feeds
        ]);
        return $view->layoutData(['title' => ' | Timeline']);
    }
}
