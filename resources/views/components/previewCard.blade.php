@php
    $owner->data = json_decode($owner->data);
@endphp
<div class="card mb-0 card_owner_home">
    <div class="top-bg-image top-bg-list-owner container-overlay">
        @if ($owner->data)
            <img src="{{ $owner->data->user->user->previewUrlThumbSmall }}" loading="lazy" class="img-fluid w-100 _overlay"
                alt="group-bg">
        @else
            <img src="https://placehold.co/320x110?text=No+Imagen" class="img-fluid w-100 _overlay" loading="lazy"
                alt="group-bg">
        @endif
    </div>
    <div class="card-body text-center">
        <div class="group-icon">
            @if ($owner->pic_profile)
                <img src="{{ $owner->pic_profile }}" alt="profile-img" loading="lazy"
                    class="rounded-circle img-fluid avatar-120">
            @else
                @if ($owner->avatar)
                    <img src="{{ $owner->avatar }}" alt="profile-img" loading="lazy"
                        class="rounded-circle img-fluid avatar-120">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ $owner->username }}" alt="profile-img" loading="lazy"
                        class="rounded-circle img-fluid avatar-120">
                @endif
            @endif
        </div>
        <div class="group-info pt-3 pb-3">
            <h4>
                <a href="{{ $owner->username ? route('owner.feed', $owner->username) : dd($owner) }}" wire:navigate>
                    {{ $owner->username }}
                    @if ($owner->isLive)
                        <div class="live-icon"></div>
                    @else
                        @if ($owner->isOnline)
                            <i class="ri-checkbox-blank-circle-fill online m-1"></i>
                        @endif
                    @endif
                </a>
            </h4>
            @if ($owner->name)
                <p>
                    @if ($favoriteHeart && in_array($owner->id, $favs))
                        <span class="badge bg-danger"><i class="las la-heart"></i></span>
                        {{ $owner->name }}
                    @else
                        {{ $owner->name }}
                    @endif
                </p>
            @else
                @if ($favoriteHeart && in_array($owner->id, $favs))
                    <p>
                        <span class="badge bg-danger"><i class="las la-heart"></i></span>
                    </p>
                @endif
            @endif
        </div>
        <div class="group-details d-inline-block pb-3">
            <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0">
                <li class="pe-3 ps-3">
                    <p class="mb-0">Fotos</p>
                    @if ($owner->data)
                        <h6>{{ $owner->data->user->photosCount }}</h6>
                    @else
                        <h6>-</h6>
                    @endif
                </li>
                <li class="pe-3 ps-3">
                    <p class="mb-0">Videos</p>
                    @if ($owner->data)
                        <h6>{{ $owner->data->user->videosCount }}</h6>
                    @else
                        <h6>-</h6>
                    @endif
                </li>
                <li class="pe-3 ps-3">
                    <p class="mb-0">Ranking</p>
                    @if ($owner->data)
                        @if (isset($owner->data->user->modelTopPosition->position) && $owner->data->user->modelTopPosition->position !== 0)
                            <h6>{{ $owner->data->user->modelTopPosition->position }}</h6>
                        @else
                            <h6>-</h6>
                        @endif
                    @else
                        <h6>-</h6>
                    @endif
                </li>
            </ul>
        </div>
        @if ($snapshots && $owner->latestSnapshots->count() > 0)
            <div class="group-member mb-3">
                <div class="iq-media-group">
                    @foreach ($owner->latestSnapshots as $snapshot)
                        <a href="{{ route('owner.feed', $owner->username) }}" class="iq-media">
                            <img class="img-fluid avatar-40 rounded-circle"
                                src="{{ URL::to('/') . $snapshot->local_url }}"
                                onerror="this.onerror=null; this.src='https://placehold.co/50x50.jpg?text=:(';"
                                alt="">
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        @if ($owner->isError)
            <button class="btn btn-danger d-block w-100"><i class="las la-exclamation-triangle"></i>
                No encontrado</button>
        @else
            <a href="{{ route('owner.feed', $owner->username) }}" type="submit"
                class="btn btn-primary d-block w-100">Ver perfil</a>
        @endif
    </div>
</div>
