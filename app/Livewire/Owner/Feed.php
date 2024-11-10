<?php

namespace App\Livewire\Owner;

use App\Models\Feed as ModelsFeed;
use App\Models\Owner;
use App\Models\Photos;
use App\Models\Video;
use App\Traits\OwnerProp;
use Carbon\Carbon;
use Livewire\Component;

class Feed extends Component
{
    use OwnerProp;

    public Owner $owner;

    public $description = false;
    // ------------------------------------------
    public $country = false;
    public $city = false; // If exist
    public $languages = false; // If exist
    public $birthDate = false;
    public $age = false;
    public $gender = false; // If exist

    public function render()
    {
        $owner = $this->owner;

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

        $feeds = ModelsFeed::with(["albumFeed.photos", "videoFeed", "postFeed.mediaPostFeeds"])
            ->orderBy("updatedAt", "desc")
            ->where("owner_id", $owner->id)
            // ->where("id", 12062136)
            // ->limit(3)
            ->get();

        $this->dispatch('initFullviewer');

        $this->dispatch('initVideosFeed');

        return view('livewire.owner.feed', [
            'owner'     => $owner,
            'photos'    => $photos,
            'videos'    => $videos,
            'feeds'     => $feeds
        ]);
    }
}
