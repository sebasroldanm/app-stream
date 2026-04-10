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

    <div x-intersect="$wire.loadMore()" class="col-sm-12 text-center p-4">
        <div wire:loading wire:target="loadMore">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

</div>
