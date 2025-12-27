@if (
    $feed->type === 'offlineStatusChanged' ||
        (($feed->type !== 'offlineStatusChanged' && $feed->postFeed->count() > 0) ||
            $feed->albumFeed->count() > 0 ||
            $feed->videoFeed->count() > 0))
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="post-item">
                    @include('components.feeds.header', ['feed' => $feed])

                    @if ($feed->type == 'offlineStatusChanged')
                        @include('components.feeds.offline', ['feed' => $feed])
                    @else
                        @include('components.feeds.post', ['posts' => $feed->postFeed])
                        @include('components.feeds.album', [
                            'albums' => $feed->albumFeed,
                            'feed' => $feed,
                        ])
                        @include('components.feeds.video', ['videos' => $feed->videoFeed])
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
