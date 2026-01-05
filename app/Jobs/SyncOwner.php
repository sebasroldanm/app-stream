<?php

namespace App\Jobs;

use App\Models\Owner;
use App\Services\Owner\OwnerAlbumSyncService;
use App\Services\Owner\OwnerFeedSyncService;
use App\Services\Owner\OwnerIntroSyncService;
use App\Services\Owner\OwnerPanelSyncService;
use App\Services\Owner\OwnerSyncService;
use App\Services\Owner\OwnerVideoSyncService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SyncOwner implements ShouldQueue
{
    use Queueable;

    protected Owner $owner;
    protected $type;
    
    public $timeout = 1200;

    protected OwnerSyncService $ownerSyncService;
    protected OwnerPanelSyncService $ownerPanelSyncService;
    protected OwnerAlbumSyncService $ownerAlbumSyncService;
    protected OwnerIntroSyncService $ownerIntroSyncService;
    protected OwnerVideoSyncService $ownerVideoSyncService;
    protected OwnerFeedSyncService $ownerFeedSyncService;

    /**
     * Create a new job instance.
     */
    public function __construct(Owner $owner, $type)
    {
        $this->owner = $owner;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(
        OwnerSyncService $ownerSyncService,
        OwnerPanelSyncService $ownerPanelSyncService,
        OwnerAlbumSyncService $ownerAlbumSyncService,
        OwnerIntroSyncService $ownerIntroSyncService,
        OwnerVideoSyncService $ownerVideoSyncService,
        OwnerFeedSyncService $ownerFeedSyncService
    ): void
    {
        $this->ownerSyncService = $ownerSyncService;
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
            default:
                $this->updateOwner($owner);
                break;
        }

        if ($type === 'all') {
            $this->updateAll($owner);
        }

    }

    private function updateOwner($owner)
    {
        $this->ownerSyncService->syncOwnerByUsername($owner->username);
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
}
