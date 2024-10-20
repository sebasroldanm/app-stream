<?php

namespace App\Livewire\Owner;

use App\Models\Owner;
use App\Models\Photos;
use App\Models\Video;
use App\Traits\OwnerProp;
use Carbon\Carbon;
use Livewire\Component;

class Feed extends Component
{
    use OwnerProp;

    public $idOwner;

    public $description = false;
    // ------------------------------------------
    public $country = false;
    public $city = false; // If exist
    public $languages = false; // If exist
    public $birthDate = false;
    public $age = false;
    public $gender = false; // If exist

    public function mount($idOwner = false)
    {
        $this->idOwner = $idOwner;
    }

    public function render()
    {
        $owner = Owner::find($this->idOwner);
        $owner->data = json_decode($owner->data);

        $this->country = $this->flagCountry($owner->country);
        $this->city = 'Medellin';
        $this->languages = $this->stringLaguages($owner->data->user->user->languages);
        if ($owner->data) {
            $this->description = $owner->data->user->user->description;
            $this->gender = $owner->data ? $this->iconGender($owner->gender) : false;
            $this->birthDate = $owner->data->user->user->birthDate;
            $this->age = Carbon::now()->diff(Carbon::parse($owner->data->user->user->birthDate))->y;
        }

        $photos = Photos::where('ownerId', $this->idOwner)->where('url', '!=', '')->limit(9)->get();
        $videos = Video::where('owner_id', $this->idOwner)->where('coverUrl', '!=', '')->limit(9)->get();

        return view('livewire.owner.feed', [
            'owner' => $owner,
            'photos' => $photos,
            'videos' => $videos
        ]);
    }
}
