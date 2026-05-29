<?php

namespace App\Console\Commands;

use App\Jobs\SyncConversationMessages;
use App\Services\Owner\OwnerConversationService;
use Carbon\Carbon;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateConversation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-conversation {owner_id=142766100 : ID del owner a sincronizar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza conversaciones y mensajes del owner';

    /**
     * Execute the console command.
     */
    public function handle(OwnerConversationService $conversationService): int
    {
        $ownerId = $this->argument('owner_id');

        $this->info("Sincronizando conversaciones para owner: {$ownerId}...");

        $conversations = $conversationService->syncConversations($ownerId, 0, 5000);

        $this->info("Conversaciones obtenidas: {$conversations->count()}. Despachando jobs de mensajes...");

        $syncTimestamp = Carbon::now();

        Bus::batch(
            $conversations->map(fn($conversation) => new SyncConversationMessages(
                $ownerId,
                $conversation,
                $syncTimestamp,
            ))->toArray()
        )
            ->name("sync-messages:{$ownerId}")
            ->allowFailures()
            ->onQueue('high')
            ->then(function (Batch $batch) {
                Log::info("sync-messages: batch completado. Total: {$batch->totalJobs}, Fallidos: {$batch->failedJobs}");
            })
            ->catch(function (Batch $batch, Throwable $e) {
                Log::error("sync-messages: error en batch {$batch->id}: {$e->getMessage()}");
            })
            ->dispatch();

        $this->info('Batch despachado correctamente.');

        return Command::SUCCESS;
    }
}
