<?php

namespace App\Console\Commands;

use App\Jobs\SearchOwnerJob;
use App\Services\Owner\OwnerDiscoveryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SearchOwners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:search-owners {--from=} {--to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca owners iterando IDs de conversación y los despacha al queue default';

    /**
     * Execute the console command.
     */
    public function handle(OwnerDiscoveryService $discoveryService): void
    {
        $from = (int) $this->option('from');
        $to   = (int) $this->option('to');

        $this->info('Buscando owners (despachando en cola default) desde ' . $from . ' hasta ' . $to);

        $bar = $this->output->createProgressBar($to - $from + 1);
        $bar->setFormatDefinition(
            'custom',
            '%current%/%max% [%bar%] %percent:3s%% | Transcurrido: %elapsed:6s% | Restante: %remaining:6s% | Mem: %memory:6s%'
        );
        $bar->setFormat('custom');
        $bar->start();

        for ($i = $from; $i <= $to; $i++) {
            try {
                $discoveryService->discoverByConversationId($i);
                // SearchOwnerJob::dispatch($i);
            } catch (\Throwable) {
                // continuar con el siguiente ID
            } finally {
                $bar->advance();
            }
        }

        $bar->finish();

        $this->newLine(2);
        $this->info('Trabajos despachados a la cola.');
    }
}
