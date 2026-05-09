<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Explorar Mobile CO</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                @if ($data !== false)
                    @foreach ($owners as $owner)
                        <div class="col-3 col-sm-2 my-1">
                            <x-ownerInfoCard 
                                :isFav="in_array($owner->id, $favs)" 
                                :primaryImage="'https://img.doppiocdn.net/thumbs/' . $owner->verifiedSnapshotTimestamp . '/' . $owner->id"
                                :secondaryImage="$owner->previewUrlThumbSmall"
                                :ternaryImage="'https://img.doppiocdn.net/thumbs/' . $owner->popularSnapshotTimestamp . '/' . $owner->id"
                                :isNew="$owner->isNew"
                                :isMobile="$owner->isMobile"
                                :viewersCount="$owner->viewersCount"
                                :username="$owner->username"
                                :isGames="$owner->isLovense"
                                :gender="$owner->gender"
                                :idOwner="$owner->id"
                                :country="$this->flagCountry($owner->country)"
                                :settings="[
                                    'autoplay' => false,
                                    'allowTouchMove' => true,
                                    'simulateTouch' => true,
                                ]"
                            />
                        </div>
                    @endforeach
                    <div class="col-12">
                        @if (!$endResults)
                            <div x-intersect="$wire.nextPage()" class="d-flex justify-content-center py-3">
                                <div wire:loading wire:target="nextPage" class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <div wire:loading.remove wire:target="nextPage" class="spinner-border text-secondary opacity-25" role="status">
                                    <span class="visually-hidden">Cargando más...</span>
                                </div>
                            </div>
                        @endif
                        Saltados: {{ $offset }} del limite {{ $limit }} y {{ count($data->models) }} en
                        total.
                    @else
                        <h4 class="text-center">No hay resultados</h4>
                @endif
            </div>
        </div>
    </div>
</div>
