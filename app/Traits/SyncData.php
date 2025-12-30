<?php

namespace App\Traits;

use App\Jobs\UploadImageService;
use App\Models\Album;
use App\Models\AlbumFeed;
use App\Models\Feed;
use App\Models\Intro;
use App\Models\Log;
use App\Models\MediaPostFeed;
use App\Models\Owner;
use App\Models\Panel;
use App\Models\PhotoAlbumFeed;
use App\Models\Photos;
use App\Models\PostFeed;
use App\Models\Video;
use App\Models\VideoFeed;
use Carbon\Carbon;
use GuzzleHttp\Client;

trait SyncData
{
    use OwnerProp;

    public function syncOwnerByUsername($username)
    {
        return app(\App\Services\Owner\OwnerSyncService::class)->syncOwnerByUsername($username);
    }

    public function addUsernameToHistory(?string $jsonHistory, string $username): string
    {
        // This is a helper specific to SyncService logic. 
        // We can duplicate logic or expose it in service. 
        // For trait backward compatibility, simpler to keep logic or call service if public.
        // It was protected in Service. making it public there is an option, or just implementing here.
        // It is a pure function. I'll recreate it here to avoid changing Service visibility or use reflection.
        
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

    public function syncPanelByOwnerId($id)
    {
        return app(\App\Services\Owner\OwnerPanelSyncService::class)->syncPanelByOwnerId($id);
    }

    public function syncAlbum($id_owner, $username)
    {
        return app(\App\Services\Owner\OwnerAlbumSyncService::class)->syncAlbum($id_owner, $username);
    }

    public function syncIntroByOwnerId($id)
    {
        return app(\App\Services\Owner\OwnerIntroSyncService::class)->syncIntroByOwnerId($id);
    }

    public function syncVideo($id_owner, $username)
    {
        return app(\App\Services\Owner\OwnerVideoSyncService::class)->syncVideo($id_owner, $username);
    }

    public function syncFeedByOwnerId($id)
    {
        return app(\App\Services\Owner\OwnerFeedSyncService::class)->syncFeedByOwnerId($id);
    }

    public function searchGlobal($keyword)
    {
        return app(\App\Services\Owner\OwnerSearchService::class)->searchGlobal($keyword);
    }

    // Helper methods like saveFeed, etc are now internal to ProcessFeedPost job and not needed here publically 
    // unless used by other classes.
    // SyncData::saveFeed was private. 
    // SyncData::albumUpdated was private.
    // SyncData::videoAdded was private.
    // SyncData::postAdded was private.
    // So we can remove them if no one calls them (Traits private methods are part of class, but unlikely called directly if not via syncFeed).
    // syncFeedByOwnerId used them. Now it delegates. So they can be removed.

}
