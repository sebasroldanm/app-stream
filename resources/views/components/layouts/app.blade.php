<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ session('themeApp') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} {{ $title ?? '' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="AppStream" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

    <link rel="stylesheet" href="{{ asset('/css/frontend/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/frontend/socialv.css?v=4.0.0') }}">
    <link rel="stylesheet" href="{{ asset('/css/frontend/custom.css?v=1.0.0') }}">
    @if (session('notice_age') == false)
        <link id="parental-css" rel="stylesheet" href="{{ asset('/css/frontend/parental.css?v=1.0.0') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('/css/frontend/flag-icons.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/vanillajs-datepicker/dist/css/datepicker.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('/vendor/font-awesome-line-awesome/css/all.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/plyr.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend/live.css') }}" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="{{ asset('css/frontend/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend/stories.css') }}?v=1.0">

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
        <livewire:notice-age />

        <div id="viewer_photo" 
             class="modal_vp" 
             x-data 
             x-cloak
             @click.self="$store.viewer.close()"
             @keydown.escape.window="$store.viewer.close()"
             :class="{ 'active': $store.viewer.active }">
            <span class="cerrar" @click="$store.viewer.close()">&times;</span>
            
            <!-- Mostrar Imagen -->
            <img id="imageModal" 
                 class="modal_vp-content rounded" 
                 x-show="$store.viewer.type === 'image'"
                 :src="$store.viewer.src" 
                 alt="Preview image"
                 :style="$store.viewer.style">
                 
            <!-- Mostrar Video -->
            <template x-if="$store.viewer.type === 'video'">
                <video id="videoModal" 
                       class="modal_vp-content rounded" 
                       controls 
                       autoplay 
                       playsinline 
                       x-init="$el.load()">
                    <source :src="$store.viewer.videoSrc">
                </video>
            </template>
            
            <!-- Miniaturas (Footer) -->
            <div class="modal_vp-footer" x-show="$store.viewer.type === 'image' && $store.viewer.thumbs.length > 1">
                <div id="thumbs" class="modal_vp-thumbs">
                    <template x-for="(thumb, index) in $store.viewer.thumbs" :key="index">
                        <img class="thumb-item" 
                             :class="{ 'active': $store.viewer.currentIndex === index }" 
                             :src="thumb"
                             @click="$store.viewer.selectThumb(index)">
                    </template>
                </div>
            </div>
        </div>

        <main>
            {{ $slot }} <!-- Contenido de la vista -->
        </main>
    </div>

    @livewire('footer')

    @livewireScripts

    {{-- STACK DE SCRIPTS --}}
    @stack('scripts')
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('js/frontend/libs.min.js') }}"></script>
    <!-- slider JavaScript -->
    <script src="{{ asset('js/frontend/slider.js') }}"></script>
    <!-- info JavaScript -->
    <script src="{{ asset('js/frontend/info.js') }}"></script>
    <!-- masonry JavaScript -->
    <script src="{{ asset('js/frontend/masonry.pkgd.min.js') }}"></script>
    <!-- SweetAlert JavaScript -->
    <script src="{{ asset('js/frontend/enchanter.js') }}" data-navigate-once></script>
    <!-- SweetAlert JavaScript -->
    <script src="{{ asset('js/frontend/sweetalert.js') }}" data-navigate-once></script>
    <!-- app JavaScript -->
    <script src="{{ asset('js/frontend/charts/weather-chart.js') }}"></script>
    <script src="{{ asset('js/frontend/app.js') }}"></script>
    <script src="{{ asset('vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('js/frontend/lottie.js') }}"></script>

    <!-- plyr -->
    <script src="{{ asset('vendor/plyr.js') }}"></script>
    <!-- hls.js -->
    <script src="{{ asset('vendor/hls.min.js') }}"></script>
    <!-- Swiper JS -->
    <script src="{{ asset('vendor/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('vendor/confetti.browser.min.js') }}"></script>


    @php $version = date('YmdHi'); @endphp
    <script src="{{ asset('js/frontend/search.js') }}?v={{ $version }}" data-navigate-once></script>
    <script src="{{ asset('js/frontend/fullviewer.js') }}?v={{ $version }}" data-navigate-once></script>
    <script src="{{ asset('js/frontend/layout-utils.js') }}?v={{ $version }}" data-navigate-once></script>
    <script src="{{ asset('js/frontend/custom.js') }}?v={{ $version }}" data-navigate-once></script>
    <script src="{{ asset('js/frontend/video-component.js') }}?v={{ $version }}" data-navigate-once></script>
    <script src="{{ asset('js/frontend/live.js') }}?v={{ $version }}" data-navigate-once></script>
    <script src="{{ asset('js/frontend/celebrations/birthday.js') }}?v={{ $version }}" data-navigate-once></script>
    <script src="{{ asset('js/frontend/stories.js') }}?v={{ $version }}" data-navigate-once></script>


</body>

</html>
