<div>
    {{-- <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>{{ __('sidebar.favorites') }}</h2>
                </div>
            </div>
        </div>
    </div> --}}

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="ri-home-4-line mr-1 float-left"></i>{{ __('common.breadcrumb.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('common.breadcrumb.favorite') }}</li>
                        </ol>
                    </nav>
                    @livewire('favorites.listing')
                </div>
            </div>
        </div>
    </div>
</div>