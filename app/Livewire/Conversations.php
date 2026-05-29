<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
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
            $messages = is_array($data->messages) ? $data->messages : $data->messages->all();
            $data->messages = array_reverse($messages);
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
            $newMessages = is_array($newData->messages) ? $newData->messages : $newData->messages->all();
            $reversedNewMessages = array_reverse($newMessages);

            $currentMessages = is_array($this->messages->messages)
                ? $this->messages->messages
                : $this->messages->messages->all();

            $this->messages->messages = array_merge($reversedNewMessages, $currentMessages);

            $this->dispatch('messages-prepended', count($newData->messages));
        }
    }

    public function loadMoreConversations()
    {
        $this->conversationOffset += $this->conversationLimit;

        $newData = $this->getConversations($this->conversationOffset, $this->conversationLimit);

        if (isset($newData->conversations) && count($newData->conversations) > 0) {
            $currentConversations = is_array($this->conversationsData->conversations)
                ? $this->conversationsData->conversations
                : $this->conversationsData->conversations->all();

            $newConversations = is_array($newData->conversations)
                ? $newData->conversations
                : $newData->conversations->all();

            $this->conversationsData->conversations = array_merge(
                $currentConversations,
                $newConversations
            );
        }
    }

    public function getConversations($offset = 0, $limit = 10)
    {
        $conversationsList = Conversation::with(['owner', 'latestMessage'])
            ->orderBy('lastMessage', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

        return (object)[
            'conversations' => $conversationsList,
            'conversationsCount' => Conversation::count()
        ];
    }

    public function getOwnerMessages($idMessage, $beforeIdMessage = null)
    {
        $conversation = Conversation::with(['owner'])->find($idMessage);

        $messagesQuery = Message::where('conversation_id', $idMessage)
            ->with(['media.photos', 'media.videos']);

        if ($beforeIdMessage) {
            $messagesQuery->where('id', '<', $beforeIdMessage);
        }

        $messagesList = $messagesQuery->orderBy('createdAt', 'desc')
            ->limit(10)
            ->get();

        return (object)[
            'conversation' => $conversation,
            'messages' => $messagesList
        ];
    }
}
