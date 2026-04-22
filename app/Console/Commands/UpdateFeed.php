<?php

namespace App\Console\Commands;

use App\Jobs\SyncOwner;
use App\Models\Customer;
use App\Models\Owner;
use App\Traits\SyncData;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;

class UpdateFeed extends Command
{
    use SyncData;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el feed de los usuarios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $favs = Customer::find(1)->getOwnerFavoriteIds()->toArray();
        $owners = Owner::whereIn('id', $favs)->get();

        Bus::batch(
            $owners->map(fn($owner) => (new SyncOwner($owner, 'feed')))->toArray()
        )
            ->onQueue('high')
            ->finally(function (Batch $batch) {
                Cache::put('Notification', 'Update Feed', 3600);
                Cache::put('Status', 'Finalizado', 3600);
            })
            ->dispatch();
    }
}
