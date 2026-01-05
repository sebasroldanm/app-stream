<div>
    @if (isset($this->owner->data) && $this->owner->data !== 'null')

        {{-- Personal --}}
        <h4 class="d-flex justify-content-between">
            Personal
            <a href="{{ route('metadata', ['model' => 'owner', 'id' => $owner->id]) }}" target="_blank">
                <i class="fas fa-link"></i>
            </a>
        </h4>
        <hr>
        <div class="row">
            <div class="col-3">
                <h6>ID</h6>
            </div>
            <div class="col-9"><code>{{ $owner->id }}</code></div>

            @if ($owner->data->user->user->name)
                <div class="col-3">
                    <h6>Nombre</h6>
                </div>
                <div class="col-9">{{ $owner->data->user->user->name }}</div>
            @endif

            @if ($owner->data->user->user->gender)
                <div class="col-3">
                    <h6>Género</h6>
                </div>
                <div class="col-9">{{ $owner->data->user->user->gender }}</div>
            @endif

            @if ($owner->data->user->user->country)
                <div class="col-3">
                    <h6>País</h6>
                </div>
                <div class="col-9">{{ $owner->data->user->user->country }}</div>
            @endif

            <div class="col-3">
                <h6>Fecha de nacimiento</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->birthDate }}</div>

            <div class="col-3">
                <h6>Edad</h6>
            </div>
            <div class="col-9">{{ $age }}</div>

            <div class="col-3">
                <h6>Conplexión</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->bodyType }}</div>

            <div class="col-3">
                <h6>Color de ojos</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->eyeColor }}</div>

            <div class="col-3">
                <h6>Color de cabello</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->hairColor }}</div>

            <div class="col-3">
                <h6>Etnia</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->ethnicity }}</div>
        </div>
        {{-- Personal --}}

        {{-- Perfil --}}
        <h4 class="mt-4">
            Perfil
        </h4>
        <hr>
        <div class="row">
            @if ($owner->notFound)
                <div class="col-3">
                    <h6>Estado de Perfil</h6>
                </div>
                <div class="col-9">
                    <span>No encontrado en el Servidor principal, buscar en similitudes</span>
                </div>
            @endif
            @if (isset($owner->data->user->modelTopPosition) && $owner->data->user->modelTopPosition->position !== 0)
                <div class="col-3">
                    <h6>Posición actual</h6>
                </div>
                <div class="col-9">
                    <span>{{ number_format($owner->data->user->modelTopPosition->position, 0, ',', '.') }} en el genero {!! $owner->getGenderIcon() !!}
                        con {{ number_format($owner->data->user->modelTopPosition->points, 0, ',', '.') }} puntos en {{ $owner->getContinent() }}
                    </span>
                </div>
            @endif

            @if ($offlineHuman != '01/01/1970')
                <div class="col-3">
                    <h6>Último estado</h6>
                </div>
                <div class="col-9">{{ $offlineHuman }} - {{ $lastOffline }}</div>
            @endif

            <div class="col-3">
                <h6>Última conexión</h6>
            </div>
            <div class="col-9">{{ $activeHuman }} - {{ $lastActive }}</div>

            <div class="col-3">
                <h6>Inactivo</h6>
            </div>
            <div class="col-9">
                {{ $idleCalendar }} - {{ $idleDiff }}
            </div>

            @if ($ratingPrivate)
                <div class="col-3">
                    <h6>Evaluation Private</h6>
                </div>
                <div class="col-9">
                    <div class="rating">
                        <div class="stars-back">★★★★★</div>
                        <div class="stars-front"
                            style="width: {{ ($owner->data->user->user->ratingPrivate / 5) * 100 }}%">
                            ★★★★★
                        </div>
                    </div>
                    <span>{{ number_format($owner->data->user->user->ratingPrivate, 1, ',', '.') }} / 5</span>
                </div>
            @endif

            @if (!$owner->isDelete)
                <div class="col-3">
                    <h6>Último snapshot</h6>
                </div>
                <div class="col-9">
                    {{ $snapshotCalendar }} - {{ $snapshotDiff }}
                </div>
            @endif
        </div>
        {{-- Perfil --}}

        {{-- Intereses --}}
        @if ($owner->data->user->user->interests)
            <h4 class="mt-4">
                Intereses
            </h4>
            <hr>
            <div class="row">
                <div class="col-12">
                    @foreach ($owner->data->user->user->interests as $interest)
                        <span
                            class="badge badge-pill border border-secondary text-secondary mt-2">{{ $interest }}</span>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- Intereses --}}

        {{-- Actividades --}}
        @if ($owner->data->user->user->publicActivities && $owner->data->user->user->privateActivities)
            <h4 class="mt-4">
                Actividades
            </h4>
            <hr>
            <div class="row">
                <div class="col-3">
                    <h6>Público</h6>
                </div>
                <div class="col-9">
                    @foreach ($owner->data->user->user->publicActivities as $activity)
                        <span class="badge badge-pill border border-success text-success mt-2">{{ $activity }}</span>
                    @endforeach
                </div>
                <div class="col-3">
                    <h6>Privado</h6>
                </div>
                <div class="col-9">
                    @foreach ($owner->data->user->user->privateActivities as $activity)
                        <span class="badge badge-pill border border-info text-info mt-2">{{ $activity }}</span>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- Actividades --}}

        {{-- Media --}}
        <h4 class="mt-4">
            Media
        </h4>
        <hr>
        <div class="row">
            @if ($owner->data->user->user->previewUrlThumbSmall)
                <div class="col-3">
                    <h6>Preview</h6>
                </div>
                <div class="col-9">
                    <img src="{{ $owner->data->user->user->previewUrlThumbSmall }}" data-image_vh="{{ $owner->data->user->user->previewUrlThumbBig }}"
                    alt="gallary-image" class="img-fluid fullviewer rounded" />
                </div>
            @endif
            @if ($owner->data->user->user->avatarUrl && $owner->data->user->user->previewUrlThumbSmall)
                <div class="col-12 mt-3">
                </div>
            @endif
            @if ($owner->data->user->user->avatarUrl)
                <div class="col-3">
                    <h6>Avatar</h6>
                </div>
                <div class="col-9">
                    <img src="{{ $owner->data->user->user->avatarUrlThumb }}" data-image_vh="{{ $owner->data->user->user->avatarUrl }}"
                        alt="gallary-image" class="img-fluid fullviewer rounded" />
                </div>
            @endif
        </div>      
        {{-- Media --}}
    @else
        <div class="row">
            <div class="col-sm-12">
                <h4 class="mb-3">Detalles</h4>
                <h5 class="text-center">Sin información :(</h5>
            </div>
        </div>
    @endif
    <style>
        .rating {
            position: relative;
            display: inline-block;
            font-size: 20px;
            line-height: 1;
        }

        .stars-back {
            color: #ddd;
        }

        .stars-front {
            color: gold;
            position: absolute;
            top: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden;
            pointer-events: none;
        }
    </style>
</div>
