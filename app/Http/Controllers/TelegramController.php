<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function proxy($fileId)
    {
        $cachedData = Cache::remember("telegram_file_{$fileId}", 300, function () use ($fileId) {
            // 1. Obtener la ruta real
            $file = Telegram::getFile(['file_id' => $fileId]);
            $token = config('telegram.bots.mybot.token');
            $realUrl = "https://api.telegram.org/file/bot{$token}/" . $file->getFilePath();

            // 2. Hacer el proxy del contenido
            $response = Http::get($realUrl);

            if ($response->successful()) {
                return [
                    'body' => $response->body(),
                    'type' => $response->header('Content-Type'),
                ];
            }

            return null;
        });

        if ($cachedData) {
            return response($cachedData['body'])
                ->header('Content-Type', $cachedData['type'])
                ->header('Cache-Control', 'public, max-age=300'); // Cache por 5 min
        }

        abort(404);
    }
}
