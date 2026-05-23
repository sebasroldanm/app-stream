<?php

namespace App\Livewire;

use App\Models\Owner;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Conversations extends Component
{
    public $selectedConversation;
    public $messages;
    public $conversationsData;
    public $conversationOffset = 0;
    public $conversationLimit = 10;

    public function mount()
    {
        $this->conversationsData = $this->getConversations();
    }

    public function render()
    {
        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.conversations');

        return $view->layoutData(['title' => 'Conversations']);
    }

    public function selectConversation($idMessage)
    {
        $this->selectedConversation = $idMessage;
        $data = $this->getOwnerMessages($idMessage);
        
        // Reverse messages to show them from oldest to newest (bottom up)
        if (isset($data->messages)) {
            $data->messages = array_reverse($data->messages);
        }
        
        $this->messages = $data;
        
        $this->dispatch('scroll-to-bottom');
    }

    public function loadMoreMessages()
    {
        if (!$this->selectedConversation || empty($this->messages->messages)) {
            return;
        }

        // The oldest message is the first one in our reversed array
        $oldestMessage = $this->messages->messages[0];
        $beforeIdMessage = $oldestMessage->id;

        $newData = $this->getOwnerMessages($this->selectedConversation, $beforeIdMessage);

        if (isset($newData->messages) && count($newData->messages) > 0) {
            // Reverse new messages (they come DESC) and prepend them
            $reversedNewMessages = array_reverse($newData->messages);
            $this->messages->messages = array_merge($reversedNewMessages, $this->messages->messages);
            
            $this->dispatch('messages-prepended', count($newData->messages));
        }
    }

    public function loadMoreConversations()
    {
        $this->conversationOffset += $this->conversationLimit;
        
        $newData = $this->getConversations($this->conversationOffset, $this->conversationLimit);
        
        if (isset($newData->conversations) && count($newData->conversations) > 0) {
            $this->conversationsData->conversations = array_merge(
                $this->conversationsData->conversations, 
                $newData->conversations
            );
        }
    }

    public function getConversations($offset = 0, $limit = 10)
    {
        $cookieClient = env('COOKIE_CLIENT');
        $cacheKey = 'conversations_user_' . $cookieClient . '_' . $offset . '_' . $limit;

        $conversations = Cache::remember($cacheKey, now()->addHours(2), function () use ($cookieClient, $offset, $limit) {

            $service = app(\App\Services\Owner\OwnerConversationService::class);
            $data = $service->getConversations($cookieClient, $offset, $limit);

            foreach ($data->conversations as $conv) {
                $owner = Owner::find($conv->counterpartId);

                if (!$owner) {
                    $conv->message->avatar = "https://ui-avatars.com/api/?name=US&background=fff&color=fa377b";
                    $conv->message->username = "User";
                } else {
                    $conv->message->avatar = $owner->pic_profile;
                    $conv->message->username = $owner->username;
                    $conv->message->isLive = $owner->isLive;
                }
                $conv->message->created_at = Carbon::parse($conv->message->createdAt)->diffForHumans();
            }

            return $data;
        });

        return $conversations;
    }

    public function getOwnerMessages($idMessage, $beforeIdMessage = null)
    {
        $cookieClient = env('COOKIE_CLIENT');
        $cacheKey = 'messages_' . $cookieClient . '_' . $idMessage . '_' . $beforeIdMessage;

        $messages = Cache::remember($cacheKey, now()->addHours(2), function () use ($cookieClient, $idMessage, $beforeIdMessage) {

            $service = app(\App\Services\Owner\OwnerConversationService::class);
            return $service->getOwnerMessages($cookieClient, $idMessage, $beforeIdMessage);
        });

        return $messages;
    }
}
