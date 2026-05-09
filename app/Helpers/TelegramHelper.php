<?php

if (!function_exists('telegram_media_url')) {
    function telegram_media_url($fileId) {
        return route('telegram.proxy', ['fileId' => $fileId]);
    }
}