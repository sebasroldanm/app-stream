<?php

namespace App\Livewire\Owner;

use App\Models\Feed as ModelsFeed;
use App\Models\Owner;
use App\Models\Photos;
use App\Models\Post;
use App\Models\Video;
use App\Traits\OwnerProp;
use App\Traits\SyncData;
use Carbon\Carbon;
use Livewire\Component;

class Feed extends Component
{
    use OwnerProp, SyncData;

    public Owner $owner;

    public $description = false;
    // ------------------------------------------
    public $country = false;
    public $city = false; // If exist
    public $languages = false; // If exist
    public $birthDate = false;
    public $age = false;
    public $gender = false; // If exist
    public $limit = 6;

    public function render()
    {
        $owner = $this->owner;
        
        if (is_string($this->owner->data)) {
            $this->owner->data = json_decode($this->owner->data, false);
        }

        $this->country = $this->flagCountry($owner->country);
        $this->city = 'Medellin';
        if (isset($owner->data)) {
            $this->languages = $this->flagsLanguages($owner->data->user->user->languages);
            $this->description = $owner->data->user->user->description;
            $this->gender = $owner->data ? $this->iconGender($owner->gender) : false;
            $this->birthDate = $owner->data->user->user->birthDate;
            $this->age = Carbon::now()->diff(Carbon::parse($owner->data->user->user->birthDate))->y;
        }

        $photos = Photos::where('ownerId', $owner->id)->where('url', '!=', '')->limit(9)->get();
        $videos = Video::where('owner_id', $owner->id)->where('coverUrl', '!=', '')->limit(9)->get();

        $feeds = ModelsFeed::with(["owner", "albumFeed.photos", "videoFeed", "postFeed.mediaPostFeeds"])
            ->where("owner_id", $owner->id)
            ->orderBy("updatedAt", "desc")
            ->orderBy("id", "desc")
            ->limit($this->limit)
            ->get();
        
        $posts = Post::with(['telegramMessage.captions', 'telegramMessage.photo', 'telegramMessage.video'])
            ->where('fk_owners_id', $owner->id)
            ->orderBy('published_at', 'desc')
            ->limit($this->limit)
            ->get();

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

        $this->dispatch('initFullviewer');

        $this->dispatch('initVideos');

        return view('livewire.owner.feed', [
            'owner'     => $owner,
            'photos'    => $photos,
            'videos'    => $videos,
            'items'     => $items,
            'totalItems' => ModelsFeed::where("owner_id", $owner->id)->count() + Post::where('fk_owners_id', $owner->id)->count(),
        ]);
    }

    public function loadMore()
    {
        $this->limit += 6;
    }
}
