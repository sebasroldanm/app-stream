<?php

namespace App\Jobs;

use App\Services\Owner\OwnerDiscoveryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SearchOwnerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected int $conversationId)
    {
        $this->onQueue('default');
    }

    /**
     * Execute the job.
     */
    public function handle(OwnerDiscoveryService $discoveryService): void
    {
        $discoveryService->discoverByConversationId($this->conversationId);
    }
}
