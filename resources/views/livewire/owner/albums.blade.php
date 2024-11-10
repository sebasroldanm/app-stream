<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h4>Albumes</h4>
            </div>
            @if (count($albums) > 0)
                <div class="col-md-3 list_medias">
                    <ul class="nav nav-pills list-inline p-0 m-0 flex-column">
                        @foreach ($albums as $tab => $album)
                            <li>
                                <a class="nav-link d-flex justify-content-between
                                @if ($tab == 0 && $id_active == false) active @endif
                                @if ($id_active == $album->id) active @endif"
                                    href="#v-pills-album_{{ $album->id }}" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-album_{{ $album->id }}" role="button"
                                    wire:click="refreshMasonry({{$album->id}})">
                                    {{ mb_substr($album->name, 0, 17) . (mb_strlen($album->name) > 17 ? '...' : '') }}
                                    @if ($album->accessMode !== 'free')
                                        <span class="badge bg-danger h-100"><i
                                                class="las la-hand-holding-usd"></i></span>
                                    @else
                                        <span class="badge bg-success h-100"><i
                                                class="las la-hand-holding-heart"></i></span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9 ps-4">
                    <div class="tab-content">
                        @foreach ($albums as $panel => $album)
                            <div class="tab-pane fade min-vh-60 @if ($panel == 0 && $id_active == false) active show @endif
                                @if ($id_active == $album->id) active show @endif"
                                id="v-pills-album_{{ $album->id }}" role="tabpanel"
                                aria-labelledby="v-pills-album_{{ $album->id }}">
                                @livewire('owner.albums.content-album', ['owner' => $owner, 'album' => $album], key($album->id))
                            </div>
                        @endforeach

                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <h5 class="mb-3 text-center">No hay Fotos :(</h5>
                </div>
            @endif
        </div>
    </div>
