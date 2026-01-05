<?php

namespace App\Services\Owner;

use App\Jobs\Processing\ProcessFeedPost;
use App\Services\Logger\ServiceLogger;
use Illuminate\Support\Facades\Bus;

class OwnerFeedSyncService
{
    protected OwnerApiClient $apiClient;
    protected ServiceLogger $logger;

    public function __construct(OwnerApiClient $apiClient, ServiceLogger $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function syncFeedByOwnerId($id)
    {
        // Init next params
        $initNextParams = new class {
            public $createdAt = "2020-01-01T00:00:00Z";
            public $excludeIds = "123456789";
        };

        $path = '/api/front/feed/model/' . $id;

        try {
            $response = $this->apiClient->get($path);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
                // We use false to get objects because ProcessFeedPost expects objects
                $data = json_decode($content, false);
                $nextParams = $data->nextPageParams ?? null;

                // Process first page
                if (isset($data->posts) && count($data->posts) > 0) {
                    $this->dispatchBatch($data->posts, $id, 'Page 1', true);
                }

                if (isset($nextParams->excludeIds)) {
                    $pageCount = 1;
                    while (isset($nextParams->excludeIds) && $nextParams->excludeIds != $initNextParams->excludeIds) {
                        $pageCount++;
                        
                        $path = '/api/front/feed/model/' . $id;
                        $query = [
                            'createdAt' => $nextParams->createdAt,
                            'excludeIds' => $nextParams->excludeIds,
                        ];

                        $response = $this->apiClient->get($path, ['query' => $query]);
                        $content = $response->getBody()->getContents();
                        $data = json_decode($content, false);
                        
                        $initNextParams = $nextParams;
                        $nextParams = $data->nextPageParams ?? null;

                        if (isset($data->posts) && count($data->posts) > 0) {
                            $this->dispatchBatch($data->posts, $id, 'Page ' . $pageCount);
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            $this->logger->logError(
                'service/owner_feed_sync',
                $th->getMessage(),
                ['path' => $path], // Might need query params too for subsequent calls?
                [],
                $th->getTraceAsString()
            );
        }
    }

    private function dispatchBatch($posts, $ownerId, $pageLabel, $isSync = false)
    {
        foreach ($posts as $post) {
            if ($isSync) {
                ProcessFeedPost::dispatchSync($post);
            } else {
                ProcessFeedPost::dispatch($post);
            }
        }
    }
}
