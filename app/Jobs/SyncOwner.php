<?php

namespace App\Jobs;

use App\Models\Owner;
use App\Services\Owner\OwnerAlbumSyncService;
use App\Services\Owner\OwnerFeedSyncService;
use App\Services\Owner\OwnerIntroSyncService;
use App\Services\Owner\OwnerPanelSyncService;
use App\Services\Owner\OwnerStatService;
use App\Services\Owner\OwnerSyncService;
use App\Services\Owner\OwnerVideoSyncService;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SyncOwner implements ShouldQueue
{
    use Batchable, Queueable;

    protected Owner $owner;
    protected string $type;

    public $timeout = 1200;

    protected OwnerSyncService $ownerSyncService;
    protected OwnerStatService $ownerStatService;
    protected OwnerPanelSyncService $ownerPanelSyncService;
    protected OwnerAlbumSyncService $ownerAlbumSyncService;
    protected OwnerIntroSyncService $ownerIntroSyncService;
    protected OwnerVideoSyncService $ownerVideoSyncService;
    protected OwnerFeedSyncService $ownerFeedSyncService;

    /**
     * Create a new job instance.
     */
    public function __construct(Owner $owner, string $type)
    {
        $this->owner = $owner;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(
        OwnerSyncService $ownerSyncService,
        OwnerStatService $ownerStatService,
        OwnerPanelSyncService $ownerPanelSyncService,
        OwnerAlbumSyncService $ownerAlbumSyncService,
        OwnerIntroSyncService $ownerIntroSyncService,
        OwnerVideoSyncService $ownerVideoSyncService,
        OwnerFeedSyncService $ownerFeedSyncService
    ): void
    {
        $this->ownerSyncService = $ownerSyncService;
        $this->ownerStatService = $ownerStatService;
        $this->ownerPanelSyncService = $ownerPanelSyncService;
        $this->ownerAlbumSyncService = $ownerAlbumSyncService;
        $this->ownerIntroSyncService = $ownerIntroSyncService;
        $this->ownerVideoSyncService = $ownerVideoSyncService;
        $this->ownerFeedSyncService = $ownerFeedSyncService;

        $owner = $this->owner;
        $type = $this->type;

        switch ($type) {
            case 'all':
                $this->updateAll($owner);
                break;
            case 'owner':
                $this->updateOwner($owner);
                break;
            case 'all_not_exception':
                $this->updateAllNotException($owner);
                break;
            case 'feed':
                $this->updateFeed($owner);
                break;
            default:
                $this->updateOwner($owner);
                break;
        }

    }

    private function updateOwner($owner)
    {
        $this->ownerSyncService->syncOwnerByUsername($owner->username);
        $this->ownerStatService->syncStreamStat($owner);
    }

    private function updateAll($owner)
    {
        $synchronized = $this->ownerSyncService->syncOwnerByUsername($owner->username);
        
        if (!$synchronized) {
            return;
        }

        $this->ownerPanelSyncService->syncPanelByOwnerId($owner->id);
        $this->ownerAlbumSyncService->syncAlbum($owner->id, $owner->username);
        $this->ownerIntroSyncService->syncIntroByOwnerId($owner->id);
        $this->ownerVideoSyncService->syncVideo($owner->id, $owner->username);
        $this->ownerFeedSyncService->syncFeedByOwnerId($owner->id);
    }

    private function updateAllNotException($owner)
    {
        $this->ownerSyncService->syncOwnerByUsername($owner->username);
        $this->ownerPanelSyncService->syncPanelByOwnerId($owner->id);
        $this->ownerIntroSyncService->syncIntroByOwnerId($owner->id);
    }

    private function updateFeed($owner)
    {
        $this->ownerFeedSyncService->syncFeedByOwnerId($owner->id);
    }
}
