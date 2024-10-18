<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/socialv.css?v=4.0.0') }}">
    <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/vanillajs-datepicker/dist/css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome-line-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">

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
                                        <img src="{{ asset('/images/login/1.png') }}" class="img-fluid mb-4" alt="logo">
                                        <h4 class="mb-1 text-white">Encuentra a celebridades</h4>
                                        <p>Te gusta algo, síguelo, y comparte.</p>
                                    </li>
                                    <li class="swiper-slide">
                                        <img src="{{ asset('/images/login/2.png') }}" class="img-fluid mb-4" alt="logo">
                                        <h4 class="mb-1 text-white">Descubre nuevas experiencias</h4>
                                        <p>Los mejores secretos estan guardados donde no vemos.</p>
                                    </li>
                                    <li class="swiper-slide">
                                        <img src="{{ asset('/images/login/3.png') }}" class="img-fluid mb-4" alt="logo">
                                        <h4 class="mb-1 text-white">Manten al día</h4>
                                        <p>Toma el control de lo que quieres ver.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bg-white pt-5 pt-5 pb-lg-0 pb-5">
                        <div class="sign-in-from">
                            <h1 class="mb-0">Sign in</h1>
                            <p>Ingrese su dirección de correo electrónico y contraseña para acceder.</p>
                            <form class="mt-4" method="POST" action="{{ route('customer.login.submit') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label" for="email">Correo electrónico</label>
                                    <input name="email" type="email" class="form-control mb-0" id="email"
                                        placeholder="Ingresar correo">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <a href="#" class="float-end">¿Olvidaste tu contraseña?</a>
                                    <input name="password" type="password" class="form-control mb-0" id="password"
                                        placeholder="Contraseña">
                                </div>
                                <div class="d-inline-block w-100">
                                    <div class="form-check d-inline-block mt-2 pt-1">
                                        <input type="checkbox" class="form-check-input" id="customCheck11">
                                        <label class="form-check-label" for="customCheck11">Recordarme</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-end">Ingresar</button>
                                </div>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">¿No tienes una cuenta? <a
                                            href="sign-up.html">Registrate</a></span>
                                    {{-- <ul class="iq-social-media">
                                        <li><a href="#"><i class="ri-facebook-box-line"></i></a></li>
                                        <li><a href="#"><i class="ri-twitter-line"></i></a></li>
                                        <li><a href="#"><i class="ri-instagram-line"></i></a></li>
                                    </ul> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('/js/frontend/libs.min.js') }}"></script>
    <!-- slider JavaScript -->
    <script src="{{ asset('/js/frontend/slider.js') }}"></script>
    <!-- masonry JavaScript -->
    <script src="{{ asset('/js/frontend/masonry.pkgd.min.js') }}"></script>
    <!-- SweetAlert JavaScript -->
    <script src="{{ asset('/js/frontend/enchanter.js') }}"></script>
    <!-- SweetAlert JavaScript -->
    <script src="{{ asset('/js/frontend/sweetalert.js') }}"></script>
    <!-- app JavaScript -->
    <script src="{{ asset('/js/frontend/charts/weather-chart.js') }}"></script>
    <script src="{{ asset('/js/frontend/app.js') }}"></script>
    <script src="{{ asset('vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('/js/frontend/lottie.js') }}"></script>

</body>

</html>
