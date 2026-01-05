<?php

namespace App\Services\Owner;
 
use App\Services\Logger\ServiceLogger;

class OwnerSearchService
{
    protected OwnerApiClient $apiClient;
    protected ServiceLogger $logger;

    public function __construct(OwnerApiClient $apiClient, ServiceLogger $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function searchGlobal($keyword)
    {
        $path = '/api/front/v4/models/search/suggestion';
        $query = [
            'query' => $keyword,
            'primaryTag' => 'girls'
        ];

        try {
            // Logic from SyncData::searchGlobal
            $response = $this->apiClient->get($path, ['query' => $query]);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
                $data = json_decode($content, false);
                return $data;
            }
        } catch (\Throwable $th) {
             $this->logger->logError(
                 'service/owner_search',
                 $th->getMessage(),
                 ['path' => $path, 'query' => $query],
                 [],
                 $th->getTraceAsString()
             );
        }
        return null;
    }
}
