<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Gestion de Publicaciones</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Chats de Telegram</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo</th>
                                            <th>Título</th>
                                            <th>Username</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($telegram_chats as $chat)
                                            <tr>
                                                <td>{{ $chat->id }}</td>
                                                <td>{{ $chat->type }}</td>
                                                <td>{{ $chat->title }}</td>
                                                <td>{{ $chat->username }}</td>
                                                <td>
                                                    <button wire:click="viewPosts({{ $chat->id }})"
                                                        class="btn btn-primary btn-sm">Ver Posts</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($selectedChat)
                    <div class="col-lg-12">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Posts de {{ $selectedChat->title }}</h4>
                                </div>
                                <div class="iq-header-toolbar d-flex align-items-center">
                                    <div class="mr-3">
                                        @if ($messages instanceof \Illuminate\Pagination\AbstractPaginator)
                                            {{ $messages->links('livewire.custom-pagination') }}
                                        @endif
                                    </div>
                                    <input type="text" wire:model.live="messageSearch" class="form-control form-control-sm" placeholder="Buscar mensajes...">
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Parental ID</th>
                                                <th>Fecha</th>
                                                <th>Contenido</th>
                                                <th>Owner</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($messages as $message)
                                                <tr wire:key="msg-{{ $message->id }}">
                                                    <td>{{ $message->message_id }}</td>
                                                    <td>{{ $message->id_message_parent }}</td>
                                                    <td>{{ $message->send_at }}</td>
                                                    <td>
                                                        @if ($message->text)
                                                            {{ $message->text }}
                                                        @endif
                                                        @if ($message->photo)
                                                            <img src="{{ telegram_media_url($message->photo->file_id) }}"
                                                                wire:key="img-{{ $message->id }}"
                                                                alt="Photo" class="img-fluid fullviewer" style="max-width: 160px; max-height: 160px;">
                                                        @endif
                                                        @if ($message->video)
                                                            @php
                                                                $url = telegram_media_url($message->video->file_id);
                                                            @endphp
                                                            @if ($url)
                                                                <video width="320" height="240" controls muted wire:key="vid-{{ $message->id }}">
                                                                    <source src="{{ $url }}" type="video/mp4">
                                                                    Tu navegador no soporta videos.
                                                                </video>
                                                            @else
                                                                <p>Video no disponible</p>
                                                            @endif
                                                        @endif
                                                        @if ($message->captions)
                                                            @foreach ($message->captions as $caption)
                                                                <p>{{ $caption->caption }}</p>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($message->post?->owner)
                                                            <span class="badge badge-success">{{ $message->post->owner->username }}</span>
                                                        @else
                                                            <div class="position-relative">
                                                                @if (isset($selectedOwnerUsername[$message->id]))
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <span class="badge badge-primary">{{ $selectedOwnerUsername[$message->id] }}</span>
                                                                        <button wire:click="assignOwner({{ $message->id }})" class="btn btn-sm btn-success ml-2">
                                                                            Guardar
                                                                        </button>
                                                                        <button wire:click="$set('selectedOwnerUsername.{{ $message->id }}', null)" class="btn btn-sm btn-danger ml-1">
                                                                            <i class="ri-close-line"></i>
                                                                        </button>
                                                                    </div>
                                                                @else
                                                                    <input type="text" 
                                                                        wire:model.live="searchOwner.{{ $message->id }}" 
                                                                        class="form-control form-control-sm" 
                                                                        placeholder="Buscar owner...">
                                                                    
                                                                    @if (!empty($searchResults[$message->id] ?? []))
                                                                        <ul class="list-group position-absolute w-100" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                                                            @foreach ($searchResults[$message->id] as $owner)
                                                                                <li class="list-group-item list-group-item-action py-1 px-2" 
                                                                                    style="cursor: pointer;"
                                                                                    wire:click="selectOwner({{ $message->id }}, {{ $owner['id'] }}, '{{ $owner['username'] }}')">
                                                                                    <small>{{ $owner['username'] }} ({{ $owner['name'] }})</small>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </td>
                                                    {{-- <td>
                                                        <button wire:click="viewPost({{ $post->id }})"
                                                            class="btn btn-primary btn-sm">Ver</button>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @if ($messages instanceof \Illuminate\Pagination\AbstractPaginator)
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $messages->links('livewire.custom-pagination') }}
                                    </div>
                                    <div class="text-secondary small">
                                        Mostrando {{ $messages->firstItem() }} a {{ $messages->lastItem() }} de {{ $messages->total() }} resultados
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>