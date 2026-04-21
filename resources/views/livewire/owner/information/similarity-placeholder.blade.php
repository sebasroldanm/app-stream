<div class="row">
    <div class="col-md-12">
        <h4 class="mb-3 d-flex justify-content-between">
            {{ __('owner/ia/results.title') }}
        </h4>
    </div>
    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="skeleton-placeholder" style="width: 120px; height: 15px; border-radius: 5px;"></div>
        </div>

        @for ($i = 0; $i < 4; $i++)
            <div class="col-md-6 col-lg-6 mb-3">
                <div class="ia_similarity">
                    <div class="row card">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5 p-0">
                                    {{-- Skeleton de la imagen de perfil --}}
                                    <div class="skeleton-placeholder w-100 rounded" style="aspect-ratio: 1/1;"></div>
                                </div>
                                <div class="col-7">
                                    <div class="info">
                                        {{-- Title --}}
                                        <div class="skeleton-placeholder mb-2" style="width: 80%; height: 18px;"></div>

                                        {{-- Probability --}}
                                        <div class="skeleton-placeholder" style="width: 100%; height: 14px;"></div>

                                        {{-- Similarity --}}
                                        <div class="skeleton-placeholder" style="width: 90%; height: 14px;"></div>

                                        {{-- Platform --}}
                                        <div class="skeleton-placeholder" style="width: 70%; height: 14px;"></div>
                                        
                                        {{-- Connection --}}
                                        <div class="skeleton-placeholder" style="width: 85%; height: 14px;"></div>

                                        {{-- Profile --}}
                                        <div class="skeleton-placeholder" style="width: 80%; height: 14px;"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 py-2 text-center">
                            {{-- Button skeleton --}}
                            <div class="skeleton-placeholder" style="width: 150px; height: 35px; border-radius: 5px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
