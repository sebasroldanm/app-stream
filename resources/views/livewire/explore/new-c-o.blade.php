<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Explorar</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                @if ($data !== false)
                    @foreach ($data->models as $owner)
                        <div class="col-3 col-sm-2">
                            <a href="{{ route('view.owner', $owner->username) }}" class="card mb-3">
                                <div class="image-container container-overlay">
                                    @if (isset($owner->avatarUrl))
                                        <img src="{{ $owner->avatarUrl }}" class="card-img-top primary-image"
                                            alt="#">
                                    @endif
                                    <img src="https://img.strpst.com/thumbs/{{ $owner->popularSnapshotTimestamp }}/{{ $owner->id }}_webp";
                                        class="card-img-top secondary-image _overlay" alt="#">
                                </div>
                                <div class="card-body p-1">
                                    <p class="m-0">{{ $owner->username }}</p>
                                </div>
                                @if ($owner->isNew)
                                    <div class="s_icon top right">
                                        <span class="badge badge-pill bg-warning">New</span>
                                    </div>
                                @endif
                                <div class="s_icon top left">
                                    <span class="badge badge-pill bg-dark">
                                        @if ($owner->isMobile)
                                            <i class="las la-mobile-alt"></i>
                                        @else
                                            <i class="las la-laptop"></i>
                                        @endif
                                    </span>
                                </div>
                                <div class="s_icon bottom right">
                                    <span class="badge badge-pill bg-dark">
                                        {{ $owner->viewersCount }} <i class="las la-eye"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    <div class="col-12">
                        @if ($offset !== 0)
                            <button type="button" wire:click="prevPage"
                                class="btn btn-soft-primary mb-1">Anterior</button>
                        @endif
                        <button type="button" wire:click="nextPage"
                            class="btn btn-soft-primary mb-1">Siguiente</button>
                        Saltados: {{ $offset }} del limite {{ $limit }} y {{ count($data->models) }} en
                        total.
                    @else
                        <h4 class="text-center">No hay resultados</h4>
                @endif
            </div>
        </div>
    </div>
</div>
