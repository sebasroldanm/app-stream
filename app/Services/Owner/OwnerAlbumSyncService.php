<?php

namespace App\Services\Owner;

use App\Jobs\Processing\ProcessAlbum;
use App\Services\Logger\ServiceLogger;
use Illuminate\Support\Facades\Bus;

class OwnerAlbumSyncService
{
    protected OwnerApiClient $apiClient;
    protected ServiceLogger $logger;

    public function __construct(OwnerApiClient $apiClient, ServiceLogger $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function syncAlbum($id_owner, $username)
    {
        $path = '/api/front/v2/users/username/' . $username . '/albums';

        try {
            $response = $this->apiClient->get($path);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
                $data = json_decode($content, true);
                if (isset($data['albums'])) {
                    $albums = $data['albums'];
                    if (count($albums) > 0) {
                        foreach ($albums as $albumData) {
                            ProcessAlbum::dispatchSync($albumData, $id_owner);
                        }
                    }
                }
                return true;
            }
        } catch (\Throwable $th) {
            $this->logger->logError(
                'service/owner_album_sync',
                $th->getMessage(),
                ['path' => $path],
                [],
                $th->getTraceAsString()
            );
            return false;
        }
    }
}
