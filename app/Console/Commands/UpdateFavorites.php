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
use Illuminate\Support\Facades\DB;

class UpdateFavorites extends Command
{
    use SyncData;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-favorites';

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
        $owners = Owner::whereIn('id', $favs)->get();

        Bus::batch(
            $owners->map(fn($owner) => (new SyncOwner($owner, 'all_not_exception')))->toArray()
        )
            ->onQueue('default')
            ->then(function (Batch $batch) {
                Cache::forget('online_app');
                Cache::remember('online_app', 60, function () {
                    return Owner::where('isOnline', true)->count();
                });
            })
            ->catch(function (Batch $batch, $exception) {
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
                Cache::put('Notification', 'Update Favorites', 3600);
                Cache::put('Status', 'Finalizado', 3600);
            })
            ->dispatch();
    }

    private function syncAllByUsername(string $username)
    {
        $this->syncOwnerByUsername($username);
        $id_owner = Owner::where('username', $username)->first()->id;
        $this->syncPanelByOwnerId($id_owner);
        $this->syncAlbumsByOwnerId($id_owner, $username);
        $this->syncIntroByOwnerId($id_owner);
        $this->syncVideoByOwnerId($id_owner, $username);
        $this->syncFeedByOwnerId($id_owner);
    }
}
