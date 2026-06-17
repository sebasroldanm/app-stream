<?php

namespace App\Console\Commands;

use App\Jobs\SyncOwner;
use App\Models\Owner;
use App\Services\Owner\OwnerSyncService;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Throwable;

class UpdateOnline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-online {--type=batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update online status of owners';

    public function handle()
    {
        $owners = Owner::where('isLive', true)
            ->orWhere('isOnline', true)
            ->get();

        if ($this->option('type') === 'batch') {
            $this->info('Updating owners in batches...');

            $bar = $this->output->createProgressBar($owners->count());
            $bar->setFormatDefinition(
                'custom',
                '%current%/%max% [%bar%] %percent:3s%% | Transcurrido: %elapsed:6s% | Restante: %remaining:6s% | Mem: %memory:6s%'
            );
            $bar->setFormat('custom');
            $bar->start();

            $service = app(OwnerSyncService::class);
            $owners
                ->chunk(50)
                ->each(function ($chunk) use ($service, $bar) {
                    $loteIds = $chunk->pluck("id")->toArray();
                    $resultOwners = $service->getInfoByIds($loteIds);
                    if ($resultOwners) {
                        foreach ($resultOwners as $resultOwner) {
                            Owner::where('id', data_get($resultOwner, 'id'))->update([
                                'username' => data_get($resultOwner, 'username'),
                                'isBlocked' => data_get($resultOwner, 'isBlocked'),
                                'isOnline' => data_get($resultOwner, 'isOnline')
                            ]);
                            $bar->advance();
                        }
                    }
                });

            $bar->finish();
            $this->newLine(2);
            $this->info('Owners updated successfully - Total owners updated: ' . $owners->count());
            return Command::SUCCESS;
        }

        Bus::batch(
            $owners->map(fn($owner) => (new SyncOwner($owner, 'owner')))->toArray()
        )
            ->onQueue('default')
            ->then(function (Batch $batch) {
                Cache::forget('online_app');
                Cache::remember('online_app', 60, function () {
                    return Owner::where('isOnline', true)->count();
                });
            })
            ->catch(function (Batch $batch, Throwable $e) {
                Cache::forget('online_app');
                Cache::remember('online_app', 60, function () {
                    return Owner::where('isOnline', true)->count();
                });
            })
            ->finally(function (Batch $batch) {
                Cache::forget('online_app');
                Cache::remember('online_app', 60, function () {
                    return Owner::where('isOnline', true)->count();
                });
            })
            ->dispatch();
    }
}
