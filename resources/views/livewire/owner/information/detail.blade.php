<div>
    @if ($owner->present()->hasValidData())

        {{-- Personal --}}
        <h4 class="d-flex justify-content-between">
            {{ __('owner/information/details.personal') }}
            <a href="{{ route('metadata', ['model' => 'owner', 'id' => $owner->id]) }}" target="_blank">
                <i class="fas fa-link"></i>
            </a>
        </h4>
        <hr>
        <div class="row">
            <div class="col-3">
                <h6>{{ __('owner/information/details.id') }}</h6>
            </div>
            <div class="col-9"><code>{{ $owner->id }}</code></div>

            @if ($owner->present()->rawName())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.name') }}</h6>
                </div>
                <div class="col-9">{{ $owner->present()->rawName() }}</div>
            @endif

            @if ($owner->present()->rawGender())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.gender') }}</h6>
                </div>
                <div class="col-9">{{ $owner->present()->gender() }}</div>
            @endif

            @if ($owner->present()->rawCountry())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.country') }}</h6>
                </div>
                <div class="col-9">{!! $owner->present()->flagCountry() !!}</div>
            @endif

            @if ($owner->present()->rawLanguages())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.language') }}</h6>
                </div>
                <div class="col-9">{!! $owner->present()->flagLanguages() !!}</div>
            @endif

            <div class="col-3">
                <h6>{{ __('owner/information/details.birth_date') }}</h6>
            </div>
            <div class="col-9">{{ $owner->present()->rawBirthDate() }}</div>

            <div class="col-3">
                <h6>{{ __('owner/information/details.age') }}</h6>
            </div>
            <div class="col-9">{{ $owner->present()->rawAge() }}</div>

            @if ($owner->present()->rawBodyType())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.body_type') }}</h6>
                </div>
                <div class="col-9">{{ $owner->present()->bodyType() }}
                </div>
            @endif

            @if ($owner->present()->rawEyeColor())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.eye_color') }}</h6>
                </div>
                <div class="col-9">{{ $owner->present()->eyeColor() }}</div>
            @endif

            @if ($owner->present()->rawHairColor())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.hair_color') }}</h6>
                </div>
                <div class="col-9">{{ $owner->present()->hairColor() }}</div>
            @endif

            @if ($owner->present()->rawEthnicity())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.ethnicity') }}</h6>
                </div>
                <div class="col-9">{{ $owner->present()->ethnicity() }}</div>
            @endif
        </div>
        {{-- Personal --}}

        {{-- Perfil --}}
        <h4 class="mt-4">
            {{ __('owner/information/details.profile') }}
        </h4>
        <hr>
        <div class="row">
            @if ($owner->present()->isNotFound())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.profile_status') }}</h6>
                </div>
                <div class="col-9">
                    <span>{{ __('owner/information/details.profile_not_found') }}</span>
                </div>
            @endif
            @if ($owner->present()->topPosition())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.profile_top_position') }}</h6>
                </div>
                <div class="col-9">
                    <span>{!! $owner->present()->translatedRanking() !!}</span>
                </div>
            @endif

            @if ($owner->present()->isOfflinePost())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.last_offline') }}</h6>
                </div>
                <div class="col-9">{{ $owner->present()->offlinePost()->date() }} - {{ $owner->present()->offlinePost()->human()->parts(2) }}</div>
            @endif

            <div class="col-3">
                <h6>{{ __('owner/information/details.last_active') }}</h6>
            </div>
            <div class="col-9">{{ $owner->present()->statusChangedDate()->date() }} - {{ $owner->present()->statusChangedDate()->human()->parts(2) }}</div>

            <div class="col-3">
                <h6>{{ __('owner/information/details.idle') }}</h6>
            </div>
            <div class="col-9">
                {{ $owner->present()->idleDate()->calendar() }} - {{ $owner->present()->idleDate()->human()->parts(2) }}
            </div>

            @if ($ratingPrivate)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.rating_private') }}</h6>
                </div>
                <div class="col-9">
                    <div class="rating">
                        <div class="stars-back">★★★★★</div>
                        <div class="stars-front"
                            style="width: {{ ($ratingPrivate / 5) * 100 }}%">
                            ★★★★★
                        </div>
                    </div>
                    <span>{{ number_format($ratingPrivate, 1, ',', '.') }} / 5</span>
                </div>
            @endif

            @if (!$owner->isDelete)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.last_snapshot') }}</h6>
                </div>
                <div class="col-9">
                    {{ $snapshotCalendar }} - {{ $snapshotDiff }}
                </div>
            @endif
        </div>
        {{-- Perfil --}}

        {{-- Intereses --}}
        @if ($owner->getInterests())
            <h4 class="mt-4">
                {{ __('owner/information/details.interests') }}
            </h4>
            <hr>
            <div class="row">
                <div class="col-12">
                    @foreach ($owner->getInterests() as $interest)
                        <span
                            class="badge badge-pill border border-secondary text-secondary mt-2">{{ $interest }}</span>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- Intereses --}}

        {{-- Actividades --}}
        @if ($owner->getPublicActivities() && $owner->getPrivateActivities())
            <h4 class="mt-4">
                {{ __('owner/information/details.activities') }}
            </h4>
            <hr>
            <div class="row">
                <div class="col-3">
                    <h6>{{ __('owner/information/details.public_activities') }}</h6>
                </div>
                <div class="col-9">
                    @foreach ($owner->getPublicActivities() as $activity)
                        <span class="badge badge-pill border border-success text-success mt-2">{{ $activity }}</span>
                    @endforeach
                </div>
                <div class="col-3">
                    <h6>{{ __('owner/information/details.private_activities') }}</h6>
                </div>
                <div class="col-9">
                    @foreach ($owner->getPrivateActivities() as $activity)
                        <span class="badge badge-pill border border-info text-info mt-2">{{ $activity }}</span>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- Actividades --}}

        {{-- Media --}}
        <h4 class="mt-4">
            {{ __('owner/information/details.media') }}
        </h4>
        <hr>
        <div class="row">
            @if ($owner->getPreviewUrlThumbSmall())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.preview') }}</h6>
                </div>
                <div class="col-9">
                    <img src="{{ $owner->getPreviewUrlThumbSmall() }}" data-image_vh="{{ $owner->getPreviewUrlThumbBig() }}"
                    alt="gallary-image" class="img-fluid fullviewer rounded" />
                </div>
            @endif
            @if ($owner->getAvatarUrl() && $owner->getPreviewUrlThumbSmall())
                <div class="col-12 mt-3">
                </div>
            @endif
            @if ($owner->getAvatarUrl())
                <div class="col-3">
                    <h6>{{ __('owner/information/details.avatar') }}</h6>
                </div>
                <div class="col-9">
                    <img src="{{ $owner->getAvatarUrlThumb() }}" data-image_vh="{{ $owner->getAvatarUrl() }}"
                        alt="gallary-image" class="img-fluid fullviewer rounded" />
                </div>
            @endif
        </div>      
        {{-- Media --}}
    @else
        <div class="row">
            <div class="col-sm-12">
                <h4 class="mb-3">{{ __('owner/information/details.details') }}</h4>
                <h5 class="text-center">{{ __('owner/information/details.no_information') }}</h5>
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
