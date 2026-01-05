<?php

namespace App\Console\Commands;

use App\Jobs\SyncOwner;
use App\Models\Customer;
use App\Models\Owner;
use Illuminate\Console\Command;

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
            ->get();

        foreach ($owners as $owner) {
            SyncOwner::dispatch($owner, 'all');
        }
    }
}
