<?php

namespace App\Console\Commands;

use App\Jobs\SyncOwner;
use App\Models\Owner;
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
