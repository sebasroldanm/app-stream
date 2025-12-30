<?php

namespace App\Services\Owner;

use App\Jobs\Processing\ProcessVideo;
use App\Models\Log;
use Illuminate\Support\Facades\Bus;

class OwnerVideoSyncService
{
    protected OwnerApiClient $apiClient;

    public function __construct(OwnerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function syncVideo($id_owner, $username)
    {
        try {
            $path = '/api/front/v2/users/username/' . $username . '/videos';
            
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
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
        }
    }
}
