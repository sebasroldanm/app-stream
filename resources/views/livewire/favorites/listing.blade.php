<div>
    <div class="row">
        @foreach ($favorites as $favorite)
            <div class="col-4 col-md-3 col-lg-2 mb-2">
                <x-ownerInfoCard :primaryImage="$favorite->isLive
                    ? 'https://img.doppiocdn.net/thumbs/' .
                        $favorite->data->user->user->snapshotTimestamp .
                        '/' .
                        $favorite->id
                    : null" :secondaryImage="$favorite->pic_profile" :isMobile="$favorite->data->user->user->isMobile" :username="$favorite->username"
                    :idOwner="$favorite->id" :settings="[
                        'autoplay' => false,
                        'allowTouchMove' => true,
                        'simulateTouch' => true,
                    ]" :status="$favorite->general_condition" :isLive="$favorite->isLive" :lastLive="!$favorite->isLive
                        ? \Carbon\Carbon::parse($favorite->statusChangedAt)->diffForHumans(['short' => true])
                        : null"
                    :lastGoal="$favorite->latestGoal?->getPercentage()" :lastGoalDescription="$favorite->latestGoal?->description" />
            </div>
        @endforeach
    </div>
</div>
