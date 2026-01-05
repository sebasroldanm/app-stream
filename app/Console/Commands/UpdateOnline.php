<?php

namespace App\Console\Commands;

use App\Jobs\SyncOwner;
use App\Models\Owner;
use Illuminate\Console\Command;
class UpdateOnline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-online';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $owners = Owner::where('isLive', true)
            ->orWhere('isOnline', true)
            ->get();

        foreach ($owners as $owner) {
            SyncOwner::dispatch($owner, 'owner');
        }
    }

}
