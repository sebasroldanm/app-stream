<div id="content-page" class="content-page">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="ri-home-4-line mr-1 float-left"></i>{{ __('common.breadcrumb.home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('common.breadcrumb.results_search') }}</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-4">{{ __('resultSearch.results_search', ['keyword' => $keyword]) }}</h3>
                        <div class="row">
                        @foreach ($owners['models'] as $owner)
                            <div class="col-4 col-md-3 col-lg-2 mb-2">
                                    <x-ownerInfoCard
                                        :isFav="in_array($owner->id, $favs)" 
                                        :primaryImage="$owner->avatarUrl" 
                                        :secondaryImage="$owner->isLive ? 'https://img.doppiocdn.net/thumbs/' . $owner->popularSnapshotTimestamp . '/' . $owner->id : null"
                                        :ternaryImage="$owner->previewUrlThumbSmall"
                                        :isNew="$owner->isNew" 
                                        :isMobile="$owner->isMobile" 
                                        :viewersCount="$owner->viewersCount" 
                                        :username="$owner->username"
                                        :isGames="$owner->isLovense"
                                        :gender="$owner->gender"
                                        :idOwner="$owner->id" 
                                        :isLive="$owner->isLive"
                                        :country="$this->flagCountry($owner->country)" 
                                        :settings="[
                                            'autoplay' => false,
                                            'allowTouchMove' => true,
                                            'simulateTouch' => true,
                                        ]" 
                                    />
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
