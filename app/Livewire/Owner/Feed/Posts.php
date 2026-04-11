<?php

namespace App\Livewire\Owner\Feed;

use App\Models\Feed;
use App\Models\Owner;
use App\Models\Post;
use App\Traits\OwnerProp;
use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class Posts extends Component
{
    use OwnerProp;

    public $limit = 6;
    public $totalItems = 0;
    public Owner $owner;

    public function mount(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function placeholder()
    {
        return view('components.posts.post-placeholder');
    }

    public function render()
    {
        $posts = $this->getPosts($this->owner);
        return view('livewire.owner.feed.posts',
        [
            'posts' => $posts,
            'owner' => $this->owner,
            'totalItems' => $this->totalItems,
        ]);
    }

    /**
     * Get all posts from the owner
     * 
     * @param Owner $owner
     * @return Collection
     */
    private function getPosts($owner)
    {
        $feeds = Feed::with(["owner", "albumFeed.photos", "videoFeed", "postFeed.mediaPostFeeds"])
            ->where("owner_id", $owner->id)
            ->orderBy("updatedAt", "desc")
            ->orderBy("id", "desc")
            ->limit($this->limit)
            ->get();
        
        $posts = Post::with(['telegramMessage.captions', 'telegramMessage.photo', 'telegramMessage.video', 'telegramMessage.chat'])
            ->where('fk_owners_id', $owner->id)
            ->orderBy('published_at', 'desc')
            ->limit($this->limit)
            ->get();

        $this->totalItems = $feeds->count() + $posts->count();

        $combined = collect();

        foreach ($feeds as $feed) {
            $combined->push((object)[
                'type' => 'feed',
                'date' => $feed->updatedAt,
                'data' => $feed,
            ]);
        }

        $grouped = [];
        foreach ($posts as $post) {
            $parentId = $post->telegramMessage->id_message_parent ?? null;
            if ($parentId) {
                if (!isset($grouped[$parentId])) {
                    $grouped[$parentId] = (object)[
                        'type' => 'post',
                        'date' => $post->published_at,
                        'data' => $post,
                    ];
                    $grouped[$parentId]->data->media = collect();
                    $combined->push($grouped[$parentId]);
                }
                
                // Add media to the group
                if ($post->telegramMessage->photo) {
                    $grouped[$parentId]->data->media->push($post->telegramMessage->photo);
                }
                if ($post->telegramMessage->video) {
                    $grouped[$parentId]->data->media->push($post->telegramMessage->video);
                }

                // If the current post has a body but the group leader doesn't, or it's longer
                if (!empty($post->body) && empty($grouped[$parentId]->data->body)) {
                    $grouped[$parentId]->data->body = $post->body;
                }
            } else {
                $combined->push((object)[
                    'type' => 'post',
                    'date' => $post->published_at,
                    'data' => $post,
                ]);
            }
        }

        $items = $combined->sortByDesc('date')->take($this->limit);

        return $items;
    }

    public function loadMore()
    {
        $this->limit += 6;
    }
}
