<?php

namespace App\Jobs;

use App\Models\Conversation;
use App\Services\Owner\OwnerConversationService;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncConversationMessages implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;

    public $tries = 3;

    public $backoff = [30, 60, 120];

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $ownerId,
        protected Conversation $conversation,
        protected Carbon $syncTimestamp,
    ) {
        $this->onQueue('high');
    }

    /**
     * Execute the job.
     */
    public function handle(OwnerConversationService $conversationService): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        $lastMessageId = $conversationService->syncMessages(
            $this->ownerId,
            $this->conversation->id,
            null,
            $this->syncTimestamp,
        );

        do {
            $previousMessageId = $lastMessageId;
            $lastMessageId = $conversationService->syncMessages(
                $this->ownerId,
                $this->conversation->id,
                $previousMessageId,
                $this->syncTimestamp,
            );
        } while ($lastMessageId !== $previousMessageId);
    }
}
