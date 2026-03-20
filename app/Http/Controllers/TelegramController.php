<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function proxy($fileId)
    {
        // 1. Obtener la ruta real (esto es interno, el usuario no lo ve)
        $file = Telegram::getFile(['file_id' => $fileId]);
        $token = config('telegram.bots.mybot.token');
        $realUrl = "https://api.telegram.org/file/bot{$token}/" . $file->getFilePath();

        // 2. Hacer el proxy del contenido
        $response = Http::get($realUrl);

        if ($response->successful()) {
            return response($response->body())
                ->header('Content-Type', $response->header('Content-Type'))
                ->header('Cache-Control', 'public, max-age=86400'); // Cache por 24h para no saturar
        }

        abort(404);
    }
}
