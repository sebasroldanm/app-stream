<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Explorar New CO</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                @if ($data !== false)
                    @foreach ($owners as $owner)
                        <div class="col-3 col-sm-2">
                            <x-ownerInfoCard 
                                :isFav="in_array($owner->id, $favs)" 
                                :primaryImage="'https://img.doppiocdn.net/thumbs/' . $owner->verifiedSnapshotTimestamp . '/' . $owner->id"
                                :secondaryImage="$owner->previewUrlThumbSmall"
                                :ternaryImage="'https://img.doppiocdn.net/thumbs/' . $owner->popularSnapshotTimestamp . '/' . $owner->id"
                                :isNew="$owner->isNew"
                                :isMobile="$owner->isMobile"
                                :viewersCount="$owner->viewersCount"
                                :username="$owner->username"
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
                            <button type="button" wire:click="nextPage"
                                class="btn btn-soft-primary mb-1">Siguiente</button>
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
