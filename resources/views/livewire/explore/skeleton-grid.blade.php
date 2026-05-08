<div class="row">
    @for ($i = 0; $i < 18; $i++)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4">
            <div class="card mb-3">
                <div class="card_explorer_image">
                    <div class="image-container">
                        {{-- Skeleton de la imagen principal --}}
                        <div class="skeleton-placeholder w-100" 
                             style="aspect-ratio: 1/1; border-radius: 5px 5px 0 0;">
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
