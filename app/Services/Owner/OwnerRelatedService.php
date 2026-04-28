<?php

namespace App\Services\Owner;

use App\Services\Logger\ServiceLogger;
use Illuminate\Support\Facades\Cache;

class OwnerRelatedService
{
    protected OwnerApiClient $apiClient;
    protected ServiceLogger $logger;

    public function __construct(OwnerApiClient $apiClient, ServiceLogger $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    /**
     * Get related owners for a given username.
     *
     * @param string $username
     * @param int $limit
     * @param int $offset
     * @param int $cacheTtl Cache duration in seconds
     * @return mixed
     */
    public function getRelated(string $username, int $limit = 30, int $offset = 0, int $cacheTtl = 60)
    {
        $path = '/api/front/models/username/' . $username . '/related';
        $query = [
            'limit' => $limit,
            'offset' => $offset,
            'primaryTag' => 'girls',
        ];

        try {
            return Cache::remember('related_' . $username, $cacheTtl, function () use ($path, $query) {
                $response = $this->apiClient->get($path, ['query' => $query]);
                $statusCode = $response->getStatusCode();

                if ($statusCode === 200) {
                    $content = $response->getBody()->getContents();
                    return json_decode($content, false);
                }

                return null;
            });
        } catch (\Throwable $th) {
            $this->logger->logError(
                'service/owner_related',
                $th->getMessage(),
                ['path' => $path, 'query' => $query],
                [],
                $th->getTraceAsString()
            );
            return null;
        }
    }
}
