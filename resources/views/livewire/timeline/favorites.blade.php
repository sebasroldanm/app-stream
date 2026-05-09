<div>
    <ul class="media-story list-inline m-0 p-0">
        @foreach ($favorites as $fav)
            <li class="d-flex mb-4 align-items-center">
                <img src="{{ $fav->avatar }}" alt="story-img" class="rounded-circle img-fluid">
                <div class="stories-data ms-3">
                    <h5><a href="/owner/{{ $fav->username }}">{{ $fav->username }}</a>
                    </h5>
                    <p class="mb-0">
                        {{ __('timeline.followers', ['count' => number_format($fav->favoritedCount, 0, ',', '.')]) }}
                    </p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
