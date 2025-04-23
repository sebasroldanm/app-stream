<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Explorar</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">

                <div class="col-md-4 text-center">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="card-title">New CO</h4>
                            <a href="{{ route('explore.new-co') }}" wire:navigate class="btn btn-primary btn-block">Explorar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-center">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="card-title">New Mobile CO</h4>
                            <a href="{{ route('explore.new-mobile-co') }}" wire:navigate class="btn btn-primary btn-block">Explorar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-center">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="card-title">Mobile CO</h4>
                            <a href="{{ route('explore.mobile-co') }}" wire:navigate class="btn btn-primary btn-block">Explorar</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
