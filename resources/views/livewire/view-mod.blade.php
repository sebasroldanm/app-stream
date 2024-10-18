<div>
    @php
        $data_mod->data = json_decode($data_mod->data, true);
    @endphp
    <div class="cover-photo"></div>
    <div class="text-center profile-header">
        <img src="{{ $data_mod->avatar ? $data_mod->avatar : 'https://placehold.co/150x150?text=Profile+Pic' }}"
            alt="Profile Photo" class="profile-photo">
        <h3 class="mt-3">{{ $data_mod->username }}</h3>
        <p>{{ $data_mod->name }}</p>
        <div class="d-flex justify-content-center mt-2">
            @if ($data_mod->isError)
                <div class="alert alert-danger" role="alert">
                    Cambio de username
                </div>
            @else
            <button wire:click="updateDataMod" class="btn btn-primary me-2">Actualizar data</button>
            @endif
            @if (auth()->guard('customer')->check())
                <button wire:click="toggleFavorite"
                    class="btn btn-secondary">{{ $is_fav ? 'ELiminar Favorito' : 'Agregar Favorito' }}</button>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="row mt-4">
            <!-- Left Sidebar -->
            <div class="col-md-4">
                <!-- Profile Information -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Profile Information</h5>
                        <div class="d-flex flex-column align-items-center">
                            <!-- Profile Picture -->
                            <img src="{{ $data_mod->preview ? $data_mod->preview : 'https://placehold.co/150x150?text=Profile+Pic' }}"
                                alt="Profile Picture" class="rounded-circle mb-3" style="width: 100px; height: 100px;">

                            <!-- Name -->
                            <h6 class="mb-0">{{ $data_mod->data['user']['user']['name'] }}</h6>

                            <!-- Status -->
                            <p class="text-muted mb-2">
                                {{ \Carbon\Carbon::parse($data_mod->data['user']['user']['statusChangedAt'])->subHours(5)->format('d M, Y - H:i:s') }}
                            </p>

                            <!-- Location -->
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt-fill"></i> {{ $data_mod->data['user']['user']['country'] }}
                            </p>

                            <!-- Email -->
                            <p class="text-muted mb-2">
                                <i class="bi bi-envelope-fill"></i> {{ $data_mod->data['user']['user']['age'] }}
                            </p>

                            <!-- Inactive -->
                            <p class="text-muted mb-0">
                                <i class="bi bi-calendar-fill"></i>
                                {{ \Carbon\Carbon::parse($data_mod->data['user']['user']['wentIdleAt'])->subHours(5)->format('d M, Y - H:i:s') }}
                            </p>

                            <div class="alert {{ $status_owner ? 'alert-success' : 'alert-danger' }}" role="alert">
                                Estado Owner
                            </div>
                            <div class="alert {{ $status_panel ? 'alert-success' : 'alert-danger' }}" role="alert">
                                Estado Panel
                            </div>
                            <div class="alert {{ $status_photos ? 'alert-success' : 'alert-danger' }}" role="alert">
                                Estado Albums
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="col-md-8">
                <!-- Panels -->
                {{-- <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            @if (count($panels) > 0)
                                @foreach ($panels as $panel)
                                    <div class="col-6">
                                        <div class="card m-1 p-1">
                                            @if ($panel->title !== '')
                                                <h5>{{ $panel->title }}</h5>
                                            @endif
                                            @if ($panel->imageUrl !== '')
                                                <img src="{{ $panel->imageUrl }}" alt="{{ $panel->title }}"
                                                    class="img-fluid rounded me-2 mb-2">
                                            @endif
                                            @if ($panel->body !== '')
                                                <p>{{ $panel->body }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No panels</h5>
                            @endif
                        </div>
                    </div>
                </div> --}}
                <!-- Videos -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            @if (count($videos) > 0)
                                @foreach ($videos as $vid)
                                    <img src="{{ $vid->coverUrl }}" alt="{{ $vid->title }}"
                                        class="img-fluid rounded me-2 mb-2" style="width: 75px;">
                                @endforeach
                            @else
                                <h5>No videos</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Albums -->
                <div class="card mb-4">
                    <div class="card-body">
                        {{-- <div class="d-flex flex-wrap"> --}}
                        @if (count($albums) > 0)
                            @foreach ($albums as $album)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ $album->name }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="album-mosaic row row-cols-6 g-2">
                                            @foreach ($album->photos as $photo)
                                                {{-- {{ dd($photo->url) }} --}}
                                                {{-- @foreach ($album['photos'] as $photo) --}}
                                                @php
                                                    if (!empty($photo->urlThumb)) {
                                                        $src = $photo->urlThumb;
                                                    } elseif (!empty($photo->urlPreview)) {
                                                        $src = $photo->urlPreview;
                                                    } else {
                                                        $src = $photo->urlThumbMicro;
                                                    }
                                                @endphp
                                                @if ($src)
                                                    <div class="col">
                                                        @if (!empty($photo->urlThumb))
                                                            <img class="avatar" src="{{ $photo->urlThumb }}"
                                                                alt="{{ $album->name }}"
                                                                class="img-fluid rounded me-2 mb-2"
                                                                style="width: 75px;">
                                                        @else
                                                            <img class="img-fluid rounded" src="{{ $photo->urlThumbMicro }}"
                                                                alt="{{ $album->name }}"
                                                                class="img-fluid rounded me-2 mb-2" style="width: 50px;">
                                                        @endif
                                                    </div>
                                                @endif
                                                {{-- @endforeach --}}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h5>No albums</h5>
                        @endif
                        {{-- </div> --}}
                    </div>
                </div>
            </div>

        </div>

        @push('styles')
            <style>
                .cover-photo {
                    height: 300px;
                    background-color: #f0f0f0;
                    background-image: url({{ $intro }});
                    background-size: cover;
                    background-position: center;
                }

                .profile-photo {
                    width: 150px;
                    height: 150px;
                    border-radius: 50%;
                    margin-top: -75px;
                    border: 5px solid white;
                }

                .profile-header {
                    margin-top: 100px;
                }

                .nav-pills .nav-link.active {
                    background-color: #1877f2;
                }

                .avatar {
                    transition: filter 0.3s ease;
                    filter: blur(3px);
                }

                img:hover {
                    filter: blur(0px);
                }
            </style>
        @endpush
