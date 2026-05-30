<div>
    {{-- Header estático para mantener la estructura visual --}}
    {{-- <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Explorer</h2>
                </div>
            </div>
        </div>
    </div> --}}

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="ri-home-4-line me-1 float-left"></i>{{ __('common.breadcrumb.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('common.breadcrumb.explore') }}</li>
                        </ol>
                    </nav>
                    <div class="card">
                        <div class="card-body d-flex align-items-center flex-wrap">
                            {{-- Skeleton de los filtros --}}
                            <div class="skeleton-placeholder me-3 rounded" style="width: 120px; height: 38px;"></div>
                            <div class="skeleton-placeholder me-3 rounded" style="width: 100px; height: 38px;"></div>
                            <div class="skeleton-placeholder me-3 rounded" style="width: 80px; height: 38px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-4">
                    @include('livewire.explore.skeleton-grid')
                </div>
            </div>
        </div>
    </div>
</div>