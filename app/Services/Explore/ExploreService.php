<?php

namespace App\Services\Explore;

use App\Jobs\JobSaveSearchResults;
use App\Services\Owner\OwnerApiClient;

class ExploreService
{
    /**
     * Create a new service instance.
     *
     * @param OwnerApiClient $apiClient
     */
    public function __construct(protected OwnerApiClient $apiClient) {}

    /**
     * Get models from the API.
     *
     * @param int $limit
     * @param int $offset
     * @param array $filterTags
     * @param string $parentTag
     * @return object|bool
     */
    public function filterSearch(int $limit, int $offset, array $filterTags = [], string $parentTag = 'mobile')
    {
        try {
            $response = $this->apiClient->get('/api/front/models', [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'primaryTag' => 'girls',
                    'filterGroupTags' => json_encode($filterTags),
                    'sortBy' => 'trending',
                    'parentTag' => $parentTag,
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $data = json_decode($response->getBody()->getContents(), false);
                
                if (isset($data->models) && is_array($data->models)) {
                    JobSaveSearchResults::dispatch($data->models)->onQueue('low');
                }

                return $data;
            }

            return false;
        } catch (\Throwable $th) {
            // Error is already logged by OwnerApiClient
            return false;
        }
    }
}
