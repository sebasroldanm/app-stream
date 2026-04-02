<?php

namespace App\Console\Commands;

use App\Models\Owner;
use App\Models\Post;
use App\Models\TelegramChat;
use App\Models\TelegramMessage;
use Illuminate\Console\Command;

class AssigPostToOwner extends Command
{
    protected $signature = 'app:assig-post-to-owner';

    protected $description = 'Command description';

    public function handle()
    {
        $chat = $this->ask('Ingrese el ID del Chat (ID de BD)');

        $chat = TelegramChat::where('id', $chat)->first();

        $messages = TelegramMessage::with('captions')
            ->where('fk_telegram_chats_id', $chat->id)->get();
        
        foreach ($messages as $message) {

            // Taer los valores 
            $caption = $message->captions->where('caption', '#stripchat');
            if($caption->count() > 0){
                $owner = $message
                    ->captions
                    ->whereNotIn('type', ['text', 'url', 'text_link'])
                    ->whereNotIn('caption', explode(',', env('TELEGRAM_EXCLUDE_CAPTION')))
                    ->first();
                if($owner){
                    // Search Owner
                    $username = str_replace('#', '', $owner->caption);
                    $owner = Owner::where('username', $username)->first();
                    // create user if not exists
                    $result = $this->syncOwnerByUsername($username);
                    if ($result) {
                        $owner = Owner::where('username', $username)->first();

                        // Message parents
                        if($message->id_message_parent) {
                            $messages_id = TelegramMessage::where('id_message_parent', $message->id_message_parent)->pluck('id')->toArray();
                        } else {
                            $messages_id = [$message->id];
                        }
                        
                        // Create Post
                        foreach ($messages_id as $message_id) {
                            $post = Post::where('fk_telegram_messages_id', $message_id)->first();
                            if($post){
                                continue;
                            }
                            $post = Post::create([
                                'fk_owners_id' => $owner->id,
                                'fk_telegram_messages_id' => $message_id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
