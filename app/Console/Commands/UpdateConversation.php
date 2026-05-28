<?php

namespace App\Console\Commands;

use App\Models\Conversation;
use App\Services\Owner\OwnerConversationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateConversation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-conversation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando sincronización de conversaciones...');

        $conversations = app(OwnerConversationService::class)->syncConversations('142766100', 0, 5000);

        $this->info('Sincronización de conversaciones completada. Total: ' . count($conversations));

        $this->info('Iniciando sincronización de mensajes...');

        $bar = $this->output->createProgressBar($conversations->count());
        $bar->setFormatDefinition(
            'custom',
            '%current%/%max% [%bar%] %percent:3s%% | Transcurrido: %elapsed:6s% | Restante: %remaining:6s% | Mem: %memory:6s%'
        );
        $bar->setFormat('custom');
        $bar->start();

        $syncTimestamp = Carbon::now();

        $errors = [];

        foreach ($conversations as $conversation) {
            try {
                $lastMessageId = app(OwnerConversationService::class)->syncMessages('142766100', $conversation->id, null, $syncTimestamp);
                do {
                    $previousMessageId = $lastMessageId;
                    $lastMessageId = app(OwnerConversationService::class)->syncMessages('142766100', $conversation->id, $previousMessageId, $syncTimestamp);
                } while ($lastMessageId != $previousMessageId);
                $bar->advance();
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->info('Sincronización de mensajes completada.');

        if (!empty($errors)) {
            $this->error('Errores: ' . count($errors));
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        return Command::SUCCESS;
    }
}
