<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetAllMods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-all-mods';

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
        echo "\nIniciando proceso...";
        $proxy = env('API_PROXY');
        $server = env('API_SERVER');

        $endpoint = $server . '/api/front/models?improveTs=false&limit=60&offset=0&primaryTag=girls&filterGroupTags=%5B%5B%22tagLanguageColombian%22%5D%2C%5B%22autoTagNew%22%5D%2C%5B%22mobile%22%5D%5D&sortBy=stripRanking&parentTag=autoTagNew';

        $insert = 0;
        $errors = 0;
        $date_now = Carbon::now();

        $client = new Client();

        $response = $client->request('GET', $endpoint, [
            'verify' => false
        ]);

        $body = $response->getBody();
        $json = json_decode($body);

        $mods = $json->models;

        foreach ($json->models as $key => $mod) {

            try {
                $id_mod = DB::table('mods')->updateOrInsert(
                    ['id_mod' => $mod->id],
                    [
                        'snapshotUrl' => (isset($mod->snapshotUrl)) ? $mod->snapshotUrl : null,
                        'widgetPreviewUrl' => (isset($mod->widgetPreviewUrl)) ? $mod->widgetPreviewUrl : null,
                        'privateRate' => (isset($mod->privateRate)) ? $mod->privateRate : null,
                        'p2pRate' => (isset($mod->p2pRate)) ? $mod->p2pRate : null,
                        'isNonNude' => (isset($mod->isNonNude)) ? $mod->isNonNude : null,
                        'avatarUrl' => (isset($mod->avatarUrl)) ? $mod->avatarUrl : null,
                        'isPornStar' => (isset($mod->isPornStar)) ? $mod->isPornStar : null,
                        'id_mod' => $mod->id,
                        'country' => (isset($mod->country)) ? $mod->country : null,
                        'doSpy' => (isset($mod->doSpy)) ? $mod->doSpy : null,
                        'doPrivate' => (isset($mod->doPrivate)) ? $mod->doPrivate : null,
                        'gender' => (isset($mod->gender)) ? $mod->gender : null,
                        'isHd' => (isset($mod->isHd)) ? $mod->isHd : null,
                        'isVr' => (isset($mod->isVr)) ? $mod->isVr : null,
                        'is2d' => (isset($mod->is2d)) ? $mod->is2d : null,
                        'isExternalApp' => (isset($mod->isExternalApp)) ? $mod->isExternalApp : null,
                        'isMobile' => (isset($mod->isMobile)) ? $mod->isMobile : null,
                        'isModel' => (isset($mod->isModel)) ? $mod->isModel : null,
                        'isNew' => (isset($mod->isNew)) ? $mod->isNew : null,
                        'isLive' => (isset($mod->isLive)) ? $mod->isLive : null,
                        'isOnline' => (isset($mod->isOnline)) ? $mod->isOnline : null,
                        'previewUrl' => (isset($mod->previewUrl)) ? $mod->previewUrl : null,
                        'previewUrlThumbBig' => (isset($mod->previewUrlThumbBig)) ? $mod->previewUrlThumbBig : null,
                        'previewUrlThumbSmall' => (isset($mod->previewUrlThumbSmall)) ? $mod->previewUrlThumbSmall : null,
                        'broadcastServer' => (isset($mod->broadcastServer)) ? $mod->broadcastServer : null,
                        'broadcastGender' => (isset($mod->broadcastGender)) ? $mod->broadcastGender : null,
                        'snapshotServer' => (isset($mod->snapshotServer)) ? $mod->snapshotServer : null,
                        'status' => (isset($mod->status)) ? $mod->status : null,
                        'topBestPlace' => (isset($mod->topBestPlace)) ? $mod->topBestPlace : null,
                        'username' => (isset($mod->username)) ? $mod->username : null,
                        'statusChangedAt' => (isset($mod->statusChangedAt)) ? $mod->statusChangedAt : null,
                        'spyRate' => (isset($mod->spyRate)) ? $mod->spyRate : null,
                        'publicRecordingsRate' => (isset($mod->publicRecordingsRate)) ? $mod->publicRecordingsRate : null,
                        'genderGroup' => (isset($mod->genderGroup)) ? $mod->genderGroup : null,
                        'popularSnapshotTimestamp' => (isset($mod->popularSnapshotTimestamp)) ? $mod->popularSnapshotTimestamp : null,
                        'hasGroupShowAnnouncement' => (isset($mod->hasGroupShowAnnouncement)) ? $mod->hasGroupShowAnnouncement : null,
                        'groupShowType' => (isset($mod->groupShowType)) ? $mod->groupShowType : null,
                        'hallOfFamePosition' => (isset($mod->hallOfFamePosition)) ? $mod->hallOfFamePosition : null,
                        'snapshotTimestamp' => (isset($mod->snapshotTimestamp)) ? $mod->snapshotTimestamp : null,
                        'hlsPlaylist' => (isset($mod->hlsPlaylist)) ? $mod->hlsPlaylist : null,
                        'isAvatarApproved' => (isset($mod->isAvatarApproved)) ? $mod->isAvatarApproved : null,
                        'isTagVerified' => (isset($mod->isTagVerified)) ? $mod->isTagVerified : null,
                        'created_at' => $date_now,
                        'updated_at' => $date_now
                    ]
                );
                $insert++;
            } catch (\Throwable $th) {
                dd($th->getMessage());
                $errors++;
            }

        }

        echo "\nInserted: $insert, Errors: $errors";
        echo "\n";
    }
}
