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
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
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
                                            <th>Total Mensajes</th>
                                            <th>Último ID mensaje</th>
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
                                                <td>{{ $chat->messages->count() }}</td>
                                                <td>{{ $chat->messages->max('message_id') }}</td>
                                                <td>
                                                    <button wire:click="selectChat({{ $chat->id }})"
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
                                    <h4 class="card-title">Mensajes del Chat {{ $selectedChat->title }}</h4>
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
                                                <th>ID Mensaje</th>
                                                <th>ID Mensaje Padre</th>
                                                <th>Fecha</th>
                                                <th>Contenido</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($messages as $message)
                                                <tr wire:key="msg-{{ $message->id }}">
                                                    <td>{{ $message->id }}</td>
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
                                                                $max_size = 20 * 1024 * 1024;
                                                            @endphp
                                                            @if ($url && $message->video->file_size < $max_size)
                                                                <video width="320" height="240" controls muted wire:key="vid-{{ $message->id }}" data-id="{{ $message->video->id }}">
                                                                    <source src="{{ $url }}" type="video/mp4">
                                                                    Tu navegador no soporta videos.
                                                                </video>
                                                            @else
                                                                <p>Video no disponible {{ number_format($message->video->file_size / 1024 / 1024, 2, ',', '.') }} MB</p>
                                                                <a class="btn btn-primary btn-sm" href="https://t.me/{{ $message->chat->username }}/{{ $message->message_id }}?single" target="_blank">Ver video <i class="fab fa-telegram"></i></a>
                                                            @endif
                                                        @endif
                                                        @if ($message->captions)
                                                            <p>
                                                            @foreach ($message->captions as $caption)
                                                                @if($caption->type == 'hashtag')
                                                                    <span class="fw-bold">{{ $caption->caption }}</span>
                                                                @elseif ($caption->type == 'url')
                                                                    <a href="{{ $caption->url }}" target="_blank">{{ $caption->url }}</a>
                                                                @else
                                                                    {{ $caption->caption }}
                                                                @endif
                                                            @endforeach
                                                            </p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                        @if ($message->post?->owner)
                                                            <a href="{{ route('owner', $message->post->owner->username) }}" target="_blank">
                                                                <span class="badge bg-success">{{ $message->post->owner->username }}</span>
                                                            </a>
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
                                                        </div>
                                                        <hr>
                                                        <div class="d-flex justify-content-center">
                                                            <button 
                                                                wire:click="editCaption({{ $message->id }})"
                                                                class="btn btn-secondary btn-sm">Editar</button>
                                                        </div>
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

    @if ($isModalOpen)
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block; background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Caption</h5>
                        <button type="button" class="close" wire:click="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editingCaption">Contenido del Caption</label>
                            <textarea wire:model="editingCaption" id="editingCaption" class="form-control" rows="6" placeholder="Escribe el nuevo caption..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Cerrar</button>
                        <button type="button" class="btn btn-primary" wire:click="saveCaption" wire:loading.attr="disabled">
                            <span wire:loading wire:target="saveCaption" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>