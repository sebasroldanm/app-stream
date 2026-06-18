<?php

namespace App\Console\Commands;

use App\Models\Owner;
use App\Services\Owner\OwnerStatService;
use Illuminate\Console\Command;

class UpdateStat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-stat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the stream stats of the live owners';

    /**
     * Execute the console command.
     */
    public function handle(OwnerStatService $ownerStatService)
    {
        $this->line('Getting live owners...');
        $owners = Owner::where('isLive', true)
            ->orWhere('isOnline', true)
            ->get();

        $this->info('Owners found: ' . $owners->count());

        $bar = $this->output->createProgressBar($owners->count());
        $bar->start();

        foreach ($owners as $owner) {
            $ownerStatService->syncStreamStat($owner);
            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);

        $this->line('Stats updated successfully.');
    }
}
