<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Favorites</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-grid gap-3 d-grid-template-1fr-19">
                        @foreach ($favorites as $favorite)
                            <x-previewCard :owner="$favorite" :favs="$favs" :favorite-heart="false" :snapshots="false"/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>