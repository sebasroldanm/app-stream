<?php

namespace App\Services\Owner;

use App\Jobs\Processing\ProcessPanel;
use App\Models\Log;
use Illuminate\Support\Facades\Bus;

class OwnerPanelSyncService
{
    protected OwnerApiClient $apiClient;

    public function __construct(OwnerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function syncPanelByOwnerId($id)
    {
        try {
            $path = '/api/front/users/' . $id . '/panels';
            
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
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
        }
        return false;
    }
}
