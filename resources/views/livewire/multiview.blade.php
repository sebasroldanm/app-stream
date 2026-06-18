<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}"
                 class="img-fluid w-100"
                 alt="header-bg">

            <div class="title-on-header">
                <div class="data-block">
                    <h2>{{ __('sidebar.explore') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">

            {{-- LISTADO DE OWNERS --}}
            <div class="mb-4 d-flex flex-wrap gap-2">
                @foreach ($liveOwners as $ownerModel)

                    <button
                        type="button"
                        class="btn btn-outline-light owner-btn"
                        data-owner-id="{{ $ownerModel->id }}"
                        data-username="{{ $ownerModel->username }}"
                        data-status="{{ __('common.show_mode.' . ($ownerModel->show_mode ?: 'live')) }}"
                        data-stream-url="{{ trim(env('URL_HLS') . $ownerModel->id . '/master/' . $ownerModel->id . '.m3u8') }}"
                    >
                        {{ $ownerModel->username }} @if ($ownerModel->show_mode) <i class="fa fa-lock" aria-hidden="true"></i> @endif
                    </button>

                @endforeach
            </div>

            {{-- CONTENEDOR DE VIDEOS --}}
            <div
                id="video-grid"
                class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4"
            ></div>

        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/frontend/multiview.js') }}"></script>
@endpush