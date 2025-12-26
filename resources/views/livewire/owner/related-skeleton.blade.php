<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h4 class="mb-3">Modelos Relacionados</h4>
            </div>
            <div class="swiper related-swiper">
                <div class="swiper-wrapper">
                    @foreach (range(1, 8) as $i)
                        <div class="swiper-slide">
                            <div class="card" aria-hidden="true">
                                <div class="image-container container-overlay placeholder-glow"
                                    style="height: 200px; background-color: #f0f0f0; position: relative;">
                                    <!-- Placeholder for image -->
                                    <div class="placeholder w-100 h-100"></div>
                                </div>
                                <div class="card-body p-1 placeholder-glow">
                                    <span class="placeholder col-12"></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
