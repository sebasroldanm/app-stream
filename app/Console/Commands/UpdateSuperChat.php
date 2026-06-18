<?php

namespace App\Console\Commands;

use App\Models\Owner;
use App\Services\Owner\OwnerChatService;
use Illuminate\Console\Command;

class UpdateSuperChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-super-chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the super chats of the live owners';

    /**
     * Execute the console command.
     */
    public function handle(OwnerChatService $chatService)
    {
        $this->line('Getting live owners...');
        $owners = Owner::where('isLive', true)->get();

        $this->info('Owners found: ' . $owners->count());

        $bar = $this->output->createProgressBar($owners->count());
        $bar->start();

        foreach ($owners as $owner) {
            $chatService->syncSuperChats($owner);
            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);

        $this->line('Super chats updated successfully.');
    }
}
