<?php

namespace App\Services\Owner;

use App\Jobs\Processing\ProcessAlbum;
use App\Models\Log;
use Illuminate\Support\Facades\Bus;

class OwnerAlbumSyncService
{
    protected OwnerApiClient $apiClient;

    public function __construct(OwnerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function syncAlbum($id_owner, $username)
    {
        try {
            $path = '/api/front/v2/users/username/' . $username . '/albums';
    
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
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
            return false;
        }
    }
}
