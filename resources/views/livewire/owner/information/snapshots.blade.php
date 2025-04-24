<div class="row">
    <div class="col-md-12">
        <h4 class="mb-3">Instantáneas</h4>
    </div>
    @if (count($snapshots) == 0)
        <div class="col-md-12">
            <h5 class="mb-3 text-center">No hay Instantáneas :(</h5>
        </div>
    @endif
    @foreach ($snapshots as $day)
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ Carbon\Carbon::parse($day[0]->created_at)->format('d M, Y') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($day as $snapshot)
                            <div class="col-3">
                                @if ($snapshot->picture_upload_id !== '')
                                    <img loading="lazy" src="{{ $snapshot->picture->url }}" class="rounded ms-3 mb-3 img-fluid fullviewer" alt="Snapshot">
                                @else
                                    @if ($snapshot->local_url !== '')
                                        <img loading="lazy" src="{{ URL::to('/') . $snapshot->local_url }}" class="rounded ms-3 mb-3 img-fluid fullviewer"
                                            alt="Snapshot">
                                    @else
                                        <img loading="lazy" src="{{ $snapshot->snapshotUrl }}" class="rounded ms-3 mb-3 img-fluid fullviewer" alt="Snapshot">
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
    @endforeach
</div>
