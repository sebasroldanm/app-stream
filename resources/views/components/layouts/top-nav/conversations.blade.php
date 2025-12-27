<div>
    <div class="card-header d-flex justify-content-between bg-primary">
        <div class="header-title bg-primary">
            <h5 class="mb-0 text-white">Conversaciones</h5>
        </div>
        <small class="badge  bg-light text-dark">{{ $data->conversationsCount }}</small>
    </div>
    <div class="card-body p-0">
        @foreach ($data->conversations as $conversation)
            @php
                $owner = \Illuminate\Support\Facades\Cache::remember(
                    'conversations_user_' . $conversation->message->senderId,
                    now()->addHours(5),
                    function () use ($conversation) {
                        return \App\Models\Owner::find($conversation->message->senderId);
                    },
                );
            @endphp
            <a href="{{ isset($owner->username) ? '/owner/' . $owner->username : '#' }}" class="iq-sub-card">
                <div class="d-flex align-items-center">
                    <div class="">
                        <img class="avatar-40 rounded" src="{{ $owner->avatar ?? asset('/images/user/01.jpg') }}"
                            alt="">
                    </div>
                    <div class="ms-3 w-100">
                        <h6 class="mb-0 ">{{ $owner->username ?? 'Unknown' }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">{{ substr($conversation->message->body, 0, 20) }}</p>
                            <small
                                class="float-right font-size-12">{{ \Carbon\Carbon::parse($conversation->message->createdAt)->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
