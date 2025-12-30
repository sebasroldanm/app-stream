<?php

namespace App\Services\Owner;

use App\Models\Log;
use App\Models\Owner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log as LaravelLog;

class OwnerSyncService
{
    protected OwnerApiClient $apiClient;

    public function __construct(OwnerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function syncOwnerByUsername(string $username)
    {
        try {            
            $path = '/api/front/v2/models/username/' . $username . '/cam';
            
            $response = $this->apiClient->get($path);
            $statusCode = $response->getStatusCode();
            
            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
                $data = json_decode($content, true);
                
                if (isset($data['user']) && isset($data['user']['user'])) {
                    $dataUser = $data['user']['user'];
                    $owner = Owner::find($dataUser['id']);
                    if (!$owner) {
                        $owner = new Owner();
                        $owner->id = $dataUser['id'];
                    }
                    if (empty($dataUser['username'])) {
                        $owner->username = $username;
                        $owner->lastUsername = $this->addUsernameToHistory($owner->lastUsername, $username);
                    } else {
                        $owner->username = $dataUser['username'];
                        $owner->lastUsername = $this->addUsernameToHistory($owner->lastUsername, $dataUser['username']);
                    }
                    $owner->name = $dataUser['name'];
                    $owner->previousUsername = $dataUser['previousUsername'];
                    $owner->avatar = (isset($dataUser['avatarUrlOriginal']) && !empty($dataUser['avatarUrlOriginal'])) ? $dataUser['avatarUrlOriginal'] : $dataUser['avatarUrl'];
                    $owner->preview = $dataUser['previewUrl'];
                    $owner->gender = $dataUser['gender'];
                    $owner->country = $dataUser['country'];
                    $owner->isOnline = $dataUser['isOnline'];
                    $owner->isLive = $dataUser['isLive'];
                    $owner->isMobile = $dataUser['isMobile'];
                    $owner->isDelete = $dataUser['isDeleted'];
                    $owner->bodyType = $dataUser['bodyType'];
                    $owner->eyeColor = $dataUser['eyeColor'];
                    if (is_numeric($dataUser['age'])) {
                        $owner->age = $dataUser['age'];
                        $owner->birthDate = $dataUser['birthDate'];
                    }
                    $owner->favoritedCount = $dataUser['favoritedCount'];
                    $offLineRaw = $dataUser['offlineStatusUpdatedAt'] ?? null;
                    if (empty($offLineRaw) || $offLineRaw === '0000-00-00' || $offLineRaw === '0000-00-00 00:00:00') {
                        $owner->offlineStatusUpdatedAt = Carbon::parse('1970-01-01 00:00:01');
                    } else {
                        $owner->offlineStatusUpdatedAt = Carbon::parse($offLineRaw)->subHours(5);
                    }
                    // Date update platform
                    $statusRaw = $dataUser['statusChangedAt'] ?? null;
                    if (empty($statusRaw) || $statusRaw === '0000-00-00' || $statusRaw === '0000-00-00 00:00:00') {
                        $owner->statusChangedAt = Carbon::parse('1970-01-01 00:00:01');
                    } else {
                        $owner->statusChangedAt = Carbon::parse($statusRaw)->subHours(5);
                    }
                    $owner->data = $content;
                    $owner->save();

                    return $owner->id;
                }
            }
        } catch (\Throwable $th) {
            // Error handling logic from original SyncData
            if (strpos($th->getMessage(), '"code":"500"')) {
                $owner = Owner::where('username', $username)->first();
                if (!$owner) {
                    $owner = new Owner();
                    $owner->username = $username;
                }
                // $owner->isError = true;
                $owner->save();
            }
            if (strpos($th->getMessage(), '"newUsername"')) {
                $body = (string) $th->getMessage();
                $body = trim($body);
                $body = explode("\n", $body);
                // Need to be careful here about array index, adding check
                if (isset($body[1])) {
                    $json = json_decode($body[1], true);
                    $newUsername = $json['data']['newUsername'] ?? null;
                    return $newUsername;
                }
            }
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
        }
        return false;
    }

    /**
     * Updates a JSON history of usernames with date.
     *
     * @param string|null $jsonHistory
     * @param string      $username
     * @return string
     */
    protected function addUsernameToHistory(?string $jsonHistory, string $username): string
    {
        if (empty($jsonHistory)) {
            $history = [];
        } else {
            $decoded = json_decode($jsonHistory, true);
            $history = (is_array($decoded) ? $decoded : []);
        }
        
        foreach ($history as $entry) {
            if (isset($entry['username']) && $entry['username'] === $username) {
                return json_encode($history, JSON_UNESCAPED_UNICODE);
            }
        }

        $history[] = [
            'username' => $username,
            'date'     => date('Y-m-d'),
        ];

        return json_encode($history, JSON_UNESCAPED_UNICODE);
    }
}
