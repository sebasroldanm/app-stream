<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Owner;
use App\Traits\SyncData;
use Illuminate\Console\Command;
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
        $this->info('Obteniendo usuarios');

        $favs = Customer::find(1)->getOwnerFavoriteIds()->toArray();
        $owners = Owner::whereIn('id', $favs)->get();

        $bar = $this->output->createProgressBar(count($owners));
        $bar->setFormatDefinition(
            'custom',
            '%current%/%max% [%bar%] %percent:3s%% | Transcurrido: %elapsed:6s% | Restante: %remaining:6s% | Mem: %memory:6s%'
        );
        $bar->setFormat('custom');
        $bar->start();

        $errors = [];

        foreach ($owners as $key => $owner) {
            try {
                $this->syncAllByUsername($owner->username);
                $bar->advance();
            } catch (\Throwable $th) {
                $errors[] = $owner->username;
            } finally {
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('Actualizacion de usuarios completada');

        if (!empty($errors)) {
            $this->error('Errores en la sincronizacion: ' . count($errors));
            foreach ($errors as $key => $error) {
                $this->error($error);
            }
        }
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
