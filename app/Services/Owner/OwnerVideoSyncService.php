<?php

namespace App\Services\Owner;

use App\Jobs\Processing\ProcessVideo;
use App\Services\Logger\ServiceLogger;
use Illuminate\Support\Facades\Bus;

class OwnerVideoSyncService
{
    protected OwnerApiClient $apiClient;
    protected ServiceLogger $logger;

    public function __construct(OwnerApiClient $apiClient, ServiceLogger $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function syncVideo($id_owner, $username)
    {
        $path = '/api/front/v2/users/username/' . $username . '/videos';
        
        try {
            $response = $this->apiClient->get($path);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
                $data = json_decode($content, true);
                if (isset($data['videos']) && count($data['videos']) > 0) {
                    foreach ($data['videos'] as $videoData) {
                        ProcessVideo::dispatchSync($videoData, $id_owner);
                    }
                }
            }
        } catch (\Throwable $th) {
            $this->logger->logError(
                'service/owner_video_sync',
                $th->getMessage(),
                ['path' => $path],
                [], // Response might not be available here easily unless we capture it before throw? 
                $th->getTraceAsString()
            );
        }
    }
}
