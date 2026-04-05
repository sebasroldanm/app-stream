<?php

namespace App\Console\Commands;

use App\Models\TelegramCaption;
use App\Models\TelegramChat;
use App\Models\TelegramMessage;
use App\Models\TelegramPhoto;
use App\Models\TelegramVideo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Laravel\Facades\Telegram;

class MigrateTelegramMessages extends Command
{
    protected $signature = 'app:migrate-telegram-messages';

    protected $description = 'Migrate a Telegram messages to the database via interactive text input';

    public function handle()
    {
        $this->comment('Migra mensajes de un chat específico mediante un intervalo definido de IDs (inicio y fin).');

        $chat_id = $this->ask('Ingrese el ID del Chat (ID del chat donde se enviará el mensaje)');
        $from_chat_id = $this->ask('Ingrese el ID del Chat de origen (ID del chat donde está el mensaje)');
        $starter = $this->ask('Ingrese el ID del Mensaje Inicial');
        $end = $this->ask('Ingrese el ID del Mensaje Final');

        $chat = TelegramChat::where('username', $from_chat_id)->first();

        if (!$chat) {
            echo ('Chat no encontrado');
            return;
        }

        $last_message_id = TelegramMessage::where('fk_telegram_chats_id', $chat->id)
            ->max('message_id');

        $init = max($starter, ($last_message_id ?? 0) + 1);

        if ($init > $end) {
            echo ('Rango ya procesado completamente.');
            return;
        }

        $rows = [];

        $bar = $this->output->createProgressBar($end - $init + 1);
        $bar->setFormatDefinition(
            'custom',
            '%current%/%max% [%bar%] %percent:3s%% | Transcurrido: %elapsed:6s% | Restante: %remaining:6s% | Mem: %memory:6s%'
        );
        $bar->setFormat('custom');
        $bar->start();

        for ($i = $init; $i <= $end; $i++) {
            try {
                $message = Telegram::forwardMessage([
                    'chat_id' => $chat_id,
                    'from_chat_id' => '@' . $from_chat_id,
                    'message_id' => $i
                ]);

                $content = $message->getCaption();
                $entities = $message->getCaptionEntities();

                $telegramMessage = TelegramMessage::updateOrCreate([
                    'fk_telegram_chats_id' => $chat->id,
                    'message_id' => $i,
                ], [
                    'text' => $message->getText(),
                    'send_at' => Carbon::parse($message->getForwardDate()),
                ]);

                if ($content) {
                    $parsed = $this->parseEntities($content, $entities);
                } elseif ($message->has('text')) {
                    $parsed = $this->parseEntities($message->getText(), $message->getEntities());
                } else {
                    $parsed = [];
                }

                DB::transaction(function () use ($telegramMessage, $parsed) {

                    $positions = [];

                    foreach ($parsed as $index => $item) {

                        $positions[] = $index;

                        TelegramCaption::updateOrCreate(
                            [
                                'fk_telegram_messages_id' => $telegramMessage->id,
                                'position' => $index,
                            ],
                            [
                                'caption' => $item['content'],
                                'type' => $item['type'],
                                'offset' => $item['offset'] ?? null,
                                'length' => $item['length'] ?? null,
                            ]
                        );
                    }

                    // Delete those that no longer exist
                    TelegramCaption::where('fk_telegram_messages_id', $telegramMessage->id)
                        ->whereNotIn('position', $positions)
                        ->delete();
                });

                if ($message->has('photo') || $message->has('video')) {
                    if ($message->has('photo')) {
                        $last_message = TelegramMessage::where('fk_telegram_chats_id', $chat->id)
                            ->where('send_at', $telegramMessage->send_at)
                            ->first();

                        // if parent or set parent
                        if (
                            $last_message &&
                            $last_message->photo
                        ) {
                            $telegramMessage->update([
                                'id_message_parent' => $last_message->id,
                            ]);
                        } else {
                            $telegramMessage->update([
                                'id_message_parent' => $telegramMessage->id,
                            ]);
                        }

                        $data = [
                            'file_id' => $message->getPhoto()->last()->getFileId(),
                            'file_unique_id' => $message->getPhoto()->last()->getFileUniqueId(),
                            'width' => $message->getPhoto()->last()->getWidth(),
                            'height' => $message->getPhoto()->last()->getHeight(),
                        ];

                        TelegramPhoto::updateOrCreate([
                            'fk_telegram_messages_id' => $telegramMessage->id,
                        ], $data);
                    } else {
                        $data = [
                            'duration' => $message->getVideo()->getDuration(),
                            'width' => $message->getVideo()->getWidth(),
                            'height' => $message->getVideo()->getHeight(),
                            'file_name' => $message->getVideo()->getFileName(),
                            'mime_type' => $message->getVideo()->getMimeType(),
                            'file_id' => $message->getVideo()->getFileId(),
                            'file_unique_id' => $message->getVideo()->getFileUniqueId(),
                            'file_size' => $message->getVideo()->getFileSize(),
                            'thumbnail_file_id' => $message->getVideo()->getThumbnail()->getFileId(),
                            'thumbnail_file_unique_id' => $message->getVideo()->getThumbnail()->getFileUniqueId(),
                            'thumbnail_file_size' => $message->getVideo()->getThumbnail()->getFileSize(),
                            'thumbnail_width' => $message->getVideo()->getThumbnail()->getWidth(),
                            'thumbnail_height' => $message->getVideo()->getThumbnail()->getHeight(),
                            'thumb_file_id' => $message->getVideo()->getThumb()->getFileId(),
                            'thumb_file_unique_id' => $message->getVideo()->getThumb()->getFileUniqueId(),
                            'thumb_file_size' => $message->getVideo()->getThumb()->getFileSize(),
                            'thumb_width' => $message->getVideo()->getThumb()->getWidth(),
                            'thumb_height' => $message->getVideo()->getThumb()->getHeight(),
                        ];

                        TelegramVideo::updateOrCreate([
                            'fk_telegram_messages_id' => $telegramMessage->id,
                        ], $data);
                    }
                }
            } catch (\Exception $e) {
                $rows[] = [$i, $e->getMessage()];
            } finally {
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine(2);

        if (count($rows) > 0) {
            $this->error('Se encontraron los siguientes problemas:');
            $this->table(['ID Mensaje', 'Error / Estado'], $rows);
        } else {
            $this->info('¡Migración completada con éxito absoluto! 0 errores.');
        }
    }


    private function parseEntities($text, $entities)
    {
        $result = [];
        $pointer = 0;

        foreach ($entities as $entity) {
            $offset = $entity['offset'];
            $length = $entity['length'];
            $type = $entity['type'];

            if ($offset > $pointer) {
                $result[] = [
                    'type' => 'text',
                    'content' => mb_substr($text, $pointer, $offset - $pointer),
                    'offset' => $pointer,
                    'length' => $offset - $pointer,
                ];
            }

            $result[] = [
                'type' => $type,
                'content' => mb_substr($text, $offset, $length),
                'offset' => $offset,
                'length' => $length,
            ];

            $pointer = $offset + $length;
        }

        if ($pointer < mb_strlen($text)) {
            $result[] = [
                'type' => 'text',
                'content' => mb_substr($text, $pointer),
                'offset' => $pointer,
                'length' => mb_strlen($text) - $pointer,
            ];
        }

        return $result;
    }
}
