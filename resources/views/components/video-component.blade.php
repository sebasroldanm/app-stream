@props(['poster', 'video', 'format' => null, 'minHeight' => '240px'])

@php
    /**
     * Intentar detectar el formato si no se proporciona.
     * Soporta .mp4 y .m3u8 (HLS).
     */
    if (!$format) {
        $extension = strtolower(pathinfo($video, PATHINFO_EXTENSION));
        // Algunos URLs pueden no tener extensión clara, buscamos fragmentos
        if (str_contains($video, '.m3u8')) {
            $format = 'm3u8';
        } elseif (str_contains($video, '.mp4')) {
            $format = 'mp4';
        } else {
            $format = $extension ?: 'mp4'; 
        }
    }
@endphp

<div 
    class="video-component-wrapper position-relative overflow-hidden rounded bg-dark shadow-sm" 
    style="cursor: pointer; aspect-ratio: 16/9; transition: transform 0.2s ease-in-out; width: 100%; min-height: {{ $minHeight }};"
    onclick="initVideoComponent(this, '{{ $video }}', '{{ $format }}')"
>
    <!-- Imagen de vista previa (Poster) -->
    <img 
        src="{{ $poster }}" 
        alt="Video Preview" 
        class="video-component-poster w-100 h-100 object-fit-cover"
        style="display: block; transition: filter 0.3s ease;"
        loading="lazy"
    >

    <!-- Overlay de Reproducción -->
    <div class="video-component-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center transition-all" style="background-color: rgba(0,0,0,0.1);">
        <div class="video-play-icon-container rounded-circle bg-white bg-opacity-75 d-flex align-items-center justify-content-center shadow-lg" style="width: 54px; height: 54px; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
            <i class="ri-play-fill text-dark" style="font-size: 2rem; margin-left: 0px;"></i>
        </div>
    </div>

    <!-- Estilos locales para efectos -->
    <style>
        .video-component-wrapper:not([data-initialized="true"]):hover {
            transform: scale(1.01);
        }
        .video-component-wrapper:hover .video-component-overlay {
            background-color: rgba(0, 0, 0, 0.4) !important;
        }
        .video-component-wrapper:hover .video-play-icon-container {
            transform: scale(1.15);
            background-color: #fff !important;
        }
        .video-component-wrapper:hover .video-component-poster {
            filter: brightness(0.7);
        }
    </style>
</div>
