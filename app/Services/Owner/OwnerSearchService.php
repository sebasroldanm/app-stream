<?php

namespace App\Services\Owner;

use App\Models\Log;

class OwnerSearchService
{
    protected OwnerApiClient $apiClient;

    public function __construct(OwnerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function searchGlobal($keyword)
    {
        try {
            // Logic from SyncData::searchGlobal
            $path = '/api/front/v4/models/search/suggestion';
            $query = [
                'query' => $keyword,
                'primaryTag' => 'girls'
            ];

            $response = $this->apiClient->get($path, ['query' => $query]);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
                $data = json_decode($content, false);
                return $data;
            }
        } catch (\Throwable $th) {
             $log = new Log();
             $log->type = 'error';
             $log->message = $th->getMessage();
             $log->trace = $th->getTraceAsString();
             $log->save();
        }
        return null;
    }
}
