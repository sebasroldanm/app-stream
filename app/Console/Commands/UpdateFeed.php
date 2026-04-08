<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Owner;
use App\Traits\SyncData;
use Illuminate\Console\Command;

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
        $this->info('Actualizando feed...');

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
                $this->syncFeedByOwnerId($owner->id);
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
}
