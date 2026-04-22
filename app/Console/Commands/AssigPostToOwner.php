<?php

namespace App\Console\Commands;

use App\Models\Owner;
use App\Models\Post;
use App\Models\TelegramChat;
use App\Models\TelegramMessage;
use App\Traits\SyncData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AssigPostToOwner extends Command
{
    use SyncData;

    protected $signature = 'app:assig-post-to-owner';

    protected $description = 'Command description';

    public function handle()
    {
        $chats = TelegramChat::all(['id', 'title']);

        if ($chats->isEmpty()) {
            $this->error('No hay chats registrados en la base de datos.');
            return;
        }

        $options = $chats->mapWithKeys(function ($chat) {
            return [$chat->id => "ID: {$chat->id} | {$chat->title}"];
        })->toArray();

        $selection = $this->choice(
            'Seleccione el Chat de Telegram:',
            $options,
            null
        );

        $chatId = array_search($selection, $options);
        $chat = TelegramChat::find($chatId);

        $this->info("Chat seleccionado: {$chat->title}");

        $this->info('Buscando mensajes sin asociaciones...');

        $messages = TelegramMessage::with('captions')
            ->where('fk_telegram_chats_id', $chat->id)
            ->whereDoesntHave('post')
            ->whereHas('captions', function ($query) {
                $query->where('caption', '#stripchat');
            })
            ->get();

        $excludeCaptions = explode(',', env('TELEGRAM_EXCLUDE_CAPTION'));

        $errors = [];

        $bar = $this->output->createProgressBar($messages->count());
        $bar->setFormatDefinition(
            'custom',
            '%current%/%max% [%bar%] %percent:3s%% | Transcurrido: %elapsed:6s% | Restante: %remaining:6s% | Mem: %memory:6s%'
        );
        $bar->setFormat('custom');
        $bar->start();

        foreach ($messages as $message) {

            try {

                $captionsArray = $message->captions
                    ->whereNotIn('caption', $excludeCaptions)
                    ->pluck('caption')
                    ->toArray();

                $ownerCaption = $captionsArray[0] ?? null;

                if ($ownerCaption) {
                    $ownerCaption = implode(' ', $captionsArray);
                    $username = str_replace('#', '', $ownerCaption);
                    $username = str_replace(' ', '', $username);

                    $owner = Cache::remember("owner_user_{$username}", now()->addMinutes(5), function () use ($username) {
                        return Owner::where('username', $username)->first();
                    });

                    if (!$owner) {
                        $synced = $this->syncOwnerByUsername($username);

                        if ($synced) {
                            $owner = ($synced instanceof Owner) ? $synced : Owner::where('username', $username)->first();

                            if ($owner) {
                                Cache::put("owner_user_{$username}", $owner, now()->addMinutes(5));
                            }
                        }
                    }

                    if (!$owner) {
                        // Guardar en array el owner sin repetir
                        $errors[$username] = $username;
                        continue;
                    }

                    if ($message->id_message_parent) {
                        $messages_id = TelegramMessage::where('id_message_parent', $message->id_message_parent)->pluck('id')->toArray();
                    } else {
                        $messages_id = [$message->id];
                    }

                    foreach ($messages_id as $message_id) {
                        $post = Post::where('fk_telegram_messages_id', $message_id)->first();
                        if ($post) {
                            continue;
                        }
                        $post = Post::create([
                            'fk_owners_id' => $owner->id,
                            'fk_telegram_messages_id' => $message_id,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                $exceptions[] = $e->getMessage();
            } finally {
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->info('Proceso finalizado.');

        if (!empty($errors)) {
            foreach ($errors as $user) {
                Log::error("Error: El usuario '{$user}' no pudo ser sincronizado.");
            }
        }

        if (!empty($exceptions)) {
            foreach ($exceptions as $exception) {
                Log::error("Error: {$exception}");
            }
        }
    }
}
