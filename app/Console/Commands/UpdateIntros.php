<?php

namespace App\Console\Commands;

use App\Models\Intro;
use App\Services\Owner\OwnerIntroSyncService;
use Illuminate\Console\Command;

class UpdateIntros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-intros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle(OwnerIntroSyncService $syncService)
    {
        $ownerIds = Intro::pluck('owner_id')->unique();

        $this->info("Iniciando resincronización de " . $ownerIds->count() . " intros...");
        $bar = $this->output->createProgressBar($ownerIds->count());
        $bar->start();

        foreach ($ownerIds as $ownerId) {
            $syncService->syncIntroByOwnerId($ownerId);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Proceso finalizado.');
    }
}
