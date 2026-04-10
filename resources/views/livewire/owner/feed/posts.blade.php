<div class="col-lg-8">
    <div class="col-sm-12">
        @livewire('timeline.post-create')
    </div>

    @foreach ($posts as $key => $post)
        <div wire:key="{{ $key }}">
            @include('components.feed', [
                'owner' => $owner,
                'feed' => $post->data,
                'tagLive' => true,
            ])
        </div>
    @endforeach

    @if (!isset($totalItems) || $posts->count() < $totalItems)
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
