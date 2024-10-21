<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="{{ $video->coverUrl }}" class="card-img" alt="..." />
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $video->title }}</h5>
                        <p class="card-text">{{ $video->description }}</p>
                        <div class="row">
                            <div class="col-3">
                                <h6>Acceso</h6>
                            </div>
                            <div class="col-9">
                                {{ $video->accessMode }}
                            </div>
                            <div class="col-3">
                                <h6>Dureción</h6>
                            </div>
                            <div class="col-9">
                                {{ $video->duration }}
                            </div>
                        </div>
                        {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <video src="{{ $video->url ? $video->url : $video->trailerUrl }}" controls width="100%"></video>
                </div>
            </div>
        </div>
    </div>
    {{-- {{ json_encode($video) }} --}}
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
</div>
