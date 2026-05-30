<div>
    {{-- <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>{{ __('sidebar.explore') }}</h2>
                </div>
            </div>
        </div>
    </div> --}}

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="ri-home-4-line mr-1 float-left"></i>{{ __('common.breadcrumb.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('common.breadcrumb.explore') }}</li>
                        </ol>
                    </nav>
                    <div class="card">
                        <div class="card-body d-flex align-items-center flex-wrap">
                            <div class="dropdown me-3">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="dropdownCountries" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-auto-close="outside" wire:ignore.self>
                                    <i class="ri-map-pin-line me-1"></i>Países
                                    {{ count($tempCountries) > 0 ? '(' . count($tempCountries) . ')' : '' }}
                                </button>
                                <div class="dropdown-menu p-3" aria-labelledby="dropdownCountries"
                                    style="min-width: 300px; max-height: 400px; overflow-y: auto;" wire:ignore.self>
                                    @foreach ($countryList as $continent => $countries)
                                        <h6 class="mb-2">{{ $continent }}</h6>
                                        <div class="row">
                                            @foreach ($countries as $tag => $label)
                                                <div class="form-check col-12 col-sm-6" wire:key="country-{{ $tag }}">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $tag }}" id="chk_{{ $tag }}"
                                                        wire:model.live="tempCountries">
                                                    <label class="form-check-label text-white"
                                                        for="chk_{{ $tag }}">
                                                        {{ $label }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if (!$loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="dropdown me-3">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="dropdownEthnicities" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-auto-close="outside" wire:ignore.self>
                                    <i class="ri-user-heart-line me-1"></i>Etnia
                                    {{ count($tempEthnicities) > 0 ? '(' . count($tempEthnicities) . ')' : '' }}
                                </button>
                                <div class="dropdown-menu p-3" aria-labelledby="dropdownEthnicities"
                                    style="min-width: 200px;" wire:ignore.self>
                                    @foreach ($ethnicityList as $tag => $label)
                                        <div class="form-check" wire:key="ethnicity-{{ $tag }}">
                                            <input class="form-check-input" type="checkbox" value="{{ $tag }}"
                                                id="chk_eth_{{ $tag }}" wire:model.live="tempEthnicities">
                                            <label class="form-check-label text-white"
                                                for="chk_eth_{{ $tag }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="dropdown me-3">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMore"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside"
                                    wire:ignore.self>
                                    <i class="ri-more-2-line me-1"></i>Más
                                    {{ count($tempOthers) > 0 ? '(' . count($tempOthers) . ')' : '' }}
                                </button>
                                <div class="dropdown-menu p-3" aria-labelledby="dropdownMore" style="min-width: 200px;"
                                    wire:ignore.self>
                                    @foreach ($othersList as $tag => $label)
                                        <div class="form-check" wire:key="other-{{ $tag }}">
                                            <input class="form-check-input" type="checkbox" value="{{ $tag }}"
                                                id="chk_other_{{ $tag }}" wire:model.live="tempOthers">
                                            <label class="form-check-label text-white"
                                                for="chk_other_{{ $tag }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if ($hasChanges)
                                <div class="ms-auto d-flex align-items-center">
                                    <button class="btn btn-primary me-2" wire:click="applyFilters" wire:loading.attr="disabled">
                                        <i class="ri-check-line me-1"></i>Aplicar
                                    </button>
                                    <button class="btn btn-soft-secondary" wire:click="resetFilters" wire:loading.attr="disabled">
                                        <i class="ri-refresh-line me-1"></i>Limpiar
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-4">
                    {{-- Grid real: se oculta mientras se aplican filtros --}}
                    <div wire:loading.remove wire:target="applyFilters, resetFilters">
                        <div class="row">
                            @foreach ($owners as $owner)
                                <div class="col-4 col-md-3 col-lg-2 mb-2">
                                    <x-ownerInfoCard :isFav="in_array($owner->id, $favs)" :primaryImage="'https://img.doppiocdn.net/thumbs/' .
                                        ($owner->verifiedSnapshotTimestamp ?? $owner->snapshotTimestamp) .
                                        '/' .
                                        $owner->id" :secondaryImage="$owner->previewUrlThumbSmall" :ternaryImage="'https://img.doppiocdn.net/thumbs/' .
                                        $owner->popularSnapshotTimestamp .
                                        '/' .
                                        $owner->id"
                                        :isNew="$owner->isNew" :isMobile="$owner->isMobile" :viewersCount="$owner->viewersCount" :username="$owner->username"
                                        :idOwner="$owner->id" :country="$this->flagCountry($owner->country)" :settings="[
                                            'autoplay' => false,
                                            'allowTouchMove' => true,
                                            'simulateTouch' => true,
                                        ]" />
                                </div>
                            @endforeach
                        </div>

                        @if (!$endResults && count($owners) > 0)
                            <div x-intersect="$wire.nextPage()" class="text-center mt-4 mb-5">
                                <div wire:loading wire:target="nextPage">
                                    <div class="spinner-border text-primary" role="status"></div>
                                    <p class="mt-2">Cargando más...</p>
                                </div>
                            </div>
                        @elseif($endResults && count($owners) > 0)
                            <div class="text-center mt-4 mb-5">
                                <p class="">No hay más resultados</p>
                            </div>
                        @elseif(count($owners) === 0)
                            <div class="text-center mt-5 mb-5">
                                <i class="ri-search-line ri-4x  mb-3 d-block"></i>
                                <h4>No se encontraron resultados</h4>
                                <p>Prueba ajustando los filtros.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Grid de Skeleton: se muestra mientras se aplican filtros --}}
                    <div wire:loading.block wire:target="applyFilters, resetFilters" class="w-100">
                        @include('livewire.explore.skeleton-grid')
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
