@props(['post'])

@php
    $owner = $post->owner;
@endphp

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="post-item">
                <div class="user-post-data pb-3">
                    <div class="d-flex justify-content-between">
                        <div class="me-3">
                            <a href="{{ route('owner', $owner->username) }}">
                                <img class="rounded-circle avatar-60" src="{{ $owner->avatar }}"
                                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ $owner->username }}';"
                                    alt="">
                            </a>
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="">
                                    <h5 class="mb-0 d-inline-block"><a href="{{ route('owner', $owner->username) }}"
                                            class="">{{ $owner->username }}</a></h5>
                                    <p class="ms-1 mb-0 d-inline-block">
                                        {{ __('components/feed.header.post_added') }}
                                    </p>
                                    @if($post->published_at)
                                    <p class="mb-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="{{ $post->published_at->format('d/m/Y H:i') }}"
                                        title="{{ $post->published_at->format('d/m/Y H:i') }}">
                                        {{ $post->published_at->diffForHumans() }}
                                    </p>
                                    @endif
                                    @if(isset($post->media) && $post->media->count() > 0)
                                        <div class="row">
                                            @foreach($post->media as $media)
                                                <div class="col-4 mb-2">
                                                    @if($media instanceof \App\Models\TelegramPhoto)
                                                        <img src="{{ telegram_media_url($media->file_id) }}" class="img-fluid rounded" alt="">
                                                    @elseif($media instanceof \App\Models\TelegramVideo)
                                                        <div class="position-relative">
                                                             <img src="{{ telegram_media_url($media->thumb_file_id ?? $media->thumbnail_file_id) }}" class="img-fluid rounded" alt="">
                                                             <div class="position-absolute top-50 start-50 translate-middle">
                                                                 <i class="ri-play-circle-line h1 text-white"></i>
                                                             </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif ($post->telegramMessage->photo)
                                        <img src="{{ telegram_media_url($post->telegramMessage->photo->file_id) }}" class="img-fluid" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="user-post">
                    @if (!empty($post->body))
                        <p>{!! nl2br(e($post->body)) !!}</p>
                    @elseif($post->telegramMessage && !empty($post->telegramMessage->text))
                        <p>{!! nl2br(e($post->telegramMessage->text)) !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
