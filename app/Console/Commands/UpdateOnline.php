<?php

namespace App\Console\Commands;

use App\Models\Owner;
use App\Traits\SyncData;
use Illuminate\Console\Command;
class UpdateOnline extends Command
{
    use SyncData;
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
        $owners = Owner::where('isOnline', 1)->get();

        foreach ($owners as $owner) {
            $this->syncOwnerByUsername($owner->username);
        }
    }

}
