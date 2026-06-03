<?php

namespace App\Services\Owner;

use App\Models\Owner;
use App\Models\SuperChat;
use Carbon\Carbon;

class OwnerChatService
{
    protected OwnerApiClient $apiClient;

    public function __construct(OwnerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function getChatData(Owner $owner)
    {
        return $this->syncSuperChats($owner);
    }

    public function syncSuperChats(Owner $owner)
    {
        $uri = '/api/front/v2/models/' . $owner->id . '/chat';

        $response = $this->apiClient->get($uri, [
            'enable_proxy' => false,
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
