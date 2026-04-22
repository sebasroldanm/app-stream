<div>
    <div class="d-grid gap-3 d-grid-template-1fr-19">
        @foreach ($favorites as $favorite)
            <x-previewCard :owner="$favorite" :favs="$favs" :favorite-heart="false" :snapshots="false"/>
        @endforeach
    </div>
</div>
