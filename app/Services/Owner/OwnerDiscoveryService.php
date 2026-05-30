<?php

namespace App\Services\Owner;

use App\Services\Logger\ServiceLogger;
use Illuminate\Support\Facades\DB;

class OwnerDiscoveryService
{
    protected OwnerApiClient $apiClient;
    protected ServiceLogger $logger;

    public function __construct(OwnerApiClient $apiClient, ServiceLogger $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    /**
     * Fetch a conversation by ID and persist the owner to test_owner if found.
     *
     * @param  int  $conversationId
     * @return bool  true if an owner was persisted, false otherwise
     */
    public function discoverByConversationId(int $conversationId): bool
    {
        $path = '/api/front/v2/users/142766100/conversations/' . $conversationId;
        $query = [
            'offset' => 0,
            'limit'  => 10,
            'uniq'   => 'f0h9ck6ub3vra2t1',
        ];

        $now = now();

        try {
            $response = $this->apiClient->get($path, [
                'headers' => [
                    'front-version' => '11.4.72',
                ],
                'query' => $query,
            ]);

            if ($response->getStatusCode() !== 200) {
                return false;
            }

            $data = json_decode($response->getBody()->getContents(), true);

            if (empty($data['model'])) {
                return false;
            }

            DB::table('test_owner')->insert([
                'id'         => $data['model']['id'],
                'username'   => $data['model']['username'],
                'avatar'     => $data['model']['avatarUrl'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return true;
        } catch (\Throwable $th) {
            $this->logger->logError(
                'service/owner_discovery',
                $th->getMessage(),
                ['conversation_id' => $conversationId, 'path' => $path],
                [],
                $th->getTraceAsString()
            );

            return false;
        }
    }
}
