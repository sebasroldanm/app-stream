<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-body chat-page p-0">
                    <div class="chat-data-block">
                        <div class="row">
                            <div class="col-lg-3 chat-data-left scroller">
                                <div class="chat-search pt-3 pl-3">
                                    <div class="d-flex align-items-center">
                                        <div class="chat-profile mr-3">
                                            <img src="images/user/1.jpg" alt="chat-user" class="avatar-60 ">
                                        </div>
                                        <div class="chat-caption">
                                            <h5 class="mb-0">Bni Jordan</h5>
                                            <p class="m-0">Web Designer</p>
                                        </div>
                                        <button type="submit" class="close-btn-res p-3"><i
                                                class="ri-close-fill"></i></button>
                                    </div>
                                    <div id="user-detail-popup" class="scroller">
                                        <div class="user-profile">
                                            <button type="submit" class="close-popup p-3"><i
                                                    class="ri-close-fill"></i></button>
                                            <div class="user text-center mb-4">
                                                <a class="avatar m-0">
                                                    <img src="images/user/1.jpg" alt="avatar">
                                                </a>
                                                <div class="user-name mt-4">
                                                    <h4>Bni Jordan</h4>
                                                </div>
                                                <div class="user-desc">
                                                    <p>Web Designer</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="user-detail text-left mt-4 pl-4 pr-4">
                                                <h5 class="mt-4 mb-4">About</h5>
                                                <p>It is long established fact that a reader will be distracted bt the
                                                    reddable.</p>
                                                <h5 class="mt-3 mb-3">Status</h5>
                                                <ul class="user-status p-0">
                                                    <li class="mb-1"><i
                                                            class="ri-checkbox-blank-circle-fill text-success pr-1"></i><span>Online</span>
                                                    </li>
                                                    <li class="mb-1"><i
                                                            class="ri-checkbox-blank-circle-fill text-warning pr-1"></i><span>Away</span>
                                                    </li>
                                                    <li class="mb-1"><i
                                                            class="ri-checkbox-blank-circle-fill text-danger pr-1"></i><span>Do
                                                            Not Disturb</span></li>
                                                    <li class="mb-1"><i
                                                            class="ri-checkbox-blank-circle-fill text-light pr-1"></i><span>Offline</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-searchbar mt-4">
                                        <div class="form-group chat-search-data m-0">
                                            <input type="text" class="form-control round" id="chat-search"
                                                placeholder="Search">
                                            <i class="ri-search-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-sidebar-channel scroller mt-4 pl-3">
                                    <h5 class="">Mensajes ({{ $conversations->conversationsCount }})</h5>
                                    <ul class="iq-chat-ui nav flex-column nav-pills">
                                        @foreach ($conversations->conversations as $conv)
                                            <li>
                                                <div class="d-flex align-items-center my-2" role=button
                                                    wire:click="selectConversation('{{ $conv->counterpartId }}')">
                                                    <div class="avatar mr-2">
                                                        <img src="{{ $conv->message->avatar }}" alt="chatuserimage"
                                                            class="avatar-50 ">
                                                        <span class="avatar-status"><i
                                                                class="ri-checkbox-blank-circle-fill text-success"></i></span>
                                                    </div>
                                                    <div class="chat-sidebar-name ms-1">
                                                        <h6 title="{{ $conv->message->username }}" class="mb-0">
                                                            {{ Str::limit($conv->message->username, 16) }}</h6>
                                                        <span
                                                            title="{{ $conv->message->body }}">{{ Str::limit($conv->message->body, 12) }}</span>
                                                    </div>
                                                    <div class="chat-meta float-right text-center mt-2 mr-1">
                                                        <div class="chat-msg-counter bg-primary text-white">
                                                            {{ $conv->unread }}</div>
                                                        <span
                                                            class="text-nowrap">{{ $conv->message->created_at }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-9 chat-data p-0 chat-data-right">
                                <div class="tab-content">
                                    @if (is_null($selectedConversation))
                                        <div class="tab-pane fade active show" id="default-block" role="tabpanel">
                                            <div class="chat-start">
                                                <span class="iq-start-icon text-primary"><i
                                                        class="ri-message-3-line"></i></span>
                                                <button id="chat-start" class="btn mt-3">Start
                                                    Conversation!</button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="chat-head">
                                            <header
                                                class="d-flex justify-content-between align-items-center pt-3 pr-3 pb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="sidebar-toggle">
                                                        <i class="ri-menu-3-line"></i>
                                                    </div>
                                                    <div class="avatar chat-user-profile m-0 mr-3">
                                                        <img src="{{ $messages->model->avatarUrl }}" alt="avatar"
                                                            class="avatar-50 ">
                                                        <span class="avatar-status"><i
                                                                class="ri-checkbox-blank-circle-fill text-success"></i></span>
                                                    </div>
                                                    <h5 class="mb-0 ms-2">{{ $messages->model->username }}</h5>
                                                </div>
                                                <div class="chat-user-detail-popup scroller">
                                                    <div class="user-profile text-center">
                                                        <button type="submit" class="close-popup p-3"><i
                                                                class="ri-close-fill"></i></button>
                                                        <div class="user mb-4">
                                                            <a class="avatar m-0">
                                                                <img src="{{ $messages->model->avatarUrl }}"
                                                                    alt="avatar">
                                                            </a>
                                                            <div class="user-name mt-4">
                                                                <h4>{{ $messages->model->username }}</h4>
                                                            </div>
                                                            <div class="user-desc">
                                                                <p>Amigos desde
                                                                    {{ \Carbon\Carbon::parse($messages->friendship->createdAt)->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        {{-- <hr>
                                                        <div class="chatuser-detail text-left mt-4">
                                                            <div class="row">
                                                                <div class="col-6 col-md-6 title">Bni Name:</div>
                                                                <div class="col-6 col-md-6 text-right">Bni</div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-6 col-md-6 title">Tel:</div>
                                                                <div class="col-6 col-md-6 text-right">072 143 9920
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-6 col-md-6 title">Date Of Birth:</div>
                                                                <div class="col-6 col-md-6 text-right">July 12, 1989
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-6 col-md-6 title">Gender:</div>
                                                                <div class="col-6 col-md-6 text-right">Male</div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-6 col-md-6 title">Language:</div>
                                                                <div class="col-6 col-md-6 text-right">Engliah</div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <div class="chat-header-icons d-flex">
                                                    <a href="javascript:void();"
                                                        class="chat-icon-phone iq-bg-primary">
                                                        <i class="ri-phone-line"></i>
                                                    </a>
                                                    <a href="javascript:void();"
                                                        class="chat-icon-video iq-bg-primary">
                                                        <i class="ri-vidicon-line"></i>
                                                    </a>
                                                    <a href="javascript:void();"
                                                        class="chat-icon-delete iq-bg-primary">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                    <span class="dropdown iq-bg-primary">
                                                        <i class="ri-more-2-line cursor-pointer dropdown-toggle nav-hide-arrow cursor-pointer pr-0"
                                                            id="dropdownMenuButton02" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"
                                                            role="menu"></i>
                                                        <span class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton02">
                                                            <a class="dropdown-item" href="JavaScript:void(0);"><i
                                                                    class="fa fa-thumb-tack" aria-hidden="true"></i>
                                                                Pin to top</a>
                                                            <a class="dropdown-item" href="JavaScript:void(0);"><i
                                                                    class="fa fa-trash-o" aria-hidden="true"></i>
                                                                Delete chat</a>
                                                            <a class="dropdown-item" href="JavaScript:void(0);"><i
                                                                    class="fa fa-ban" aria-hidden="true"></i>
                                                                Block</a>
                                                        </span>
                                                    </span>
                                                </div>
                                            </header>
                                        </div>
                                        <div class="chat-content scroller">
                                            {{-- <div class="chat chat-right">
                                                <div class="chat-detail">
                                                    <div class="chat-message">
                                                        <p>How can we help? We're here for you! 😄</p>
                                                    </div>
                                                </div>
                                                <div class="chat-user">
                                                    <a class="avatar m-0">
                                                        <img src="images/user/1.jpg" alt="avatar" class="avatar-35 ">
                                                    </a>
                                                    <span class="chat-time mt-1">6:45</span>
                                                </div>
                                            </div> --}}
                                            @foreach ($messages->messages as $message)
                                                <div class="chat chat-left row">
                                                    <div class="chat-user col-lg-1">
                                                        <a class="avatar m-0">
                                                            <img src="{{ $messages->model->avatarUrl }}"
                                                                alt="avatar" class="avatar-35 ">
                                                        </a>
                                                        <span
                                                            class="chat-time mt-1">{{ \Carbon\Carbon::parse($message->createdAt)->diffForHumans() }}</span>
                                                    </div>
                                                    <div class="chat-detail col-lg-11">
                                                        <div class="chat-message">
                                                            <p>{{ $message->body }}</p>
                                                            @if ($message->media)
                                                                {{-- Photo --}}
                                                                @if (isset($message->media->photo))
                                                                    @php
                                                                        $photo = $message->media->photo;
                                                                        if (isset($photo->url)) {
                                                                            $url = $photo->url;
                                                                        } elseif (isset($photo->urlThumb)) {
                                                                            $url = $photo->urlThumb;
                                                                        } elseif (isset($photo->urlPreview)) {
                                                                            $url = $photo->urlPreview;
                                                                        } elseif (isset($photo->urlThumbMicro)) {
                                                                            $url = $photo->urlThumbMicro;
                                                                        } else {
                                                                            $url = null;
                                                                        }
                                                                    @endphp
                                                                    <img class="photo-message img-fluid rounded fullviewer"
                                                                        src="{{ $url }}" alt="photo"
                                                                        class="img-fluid rounded">
                                                                @endif
                                                                {{-- Photo --}}
                                                                {{-- Album --}}
                                                                @if (isset($message->media->album))
                                                                    @foreach ($message->media->album->photos as $photo)
                                                                        @php
                                                                            if (isset($photo->url)) {
                                                                                $url = $photo->url;
                                                                            } elseif (isset($photo->urlThumb)) {
                                                                                $url = $photo->urlThumb;
                                                                            } elseif (isset($photo->urlPreview)) {
                                                                                $url = $photo->urlPreview;
                                                                            } elseif (isset($photo->urlThumbMicro)) {
                                                                                $url = $photo->urlThumbMicro;
                                                                            } else {
                                                                                $url = null;
                                                                            }
                                                                        @endphp
                                                                        <img class="photo-album img-fluid rounded fullviewer mb-1"
                                                                            src="{{ $url }}" alt="photo"
                                                                            class="img-fluid rounded"
                                                                            data-images-full='@json(collect($message->media->album->photos)->pluck('url'))'
                                                                            data-images-thumb='@json(collect($message->media->album->photos)->pluck('urlThumb'))'>
                                                                    @endforeach
                                                                @endif
                                                                {{-- Album --}}
                                                                {{-- Video --}}
                                                                @if (isset($message->media->video))
                                                                    @if (isset($message->media->video->videoUrl))
                                                                        <x-video-component 
                                                                            :poster="$message->media->video->coverUrl" 
                                                                            :video="$message->media->video->videoUrl"
                                                                        />
                                                                    @else
                                                                        <x-video-component 
                                                                            :poster="$message->media->video->coverUrl" 
                                                                            :video="$message->media->video->trailerUrl"
                                                                        />
                                                                    @endif
                                                                @endif
                                                                {{-- Video --}}
                                                                {{-- Mixed --}}
                                                                @if (isset($message->media->mixed))
                                                                    @foreach ($message->media->mixed as $mixMedia)
                                                                        @if ($mixMedia->type == 'photo')
                                                                            @php
                                                                                if (isset($mixMedia->url)) {
                                                                                    $url = $mixMedia->url;
                                                                                } elseif (isset($mixMedia->urlThumb)) {
                                                                                    $url = $mixMedia->urlThumb;
                                                                                } elseif (isset($mixMedia->urlPreview)) {
                                                                                    $url = $mixMedia->urlPreview;
                                                                                } elseif (isset($mixMedia->urlThumbMicro)) {
                                                                                    $url = $mixMedia->urlThumbMicro;
                                                                                } else {
                                                                                    $url = null;
                                                                                }
                                                                            @endphp
                                                                            <img class="photo-mixed img-fluid rounded fullviewer mb-1"
                                                                                src="{{ $url }}"
                                                                                alt="photo"
                                                                                class="img-fluid rounded">
                                                                        @endif
                                                                        @if ($mixMedia->type == 'video')
                                                                            @if (isset($mixMedia->videoUrl))
                                                                                <x-video-component 
                                                                                    :poster="$mixMedia->coverUrl" 
                                                                                    :video="$mixMedia->videoUrl"
                                                                                />
                                                                            @else
                                                                                <x-video-component 
                                                                                    :poster="$mixMedia->coverUrl" 
                                                                                    :video="$mixMedia->trailerUrl"
                                                                                />
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                {{-- Mixed --}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="chat-footer p-3">
                                                <form class="d-flex align-items-center" action="javascript:void(0);">
                                                    <div class="chat-attagement d-flex">
                                                        <a href="javascript:void();"><i class="fa fa-smile-o pr-3"
                                                                aria-hidden="true"></i></a>
                                                        <a href="javascript:void();"><i class="fa fa-paperclip pr-3"
                                                                aria-hidden="true"></i></a>
                                                    </div>
                                                    <input type="text" class="form-control mr-3"
                                                        placeholder="Type your message">
                                                    <button type="submit"
                                                        class="btn btn-primary d-flex align-items-center p-2"><i
                                                            class="fa fa-paper-plane-o" aria-hidden="true"></i><span
                                                            class="d-none d-lg-block ml-1">Send</span></button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
