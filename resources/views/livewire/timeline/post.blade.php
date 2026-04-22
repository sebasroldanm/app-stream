<div class="col-lg-8 row m-0 p-0">
    <div class="col-sm-12">
        {{-- @livewire('timeline.post-create') --}}
    </div>

    @foreach ($feeds as $feed)
        <div wire:key="feed-{{ $feed->id }}">
            @include('components.feed', [
                'owner' => $feed->owner,
                'feed' => $feed,
                'tagLive' => true,
            ])
        </div>
    @endforeach

    @if (!isset($totalItems) || $items->count() < $totalItems)
        <div x-intersect="$wire.loadMore()" class="col-sm-12 text-center p-4">
            <div wire:loading wire:target="loadMore">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">{{ __('owner/feed/posts.loading_more_posts') }}</span>
                </div>
            </div>
        </div>
    @else
        <div class="col-sm-12 text-center p-4">
            <p>{{ __('owner/feed/posts.no_more_posts') }}</p>
        </div>
    @endif

</div>
