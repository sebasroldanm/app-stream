<div class="card" wire:poll.5s>
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Chat</h4>
        </div>
    </div>
    <div class="card-body p-1">
        <ul class="iq-timeline ms-1">
            @foreach ($messages as $message)
                <li class="ml-1 {{ $message['isNew'] ? 'newMessage' : '' }}" wire:key="{{ $message['id'] }}">
                    @if ($message['userData']['isModel'] && $message['modelId'] === $message['userData']['id'])
                        @if(isset($message['details']['lovenseDetails']))
                            <div class="timeline-dots border-danger"></div>
                        @elseif(isset($message['details']['goal']))
                            <div class="timeline-dots border-info"></div>
                        @else
                            <div class="timeline-dots border-success"></div>
                        @endif
                    @else
                        <div class="timeline-dots"></div>
                    @endif
                    <div class="d-flex align-items-center justify-content-between">
                         @if (isset($message['details']['isAnonymous']) && $message['details']['isAnonymous'])
                            <h6 class="mb-1">Anonymous</h6>
                        @else
                            <h6 class="mb-1">{{ $message['userData']['username'] ?? 'Anonymous' }}</h6>
                        @endif
                        <a href="{{ route('metadata', ['model' => 'chat', 'id' => base64_encode(json_encode($message))]) }}" target="_blank">
                            <small>{{ $message['elapsedTime'] }}</small>
                        </a>
                    </div>
                    <div class="d-inline-block w-100">
                        {{-- Mensaje owner --}}
                        @if ($message['userData']['isModel'])
                            {{-- Peticion Owner --}}
                            @if(isset($message['details']['goal']))
                                <p>Objetivo: {{ $message['details']['body'] }} - {{ $message['details']['goal'] }}</p>
                            {{-- Respuesta owner --}}
                            @elseif (isset($message['details']['body']))
                                <p>{{ $message['details']['body'] }}</p>
                            {{-- API --}}
                            @elseif(isset($message['details']['lovenseDetails']))
                                @php
                                    $love = $message['details']['lovenseDetails']['detail'];
                                @endphp
                                @if (isset($love['power']))
                                    <p>{{ $love['power'] }}({{ $love['time'] }} sec.) por <bold>{{ $love['name'] }}</bold> - propina {{ $love['amount'] }}</p>
                                @else
                                    <p>Propina {{ $love['amount'] }} ({{ $love['time'] }} sec.) {{ $love['name'] }}</p>
                                @endif
                            {{-- Propina --}}
                            @else
                                <p>Propina {{ $message['details']['amount'] }}</p>
                            @endif
                        {{-- Mensaje Regular --}}
                        @else
                             {{-- Propina --}}
                            @if (isset($message['details']['body']) && $message['details']['body'] == '' && isset($message['details']['amount']))
                                <p>Propina {{ $message['details']['amount'] }}</p>
                            {{-- Nuevo King --}}
                            @elseif(isset($message['type']) && $message['type'] == 'newKing')
                                <p>Nuevo King</p>
                            {{-- Mensaje --}}
                            @else
                                <p>{{ $message['details']['body'] ?? dd($message) }}</p>
                            @endif
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
