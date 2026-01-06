<?php

namespace App\Console\Commands;

use App\Jobs\SyncOwner;
use App\Models\Customer;
use App\Models\Owner;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Throwable;

class UpdateOwnersData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-owners-data';

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
        $favs = Customer::find(1)->getOwnerFavoriteIds()->toArray();
        $owners = Owner::whereIn('id', $favs)
            ->where('isDelete', false)
            ->where('notFound', false)
            ->where('statusChangedAt', '<', now()->subMonths(3))
            ->get();

        Bus::batch(
            $owners->map(fn($owner) => new SyncOwner($owner, 'all'))->toArray()
        )
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
