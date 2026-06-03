<?php

namespace App\Services\Owner;

use App\Models\Owner;
use App\Models\SuperChat;
use Carbon\Carbon;
use GuzzleHttp\Client;

class OwnerChatService
{
    public function getChatData(Owner $owner)
    {
        return $this->syncSuperChats($owner);
    }

    public function syncSuperChats(Owner $owner)
    {
        $client = new Client();
        $url = env("API_SERVER") . "/api/front/v2/models/" . $owner->id . "/chat";
        $response = $client->get($url, [
            'verify' => false,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
            ],
            'query' => [
                'source' => 'regular'
            ],
        ]);

        $body = json_decode($response->getBody(), true);
        $messages = $body['messages'] ?? [];

        $newIds = [];
        if (!empty($messages)) {
            $incomingIds = array_column($messages, 'id');
            $existingIds = SuperChat::whereIn('id', $incomingIds)->pluck('id')->toArray();

            $toInsert = [];
            foreach ($messages as $message) {
                if (!in_array($message['id'], $existingIds)) {
                    $newIds[] = $message['id'];
                    $toInsert[] = [
                        'id' => $message['id'],
                        'owner_id' => $owner->id,
                        'createdAt' => Carbon::parse($message['createdAt'])->subHours(5)->toDateTimeString(),
                        'isDeleted' => $message['isDeleted'] ?? false,
                        'cacheId' => $message['cacheId'] ?? null,
                        'type' => $message['type'] ?? 'text',
                        'details' => json_encode($message['details'] ?? []),
                        'userData' => json_encode($message['userData'] ?? []),
                        'additionalData' => json_encode($message['additionalData'] ?? []),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($toInsert)) {
                SuperChat::insertOrIgnore($toInsert);
            }
        }

        $chats = SuperChat::where('owner_id', $owner->id)
            ->where('createdAt', '>=', now()->subHours(24))
            ->orderBy('createdAt', 'desc')
            ->limit(100)
            ->get();

        $chats->each(function ($chat) use ($newIds) {
            $chat->isNew = in_array($chat->id, $newIds);
        });

        return $chats;
    }
}
