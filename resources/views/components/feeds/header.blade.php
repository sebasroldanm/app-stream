<div class="user-post-data pb-3">
    <div class="d-flex justify-content-between">
        @php
            $classIcon = '';
            if ($feed->owner->isOnline) {
                $classIcon = 'iq-profile-avatar status-live';
            }
        @endphp
        <div class="me-3 {{ $classIcon }}">
            <a href="{{ route('owner', $feed->owner->username) }}">
                <img class="rounded-circle avatar-60" src="{{ $feed->owner->avatar }}"
                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ $feed->owner->username }}';"
                    alt="">
            </a>
        </div>
        <div class="w-100">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="">
                    <h5 class="mb-0 d-inline-block"><a href="{{ route('owner', $feed->owner->username) }}"
                            class="">{{ $feed->owner->username }}</a></h5>
                    <p class="ms-1 mb-0 d-inline-block">
                        @switch($feed->type)
                            @case('postAdded')
                                Nueva publicación
                            @break

                            @case('albumUpdated')
                                Album actualizado
                            @break

                            @case('videoAdded')
                                Nuevo video
                            @break

                            @default
                                Nuevo estado
                        @endswitch
                    </p>
                    <p class="mb-0" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="{{ \Carbon\Carbon::parse($feed->updatedAt)->format('d/m/Y H:i') }}"
                        title="{{ \Carbon\Carbon::parse($feed->updatedAt)->format('d/m/Y H:i') }}">
                        {{ \Carbon\Carbon::parse($feed->updatedAt)->diffForHumans() }}
                    </p>
                </div>
                <div class="card-post-toolbar">
                    <div class="dropdown">
                        <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" role="button">
                            <i class="ri-more-fill"></i>
                        </span>
                        <div class="dropdown-menu m-0 p-0">
                            <a class="dropdown-item p-3"
                                href="{{ route('metadata', ['model' => 'feed', 'id' => $feed->id]) }}" target="_blank">
                                <div class="d-flex align-items-top">
                                    <i class="fas fa-link h4"></i>
                                    <div class="data ms-2">
                                        <h6>Ver Meta datos</h6>
                                        <p class="mb-0">Ver metadatos en
                                            formato Json.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
