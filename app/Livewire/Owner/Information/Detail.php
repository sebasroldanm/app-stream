<?php

namespace App\Livewire\Owner\Information;

use App\Models\Owner;
use Carbon\Carbon;
use Livewire\Component;
use App\Traits\OwnerProp;

class Detail extends Component
{

    use OwnerProp;
    public Owner $owner;

    public function render()
    {
        if (isset($this->owner->data) && $this->owner->data !== 'null') {
            if (is_string($this->owner->data)) {
                $this->owner->data = json_decode($this->owner->data, false);
            }
            $languages = $this->flagsLanguages($this->owner->data->user->user->languages);
            $country = $this->flagCountry($this->owner->data->user->user->country);
            $age = Carbon::now()->diff(Carbon::parse($this->owner->data->user->user->birthDate))->y;

            $statusChangedAt = Carbon::parse($this->owner->statusChangedAt);
            $offlineStatusUpdatedAt = Carbon::parse($this->owner->offlineStatusUpdatedAt);
            $wentIdleAt = Carbon::parse($this->owner->data->user->user->wentIdleAt);
            $lasSnapshot = Carbon::parse($this->owner->data->user->user->snapshotTimestamp);
            $ratingPrivate = $this->owner->data->user->user->ratingPrivate ?? false;

            $this->dispatch('initFullviewer');

            return view('livewire.owner.information.detail', [
                'languages' => $languages,
                'country' => $country,
                'age' => $age,
                'lastActive' => $statusChangedAt->copy()->diffForHumans(),
                'lastOffline' => $offlineStatusUpdatedAt->copy()->diffForHumans(),
                'activeHuman' => $statusChangedAt->copy()->calendar(),
                'offlineHuman' => $offlineStatusUpdatedAt->copy()->calendar(),
                'idleCalendar' => $wentIdleAt->copy()->addHours(5)->calendar(),
                'idleDiff' => $wentIdleAt->copy()->diffForHumans(),
                'snapshotCalendar' => $lasSnapshot->copy()->addHours(5)->calendar(),
                'snapshotDiff' => $lasSnapshot->copy()->diffForHumans(),
                'ratingPrivate' => $ratingPrivate,
            ]);
        }

        return view('livewire.owner.information.detail');
    }
}
