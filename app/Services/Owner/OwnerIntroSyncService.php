<?php

namespace App\Services\Owner;

use App\Models\Intro;
use App\Models\Log;

class OwnerIntroSyncService
{
    protected OwnerApiClient $apiClient;

    public function __construct(OwnerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function syncIntroByOwnerId($id)
    {
        try {
            $path = '/api/front/users/' . $id . '/intros';
            
            $response = $this->apiClient->get($path);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
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
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
        }
    }
}
