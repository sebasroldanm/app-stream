<div class="card-body p-0">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ __('owner/feed/panels.title') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="event-post position-relative">
                                <div class="card-body">
                                    @if (isset($owner->data))

                                        @if ($description !== false)
                                            <p>{{ $description }}</p>
                                            <hr>
                                        @endif
                                        @if ($country !== false)
                                            <p><i class="las la-home"></i> {{ __('owner/feed/panels.country') }} {!! $country !!}
                                            </p>
                                        @endif
                                        @if ($languages !== false)
                                            <p><i class="las la-globe"></i> {{ __('owner/feed/panels.languages') }} {!! $languages !!}</p>
                                        @endif
                                        @if ($gender !== false)
                                            <p><i class="las la-users"></i> {{ __('owner/feed/panels.gender') }} {!! $gender !!}</p>
                                        @endif
                                        @if ($age !== false)
                                            <p><i class="las la-gifts"></i> {{ __('owner/feed/panels.age', ['age' => $age]) }}</p>
                                        @endif
                                    @else
                                        <h5 class="text-center">{{ __('owner/feed/panels.no_results') }}</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @livewire('owner.feed.photos', ['owner' => $owner])
            @livewire('owner.feed.videos', ['owner' => $owner])
        </div>
        @livewire('owner.feed.posts', ['owner' => $owner])
    </div>
</div>
