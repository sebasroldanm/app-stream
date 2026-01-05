<?php

namespace App\Services\Owner;

use App\Models\Intro;
use App\Services\Logger\ServiceLogger;

class OwnerIntroSyncService
{
    protected OwnerApiClient $apiClient;
    protected ServiceLogger $logger;

    public function __construct(OwnerApiClient $apiClient, ServiceLogger $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function syncIntroByOwnerId($id)
    {
        $path = '/api/front/users/' . $id . '/intros';
        
        try {
            $response = $this->apiClient->get($path);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
                if (empty($content)) {
                    return false;
                }
                $data = json_decode($content, true);
                
                $intro = Intro::find($data["id"]);
                if (!$intro) {
                    $intro = new Intro();
                    $intro->id = $data["id"];
                }
                $intro->type = $data["type"];
                $intro->url = $data[$data["type"]]["url"];
                $intro->data = $content;
                $intro->owner_id = $id;
                $intro->save();

                // Image/Video saving commented out in original
            }
        } catch (\Throwable $th) {
            $this->logger->logError(
                'service/owner_intro_sync',
                $th->getMessage(),
                ['path' => $path],
                [],
                $th->getTraceAsString()
            );
        }
    }
}
