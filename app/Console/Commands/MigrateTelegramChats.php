<?php

namespace App\Console\Commands;

use App\Models\TelegramChat;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class MigrateTelegramChats extends Command
{
    protected $signature = 'app:migrate-telegram-chats';

    protected $description = 'Migrate a Telegram chat to the database via interactive text input';

    public function handle()
    {
        try {
            $chat_id = $this->ask('Ingrese el ID del Chat (ID del chat donde se enviará el mensaje)');
            $from_chat_id = $this->ask('Ingrese el ID del Chat de origen (ID del chat donde está el mensaje)');
            $message_id = $this->ask('Ingrese el ID del mensaje a enviar');

            if (!$chat_id || !$from_chat_id || !$message_id) {
                $this->error('Todos los campos son obligatorios.');
                return;
            }

            $this->info("Procesando reenvío...");

            $message = Telegram::forwardMessage([
                'chat_id' => $chat_id,
                'from_chat_id' => $from_chat_id,
                'message_id' => $message_id
            ]);

            $origin = TelegramChat::where('chat_id', $from_chat_id)->first();

            if (!$origin) {
                $forwardedChat = $message->getForwardFromChat();
                
                if (!$forwardedChat) {
                    $this->error('No se pudo obtener la información del chat de origen desde el reenvío.');
                    return;
                }

                $origin = TelegramChat::create([
                    'chat_id'  => $forwardedChat->getId(),
                    'title'    => $forwardedChat->getTitle(),
                    'username' => $forwardedChat->getUsername(),
                    'type'     => $forwardedChat->getType()
                ]);

                if ($origin) {
                    $this->info('Chat creado en la base de datos exitosamente.');
                } else {
                    $this->error('Error al intentar guardar el chat en la base de datos.');
                }
            } else {
                $this->info('El chat ya existía en la base de datos.');
            }

            $this->info('Chat migrado/reenviado correctamente.');

        } catch (\Exception $e) {
            $this->error("Ocurrió un error: " . $e->getMessage());
        }
    }
}