<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-3">Videos</h4>
            </div>
            @if (count($videos) > 0)
                <div class="col-md-3">
                    <ul class="nav nav-pills basic-info-items list-inline d-block p-0 m-0">
                        @foreach ($videos as $tab => $video)
                            <li>
                                <a class="nav-link d-flex justify-content-between @if ($tab == 0) active @endif"
                                    href="#v-pills-video_{{ $video->id }}" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-video_{{ $video->id }}" role="button">
                                    {{ mb_substr($video->title, 0, 17) . (mb_strlen($video->title) > 17 ? '...' : '') }}
                                    @if ($video->accessMode !== 'free')
                                        <span class="badge bg-danger h-100"><i
                                                class="las la-hand-holding-usd"></i></span>
                                    @else
                                        <span class="badge bg-success h-100"><i
                                                class="las la-hand-holding-heart"></i></span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9 ps-4">
                    <div class="tab-content">
                        @foreach ($videos as $panel => $video)
                            <div class="tab-pane fade @if ($panel == 0) show active @endif"
                                id="v-pills-video_{{ $video->id }}" role="tabpanel"
                                aria-labelledby="v-pills-video_{{ $video->id }}">
                                @livewire('owner.videos.content-video', ['owner' => $owner, 'video' => $video], key($video->id))
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal fade modal-video-owner" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                {{-- <h5 class="modal-title">Video</h5> --}}
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                                </button>
                            </div>
                            <div class="modal-body p-0">
                                <video id="player">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <h5 class="mb-3 text-center">No hay Videos :(</h5>
                </div>
            @endif
        </div>
    </div>
</div>
