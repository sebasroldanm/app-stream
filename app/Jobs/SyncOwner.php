<?php

namespace App\Jobs;

use App\Models\Owner;
use App\Traits\SyncData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SyncOwner implements ShouldQueue
{
    use Queueable, SyncData;

    protected Owner $owner;

    protected $type;

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
    public function handle(): void
    {
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
        $this->syncOwnerByUsername($owner->username);
    }

    private function updateAll($owner)
    {
        $this->syncOwnerByUsername($owner->username);
        $this->syncPanelByOwnerId($owner->id);
        $this->syncAlbum($owner->id, $owner->username);
        $this->syncIntroByOwnerId($owner->id);
        $this->syncVideo($owner->id, $owner->username);
        $this->syncFeedByOwnerId($owner->id);
    }
}
