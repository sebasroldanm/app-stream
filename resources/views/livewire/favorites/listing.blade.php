<div>
    <div class="row">
        @foreach ($favorites as $favorite)
            {{-- <x-previewCard :owner="$favorite" :favs="$favs" :favorite-heart="false" :snapshots="false"/> --}}
            <div class="col-md-2">
                @php
                    if ($favorite->isActive == false) {
                        $status = 'inactive';
                    } else if ($favorite->isBlocked) {
                        $status = 'blocked';
                    } else {
                        $status = null;
                    }
                @endphp
                <x-ownerInfoCard 
                    :primaryImage="$favorite->isLive ? 'https://img.doppiocdn.net/thumbs/' . $favorite->data->user->user->snapshotTimestamp . '/' . $favorite->id : null"
                    :secondaryImage="$favorite->pic_profile"
                    :isMobile="$favorite->data->user->user->isMobile"
                    :username="$favorite->username"
                    :idOwner="$favorite->id"
                    :settings="[
                        'autoplay' => false,
                        'allowTouchMove' => true,
                        'simulateTouch' => true,
                    ]"
                    :status="$status"
                    :isLive="$favorite->isLive"
                    :lastLive="!$favorite->isLive ? \Carbon\Carbon::parse($favorite->statusChangedAt)->diffForHumans(['short' => true]) : null"
                />
            </div>
        @endforeach
    </div>
</div>
