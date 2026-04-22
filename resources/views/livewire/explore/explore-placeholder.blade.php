<div>
    {{-- Header estático para mantener la estructura visual --}}
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Explorar New CO</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                {{-- Generamos 12 o 18 tarjetas de ejemplo (múltiplos de las columnas) --}}
                @for ($i = 0; $i < 18; $i++)
                    <div class="col-3 col-sm-2">
                        <div class="card mb-3">
                            <div class="card_explorer_image">
                                <div class="image-container">
                                    {{-- Skeleton de la imagen principal --}}
                                    <div class="skeleton-placeholder w-100" 
                                         style="aspect-ratio: 3/4; border-radius: 5px 5px 0 0;">
                                    </div>
                                </div>
                                <div class="card-body p-1 text-center">
                                    {{-- Skeleton del username --}}
                                    <div class="skeleton-placeholder mx-auto" 
                                         style="width: 80%; height: 12px; margin-top: 5px; margin-bottom: 5px;">
                                    </div>
                                </div>
                            </div>

                            {{-- Skeletons para los iconos flotantes (Badges) --}}
                            <div class="s_icon top right">
                                <div class="skeleton-placeholder rounded-pill" 
                                     style="width: 30px; height: 15px; opacity: 0.5;"></div>
                            </div>
                            <div class="s_icon top left">
                                <div class="skeleton-placeholder rounded-pill" 
                                     style="width: 25px; height: 25px; opacity: 0.5;"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>