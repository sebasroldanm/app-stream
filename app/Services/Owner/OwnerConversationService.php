<?php

namespace App\Services\Owner;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageMedia;
use App\Models\MessageMediaPhoto;
use App\Models\MessageMediaVideo;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Traits\SyncData;

class OwnerConversationService
{
    use SyncData;

    public function __construct(
        protected OwnerApiClient $apiClient,
    ) {}
    // ==========================================
    // SYNC DATA (APIs -> DB)
    // ==========================================

    public function syncConversations($user_id, $offset = 0, $limit = 10)
    {
        $client = new Client([
            'verify' => false,
            'timeout' => 15,
        ]);

        $url = env('API_SERVER') . '/api/front/v2/users/' . $user_id . '/conversations';
        $query = [
            'offset' => $offset,
            'limit' => $limit,
            'uniq'   => 'f0h9ck6ub3vra2t1',
        ];

        $response = $client->get($url, [
            'headers' => [
                'accept'        => 'application/json, text/plain, */*',
                'user-agent'    => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'front-version' => '11.4.72',
                'cookie'        => env('COOKIE_SERVER'),
            ],
            'query' => $query
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $conversationsApi = $data['conversations'] ?? [];

        if (!empty($conversationsApi)) {
            $toInsert = [];
            foreach ($conversationsApi as $conv) {
                $conversationId = $conv['counterpartId'];

                $toInsert[] = [
                    'id' => $conversationId,
                    'counterpartId' => $conv['counterpartId'] ?? null,
                    'unread' => $conv['unread'] ?? 0,
                    'isBookmark' => $conv['isBookmark'] ?? false,
                    'hasTokens' => $conv['hasTokens'] ?? false,
                    'hasUnreadWithTokens' => $conv['hasUnreadWithTokens'] ?? false,
                    'lastMessage' => Carbon::parse($conv['message']['createdAt'])->subHours(5)->toDateTimeString(),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $toInsert = array_filter($toInsert, fn($item) => !is_null($item['id']));

            if (!empty($toInsert)) {
                Conversation::upsert(
                    $toInsert,
                    ['id'],
                    ['unread', 'isBookmark', 'hasTokens', 'hasUnreadWithTokens', 'updated_at']
                );
            }
        }

        return $this->getConversations($offset, $limit);
    }

    public function syncMessages($cookieClient, $idMessage, $beforeIdMessage = null, ?Carbon $syncTimestamp = null)
    {
        $query = ['offset' => 0, 'limit' => 10, 'uniq' => 'f0h9ck6ub3vra2t1'];

        if ($beforeIdMessage) {
            $query['beforeMassMessageId'] = $beforeIdMessage;
        }

        $client = new Client([
            'verify' => false,
            'timeout' => 15,
        ]);

        $url = env('API_SERVER') . '/api/front/v2/users/' . $cookieClient . '/conversations' . '/' . $idMessage;
        $query = [
            'offset' => 0,
            'limit' => 10,
            'uniq'   => 'f0h9ck6ub3vra2t1',
        ];

        if ($beforeIdMessage) {
            $query['beforeMassMessageId'] = $beforeIdMessage;
        }

        $response = $client->get($url, [
            'headers' => [
                'accept'        => 'application/json, text/plain, */*',
                'user-agent'    => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'front-version' => '11.4.72',
                'cookie' => env('COOKIE_SERVER'),
            ],
            'query' => $query
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $messagesApi = $data['messages'] ?? [];

        $this->syncOwnerByUsername($data['model']['username']);
        Conversation::where('id', $data['model']['id'])->update([
            'metadataFriendship' => json_encode($data['friendship']),
            'metadataOwner' => json_encode($data['model']),
        ]);

        if (!empty($messagesApi)) {
            Conversation::firstOrCreate(
                ['id' => $idMessage],
                [
                    'counterpartId' => $idMessage,
                    'unread' => 0,
                    'isBookmark' => false,
                    'hasTokens' => false,
                    'hasUnreadWithTokens' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $toInsert = [];
            foreach ($messagesApi as $msg) {
                $toInsert[] = [
                    'id' => $msg['id'],
                    'conversation_id' => $idMessage,
                    'kind' => $msg['kind'] ?? null,
                    'createdAt' => isset($msg['createdAt']) ? Carbon::parse($msg['createdAt'])->subHours(5)->toDateTimeString() : null,
                    'senderId' => $msg['senderId'] ?? null,
                    'recipientId' => $msg['recipientId'] ?? null,
                    'type' => $msg['type'] ?? null,
                    'body' => $msg['body'] ?? null,
                    'mediaType' => $msg['mediaType'] ?? null,
                    'mediaId' => isset($msg['mediaId']) ? json_encode($msg['mediaId']) : null,
                    'isRead' => $msg['isRead'] ?? false,
                    'created_at' => now(),
                    'updated_at' => $syncTimestamp ?? now(),
                ];
            }

            if (!empty($toInsert)) {
                Message::upsert(
                    $toInsert,
                    ['id'],
                    ['kind', 'type', 'body', 'mediaType', 'mediaId', 'isRead', 'updated_at']
                );
            }

            $toInsertMedia  = [];
            $toInsertPhotos = [];
            $toInsertVideos = [];

            $mapPhoto = function (array $photo, int $mediaId) use (&$toInsertPhotos) {
                $toInsertPhotos[] = [
                    'id'                   => $photo['id'],
                    'message_media_id'     => $mediaId,
                    'createdAt'            => isset($photo['createdAt']) ? Carbon::parse($photo['createdAt'])->subHours(5)->toDateTimeString() : null,
                    'isDeleted'            => $photo['isDeleted'] ?? false,
                    'albumId'              => $photo['albumId'] ?? null,
                    'aspectRatio'          => $photo['aspectRatio'] ?? null,
                    'order'                => $photo['order'] ?? null,
                    'status'               => $photo['status'] ?? null,
                    'urlThumbMicro'        => $photo['urlThumbMicro'] ?? null,
                    'isNew'                => $photo['isNew'] ?? false,
                    'primaryColor'         => $photo['primaryColor'] ?? null,
                    'source'               => $photo['source'] ?? null,
                    'isNudeContent'        => $photo['isNudeContent'] ?? null,
                    'isInCollection'       => $photo['isInCollection'] ?? false,
                    'isUnderPreModeration' => $photo['isUnderPreModeration'] ?? false,
                    'rejectReason'         => $photo['rejectReason'] ?? null,
                    'url'                  => $photo['url'] ?? null,
                    'urlThumb'             => $photo['urlThumb'] ?? null,
                    'urlPreview'           => $photo['urlPreview'] ?? null,
                    'isBought'             => $photo['isBought'] ?? false,
                    'type'                 => $photo['type'] ?? 'photo',
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ];
            };

            $mapVideo = function (array $video, int $mediaId) use (&$toInsertVideos) {
                $toInsertVideos[] = [
                    'id'               => $video['id'],
                    'message_media_id' => $mediaId,
                    'createdAt'        => isset($video['createdAt']) ? Carbon::parse($video['createdAt'])->subHours(5)->toDateTimeString() : null,
                    'isDeleted'        => $video['isDeleted'] ?? false,
                    'userId'           => $video['userId'] ?? null,
                    'title'            => $video['title'] ?? null,
                    'description'      => $video['description'] ?? null,
                    'cost'             => $video['cost'] ?? 0,
                    'minFanClubTier'   => $video['minFanClubTier'] ?? null,
                    'accessMode'       => $video['accessMode'] ?? null,
                    'duration'         => $video['duration'] ?? null,
                    'presets'          => isset($video['presets']) ? json_encode($video['presets']) : null,
                    'trailerUrl'       => $video['trailerUrl'] ?? null,
                    'coverUrl'         => $video['coverUrl'] ?? null,
                    'microCoverUrl'    => $video['microCoverUrl'] ?? null,
                    'fullCoverUrl'     => $video['fullCoverUrl'] ?? null,
                    'viewsCount'       => $video['viewsCount'] ?? 0,
                    'showId'           => $video['showId'] ?? null,
                    'streamSpecificId' => $video['streamSpecificId'] ?? null,
                    'type'             => $video['type'] ?? 'video',
                    'likes'            => $video['likes'] ?? 0,
                    'liked'            => $video['liked'] ?? false,
                    'isInCollection'   => $video['isInCollection'] ?? false,
                    'isIntro'          => $video['isIntro'] ?? false,
                    'introUrls'        => isset($video['introUrls']) ? json_encode($video['introUrls']) : null,
                    'isHls'            => $video['isHls'] ?? false,
                    'isDvr'            => $video['isDvr'] ?? false,
                    'isVr'             => $video['isVr'] ?? false,
                    'isPixelated'      => $video['isPixelated'] ?? false,
                    'vrCameraSettings' => isset($video['vrCameraSettings']) ? json_encode($video['vrCameraSettings']) : null,
                    'isXConverter'     => $video['isXConverter'] ?? false,
                    'aspectRatio'      => $video['aspectRatio'] ?? null,
                    'primaryColor'     => $video['primaryColor'] ?? null,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            };

            foreach ($messagesApi as $msg) {
                $media = $msg['media'] ?? null;
                if (!$media) continue;

                $mediaId   = $media['id'] ?? null;
                $mediaType = $media['type'] ?? null;
                if (!$mediaId) continue;

                $toInsertMedia[] = [
                    'id'         => $mediaId,
                    'message_id' => $msg['id'],
                    'accessMode' => $media['accessMode'] ?? null,
                    'cost'       => $media['cost'] ?? 0,
                    'isDeleted'  => $media['isDeleted'] ?? false,
                    'type'       => $mediaType,
                    'boughtAt'   => $media['boughtAt'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if ($mediaType === 'photo' && isset($media['photo'])) {
                    $mapPhoto($media['photo'], $mediaId);
                } elseif ($mediaType === 'video' && isset($media['video'])) {
                    $mapVideo($media['video'], $mediaId);
                } elseif ($mediaType === 'mixed' && isset($media['mixed'])) {
                    foreach ($media['mixed'] as $item) {
                        $itemType = $item['type'] ?? null;
                        if ($itemType === 'photo') {
                            $mapPhoto($item, $mediaId);
                        } elseif ($itemType === 'video') {
                            $mapVideo($item, $mediaId);
                        }
                    }
                }
            }


            if (!empty($toInsertMedia)) {
                MessageMedia::upsert(
                    $toInsertMedia,
                    ['id'],
                    ['accessMode', 'cost', 'isDeleted', 'type', 'boughtAt', 'updated_at']
                );
            }

            if (!empty($toInsertPhotos)) {
                MessageMediaPhoto::upsert(
                    $toInsertPhotos,
                    ['id'],
                    ['status', 'url', 'urlThumb', 'urlPreview', 'isBought', 'isDeleted', 'updated_at']
                );
            }

            if (!empty($toInsertVideos)) {
                MessageMediaVideo::upsert(
                    $toInsertVideos,
                    ['id'],
                    ['title', 'coverUrl', 'viewsCount', 'likes', 'liked', 'isDeleted', 'updated_at']
                );
            }
        }

        return $this->getIdFirstMessage($idMessage, $syncTimestamp)->id ?? 0;
    }

    // ==========================================
    // GET DATA (DB -> Frontend)
    // ==========================================

    public function getConversations($offset = 0, $limit = 10)
    {
        return Conversation::orderBy('updated_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();
    }

    public function getIdFirstMessage($conversationId, ?Carbon $syncTimestamp = null)
    {
        return Message::where('conversation_id', $conversationId)
            ->when($syncTimestamp, fn($q) => $q->where('updated_at', $syncTimestamp))
            ->orderBy('id', 'asc')
            ->first();
    }
}
