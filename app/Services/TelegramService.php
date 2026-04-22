<?php

namespace App\Services;

use App\Models\TelegramCaption;
use App\Models\TelegramMessage;
use Illuminate\Support\Facades\DB;

class TelegramService
{
    /**
     * Parse entities from text.
     *
     * @param string $text
     * @param array $entities
     * @return array
     */
    public function parseEntities($text, $entities)
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

    /**
     * Update captions for a telegram message.
     *
     * @param TelegramMessage $telegramMessage
     * @param array $parsed
     * @return void
     */
    public function updateCaptions(TelegramMessage $telegramMessage, array $parsed)
    {
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
    }
}
