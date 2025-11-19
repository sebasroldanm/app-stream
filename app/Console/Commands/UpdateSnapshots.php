<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Owner;
use App\Models\Snapshot;
use App\Traits\SyncData;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class UpdateSnapshots extends Command
{
    use SyncData;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-snapshots';

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

        $customer_id = 1;
        $customer = Customer::with('ownerFavorites')->find($customer_id);

        foreach ($customer->ownerFavorites as $fav) {
            $this->syncOwnerByUsername($fav->username);
            $fav = Owner::find($fav->id);
            $fav->data = json_decode($fav->data);
            if (
                isset($fav->data->user->user->snapshotTimestamp) &&
                $fav->isLive == 1 &&
                $fav->isDeleted == 0
                ) {
                $snap_time = $fav->data->user->user->snapshotTimestamp;
                $snapshot = Snapshot::where("owner_id", $fav->id)
                    ->where("snapshotTimestamp", $snap_time)
                    ->get();
                if ($snapshot->count() == 0) {
                    $newSnap = new Snapshot();
                    $newSnap->owner_id = $fav->id;
                    $newSnap->snapshotTimestamp = $snap_time;
                    $newSnap->date_created = Carbon::createFromTimestamp($snap_time);
                    $newSnap->snapshotUrl = "https://img.strpst.com/thumbs/" . $snap_time . "/" . $fav->id . "_webp";
                    $test_url = $response = Http::get($newSnap->snapshotUrl);
                    if ($test_url->successful()) {

                        if (!Storage::disk('public')->exists('snapshots/' . $fav->username)) {
                            Storage::disk('public')->makeDirectory('snapshots/' . $fav->username);
                        }
                        
                        $filePath = 'snapshots/' . $fav->username . '/' . $snap_time . '.webp';
                        if (!Storage::disk('public')->exists('snapshots/' . $fav->username)) {
                            Storage::disk('public')->makeDirectory('snapshots/' . $fav->username);
                        }

                        if (Storage::disk('public')->exists($filePath)) {
                            $existingImage = Storage::disk('public')->get($filePath);
                            $newImage = $test_url->body();
                    
                            if (md5($existingImage) === md5($newImage)) {
                                continue;
                            }
                        }

                        Storage::disk('public')->put($filePath, $test_url->body());
                        $newSnap->local_url = '/storage/' . $filePath;
                        $newSnap->save();
                    }
                }
            }
        }

        // $clear = Owner::all();
        // foreach ($clear as $cl) {
        //     $test_url = $response = Http::get($cl->snapshotUrl);
        //     if (!$test_url->successful()) {
        //         Owner::destroy($cl->id);
        //     }
        // }
        return true;
    }
}
