<div>
    @if (isset($this->owner->data) && $this->owner->data !== 'null')

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

            @if ($owner->data->user->user->name)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.name') }}</h6>
                </div>
                <div class="col-9">{{ $owner->data->user->user->name }}</div>
            @endif

            @if ($owner->data->user->user->gender)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.gender') }}</h6>
                </div>
                <div class="col-9">{{ __('owner/information/details.gender_' . $owner->data->user->user->gender) }}</div>
            @endif

            @if ($country)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.country') }}</h6>
                </div>
                <div class="col-9">{!! $country !!}</div>
            @endif

            @if ($languages)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.language') }}</h6>
                </div>
                <div class="col-9">{!! $languages !!}</div>
            @endif

            <div class="col-3">
                <h6>{{ __('owner/information/details.birth_date') }}</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->birthDate }}</div>

            <div class="col-3">
                <h6>{{ __('owner/information/details.age') }}</h6>
            </div>
            <div class="col-9">{{ $age }}</div>

            <div class="col-3">
                <h6>{{ __('owner/information/details.body_type') }}</h6>
            </div>
            <div class="col-9">{{ __('owner/information/details.body_type_' . $owner->data->user->user->bodyType) }}</div>

            <div class="col-3">
                <h6>{{ __('owner/information/details.eye_color') }}</h6>
            </div>
            <div class="col-9">{{ __('owner/information/details.eye_color_' . $owner->data->user->user->eyeColor) }}</div>

            <div class="col-3">
                <h6>{{ __('owner/information/details.hair_color') }}</h6>
            </div>
            <div class="col-9">{{ __('owner/information/details.hair_color_' . $owner->data->user->user->hairColor) }}</div>

            <div class="col-3">
                <h6>{{ __('owner/information/details.ethnicity') }}</h6>
            </div>
            <div class="col-9">{{ __('owner/information/details.ethnicity_' . $owner->data->user->user->ethnicity) }}</div>
        </div>
        {{-- Personal --}}

        {{-- Perfil --}}
        <h4 class="mt-4">
            {{ __('owner/information/details.profile') }}
        </h4>
        <hr>
        <div class="row">
            @if ($owner->notFound)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.profile_status') }}</h6>
                </div>
                <div class="col-9">
                    <span>{{ __('owner/information/details.profile_not_found') }}</span>
                </div>
            @endif
            @if (isset($owner->data->user->modelTopPosition) && $owner->data->user->modelTopPosition->position !== 0)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.profile_top_position') }}</h6>
                </div>
                <div class="col-9">
                    <span>
                        {!! __('owner/information/details.ranking_info', [
                            'position'  => number_format($owner->data->user->modelTopPosition->position, 0, ',', '.'),
                            'icon'      => $owner->getGenderIcon(),
                            'points'    => number_format($owner->data->user->modelTopPosition->points, 0, ',', '.'),
                            'continent' => __('owner/information/details.region_' . $owner->getContinent()),
                        ]) !!}
                    </span>
                </div>
            @endif

            @if ($offlineHuman != '01/01/1970')
                <div class="col-3">
                    <h6>{{ __('owner/information/details.last_offline') }}</h6>
                </div>
                <div class="col-9">{{ $offlineHuman }} - {{ $lastOffline }}</div>
            @endif

            <div class="col-3">
                <h6>{{ __('owner/information/details.last_active') }}</h6>
            </div>
            <div class="col-9">{{ $activeHuman }} - {{ $lastActive }}</div>

            <div class="col-3">
                <h6>{{ __('owner/information/details.idle') }}</h6>
            </div>
            <div class="col-9">
                {{ $idleCalendar }} - {{ $idleDiff }}
            </div>

            @if ($ratingPrivate)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.rating_private') }}</h6>
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
                    <h6>{{ __('owner/information/details.last_snapshot') }}</h6>
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
                {{ __('owner/information/details.interests') }}
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
                {{ __('owner/information/details.activities') }}
            </h4>
            <hr>
            <div class="row">
                <div class="col-3">
                    <h6>{{ __('owner/information/details.public_activities') }}</h6>
                </div>
                <div class="col-9">
                    @foreach ($owner->data->user->user->publicActivities as $activity)
                        <span class="badge badge-pill border border-success text-success mt-2">{{ $activity }}</span>
                    @endforeach
                </div>
                <div class="col-3">
                    <h6>{{ __('owner/information/details.private_activities') }}</h6>
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
            {{ __('owner/information/details.media') }}
        </h4>
        <hr>
        <div class="row">
            @if ($owner->data->user->user->previewUrlThumbSmall)
                <div class="col-3">
                    <h6>{{ __('owner/information/details.preview') }}</h6>
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
                    <h6>{{ __('owner/information/details.avatar') }}</h6>
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
