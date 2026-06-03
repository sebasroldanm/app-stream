<div>
    <div class="row">
        {{-- Variable para controlar el cambio de sección --}}
        @php $isCurrentSectionLive = null; @endphp

        @foreach ($favorites as $favorite)
            @if ($isCurrentSectionLive !== (bool)$favorite->isLive)
                @php $isCurrentSectionLive = (bool)$favorite->isLive; @endphp
                
                <div class="col-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ $isCurrentSectionLive ? 'En vivo' : 'Favoritos' }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-4 col-md-3 col-lg-2 mb-2" wire:key="fav-owner-{{ $favorite->id }}">
                <x-ownerInfoCard 
                    :primaryImage="$favorite->isLive ? 'https://img.doppiocdn.net/thumbs/' . $favorite->data->user->user->snapshotTimestamp . '/' . $favorite->id : null" 
                    :secondaryImage="$favorite->pic_profile" 
                    :isMobile="$favorite->data->user->user->isMobile" 
                    :username="$favorite->username"
                    :idOwner="$favorite->id" 
                    :settings="['autoplay' => false, 'allowTouchMove' => true, 'simulateTouch' => true]" 
                    :status="$favorite->general_condition" 
                    :viewersCount="$favorite->stat?->viewers"
                    :isLive="$favorite->isLive" 
                    :lastLive="!$favorite->isLive ? \Carbon\Carbon::parse($favorite->statusChangedAt)->diffForHumans(['short' => true]) : null"
                    :lastGoal="$favorite->latestGoal?->getPercentage()" 
                    :lastGoalDescription="$favorite->latestGoal?->description" 
                />
            </div>
        @endforeach
    </div>
