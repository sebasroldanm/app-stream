<?php

namespace App\Services\Owner;

use App\Jobs\Processing\ProcessPanel;
use App\Services\Logger\ServiceLogger;
use Illuminate\Support\Facades\Bus;

class OwnerPanelSyncService
{
    protected OwnerApiClient $apiClient;
    protected ServiceLogger $logger;

    public function __construct(OwnerApiClient $apiClient, ServiceLogger $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function syncPanelByOwnerId($id)
    {
        $path = '/api/front/users/' . $id . '/panels';
        
        try {
            $response = $this->apiClient->get($path);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
                $data = json_decode($content, true);
                
                if (isset($data["panels"])) {
                    $panels = $data["panels"];
                    if (count($panels) > 0) {
                        foreach ($panels as $panelData) {
                            ProcessPanel::dispatchSync($panelData, $id);
                        }
                    }
                }
                return true;
            }
        } catch (\Throwable $th) {
            $this->logger->logError(
                'service/owner_panel_sync',
                $th->getMessage(),
                ['path' => $path],
                [],
                $th->getTraceAsString()
            );
        }
        return false;
    }
}
