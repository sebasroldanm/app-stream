<?php

namespace App\Livewire\Owner;

use App\Models\Feed as ModelsFeed;
use App\Models\Owner;
use App\Models\Photos;
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
            $this->languages = $this->stringLaguages($owner->data->user->user->languages);
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

        $this->dispatch('initFullviewer');

        $this->dispatch('initVideosFeed');

        return view('livewire.owner.feed', [
            'owner'     => $owner,
            'photos'    => $photos,
            'videos'    => $videos,
            'feeds'     => $feeds,
            'totalFeeds' => ModelsFeed::where("owner_id", $owner->id)->count(),
        ]);
    }

    public function loadMore()
    {
        $this->limit += 6;
    }
}
