<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme='{{ session('themeApp') ?? 'light' }}'>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? env('APP_NAME') }}</title>

    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('/css/frontend/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/frontend/socialv.css?v=4.0.0') }}">
    <link rel="stylesheet" href="{{ asset('/css/frontend/custom.css?v=1.0.0') }}">
    @if (env('PARENTAL_CONTROL') == 'production')
        <link rel="stylesheet" href="{{ asset('/css/frontend/parental.css?v=1.0.0') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('/vendor/fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/vanillajs-datepicker/dist/css/datepicker.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('/vendor/font-awesome-line-awesome/css/all.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

    @stack('styles')
    @livewireStyles
</head>

<body>

    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->

    <!-- Wrapper Start -->
    <div class="wrapper">

        <livewire:sidebar-default />
        <livewire:top-navbar />
        <livewire:right-sidebar />

        <div id="viewer_photo" class="modal_vp">
            <span class="cerrar">&times;</span>
            <img id="imagenModal" class="modal_vp-content" data-img-prev="" data-img-next="">
            <div class="modal_vp-footer">
                <div id="thumbs" class="modal_vp-thumbs"></div>
            </div>
        </div>

        <main>
            {{ $slot }} <!-- Contenido de la vista -->
        </main>
    </div>

    @livewire('footer')

    @livewireScripts
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('js/frontend/libs.min.js') }}"></script>
    <!-- slider JavaScript -->
    <script src="{{ asset('js/frontend/slider.js') }}"></script>
    <!-- masonry JavaScript -->
    <script src="{{ asset('js/frontend/masonry.pkgd.min.js') }}"></script>
    <!-- SweetAlert JavaScript -->
    <script src="{{ asset('js/frontend/enchanter.js') }}"></script>
    <!-- SweetAlert JavaScript -->
    <script src="{{ asset('js/frontend/sweetalert.js') }}"></script>
    <!-- app JavaScript -->
    <script src="{{ asset('js/frontend/charts/weather-chart.js') }}"></script>
    <script src="{{ asset('js/frontend/app.js') }}"></script>
    <script src="{{ asset('vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('js/frontend/lottie.js') }}"></script>

    <!-- plyr -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <!-- hls.js -->
    <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>


    <script src="{{ asset('js/frontend/custom.js') }}"></script>


</body>

</html>
