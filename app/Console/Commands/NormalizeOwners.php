<?php

namespace App\Console\Commands;

use App\Models\Owner;
use App\Services\Owner\OwnerSyncService;
use Illuminate\Console\Command;

class NormalizeOwners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:normalize-owners';

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
        $this->info('Starting normalize owners...');

        $owners = Owner::select('id', 'username')
            ->where('notFound', true)
            ->get();
        $service = app(OwnerSyncService::class);

        $bar = $this->output->createProgressBar($owners->count());
        $bar->setFormatDefinition(
            'custom',
            '%current%/%max% [%bar%] %percent:3s%% | Transcurrido: %elapsed:6s% | Restante: %remaining:6s% | Mem: %memory:6s%'
        );
        $bar->setFormat('custom');
        $bar->start();

        foreach ($owners as $owner) {
            $data = $service->getInfoById($owner->id);
            if ($data) {
                if (data_get($data, 'isModel') === false) {
                    Owner::where('id', $owner->id)->delete();
                } else if (data_get($data, 'username') != $owner->username) {
                    Owner::where('id', $owner->id)->update(['notFound' => false]);
                } else {
                    Owner::where('id', $owner->id)->update([
                        'isBlocked' => data_get($data, 'isBlocked'),
                        'isOnline' => data_get($data, 'isOnline'),
                        'notFound' => false,
                    ]);
                }
            }
            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);

        $this->line('Owners normalized successfully.');
    }
}
