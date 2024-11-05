<div class="row">
    @foreach ($snapshots as $day)
        {{-- {{ dd($day) }} --}}
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
                                @if ($snapshot->local_url !== '')
                                    <img loading="lazy" src="{{ URL::to('/') . $snapshot->local_url }}" class="rounded ms-3 img-fluid"
                                        alt="Snapshot">
                                @else
                                    <img loading="lazy" src="{{ $snapshot->snapshotUrl }}" class="rounded ms-3 img-fluid" alt="Snapshot">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
    @endforeach
</div>
