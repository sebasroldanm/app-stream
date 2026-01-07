<?php

namespace App\Jobs;

use App\Services\Owner\OwnerSyncService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncOwnerByUsername implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param string $username
     */
    public function __construct(protected string $username)
    {
        $this->onQueue('low');
    }

    /**
     * Execute the job.
     *
     * @param OwnerSyncService $service
     */
    public function handle(OwnerSyncService $service): void
    {
        $service->syncOwnerByUsername($this->username);
    }
}
