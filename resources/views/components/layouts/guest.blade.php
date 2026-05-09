<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }} | {{ $title ?? __('login.title') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="AppStream" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/socialv.css?v=4.0.0') }}">
    {{-- <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendor/remixicon/fonts/remixicon.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendor/vanillajs-datepicker/dist/css/datepicker.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendor/font-awesome-line-awesome/css/all.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}"> --}}

</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="sign-in-page">
            <div id="container-inside">
                <div id="circle-small"></div>
                <div id="circle-medium"></div>
                <div id="circle-large"></div>
                <div id="circle-xlarge"></div>
                <div id="circle-xxlarge"></div>
            </div>
            <div class="container p-0">
                <div class="row no-gutters">
                    <div class="col-md-6 text-center pt-5">
                        <div class="sign-in-detail text-white">
                            <a class="sign-in-logo mb-5" href="#">
                                <img src="{{ asset('/images/logo-full.png') }}" class="img-fluid" alt="logo">
                            </a>
                            <div class="sign-slider overflow-hidden ">
                                <ul class="swiper-wrapper list-inline m-0 p-0 ">
                                    <li class="swiper-slide">
                                        <img src="{{ asset('/images/login/1.png') }}" class="img-fluid mb-4"
                                            alt="logo">
                                        <h4 class="mb-1 text-white">{{ __('login.slide_1_title') }}</h4>
                                        <p>{{ __('login.slide_1_content') }}</p>
                                    </li>
                                    <li class="swiper-slide">
                                        <img src="{{ asset('/images/login/2.png') }}" class="img-fluid mb-4"
                                            alt="logo">
                                        <h4 class="mb-1 text-white">{{ __('login.slide_2_title') }}</h4>
                                        <p>{{ __('login.slide_2_content') }}</p>
                                    </li>
                                    <li class="swiper-slide">
                                        <img src="{{ asset('/images/login/3.png') }}" class="img-fluid mb-4"
                                            alt="logo">
                                        <h4 class="mb-1 text-white">{{ __('login.slide_3_title') }}</h4>
                                        <p>{{ __('login.slide_3_content') }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bg-white pt-5 pt-5 pb-lg-0 pb-5">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('/js/frontend/libs.min.js') }}"></script>
    <!-- slider JavaScript -->
    <script src="{{ asset('/js/frontend/slider.js') }}"></script>
    {{-- <!-- masonry JavaScript -->
    <script src="{{ asset('/js/frontend/masonry.pkgd.min.js') }}"></script> --}}
    {{-- <!-- SweetAlert JavaScript -->
    <script src="{{ asset('/js/frontend/enchanter.js') }}"></script> --}}
    {{-- <!-- SweetAlert JavaScript -->
    <script src="{{ asset('/js/frontend/sweetalert.js') }}"></script> --}}
    {{-- <!-- app JavaScript -->
    <script src="{{ asset('/js/frontend/charts/weather-chart.js') }}"></script> --}}
    <script src="{{ asset('/js/frontend/app.js') }}"></script>
    {{-- <script src="{{ asset('vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/js/frontend/lottie.js') }}"></script> --}}

</body>

</html>
