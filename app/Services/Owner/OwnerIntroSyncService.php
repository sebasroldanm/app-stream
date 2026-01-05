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

            if ($response->getStatusCode() !== 200) {
                return false;
            }

            $content = $response->getBody()->getContents();

            if ($content === '' || $content === null) {
                return false;
            }

            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->logger->logError(
                    'service/owner_intro_sync_invalid_json',
                    'JSON inválido',
                    ['path' => $path, 'response' => $content]
                );
                return false;
            }

            if ($data === []) {
                return true;
            }

            if (!isset($data['id'], $data['type'])) {
                $this->logger->logError(
                    'service/owner_intro_sync_invalid_structure',
                    'Estructura inesperada',
                    ['path' => $path, 'response' => $data]
                );
                return false;
            }

            $intro = Intro::find($data['id']) ?? new Intro(['id' => $data['id']]);

            $intro->type = $data['type'];
            $intro->url = $data[$data['type']]['url'] ?? null;
            $intro->data = $content;
            $intro->owner_id = $id;

            $intro->save();

            return true;
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
