<?php

namespace App\Livewire;

use App\Models\Owner;
use App\Models\Post;
use App\Models\TelegramChat;
use App\Models\TelegramMessage;
use Livewire\Component;
use Livewire\WithPagination;

class PostManagement extends Component
{
    use WithPagination;

    public $selectedChat;
    public $messageSearch = '';

    public $searchOwner = [];
    public $searchResults = [];
    public $selectedOwnerId = [];
    public $selectedOwnerUsername = [];

    public function render()
    {
        $telegram_chats = TelegramChat::all();

        $messages = collect();
        if ($this->selectedChat) {
            $messages = TelegramMessage::with(['captions', 'photo', 'video', 'post.owner'])
                ->where('fk_telegram_chats_id', $this->selectedChat->id)
                ->when($this->messageSearch, function ($query) {
                    $query->where('text', 'like', '%' . $this->messageSearch . '%');
                })
                ->paginate(10);
        }

        $this->dispatch('initFullviewer');

        return view('livewire.post-management', compact('telegram_chats', 'messages'));
    }

    public function updatingMessageSearch()
    {
        $this->resetPage();
    }

    public function viewPosts($chatId)
    {
        $this->selectedChat = TelegramChat::find($chatId);
        $this->resetPage();
    }

    public function updatedSearchOwner($value, $key)
    {
        if (strlen($value) < 3) {
            $this->searchResults[$key] = [];
            return;
        }

        $this->searchResults[$key] = Owner::where('username', 'like', '%' . $value . '%')
            ->orWhere('name', 'like', '%' . $value . '%')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function selectOwner($id, $ownerId, $ownerUsername)
    {
        $this->selectedOwnerId[$id] = $ownerId;
        $this->selectedOwnerUsername[$id] = $ownerUsername;
        $this->searchResults[$id] = [];
        $this->searchOwner[$id] = '';
    }

    public function assignOwner($id)
    {
        $message = TelegramMessage::find($id);
        if (!$message) return;

        $ownerId = $this->selectedOwnerId[$id] ?? null;
        if (!$ownerId) return;

        $messageIds = [$id];
        if ($message->id_message_parent) {
            $messageIds = TelegramMessage::where('id_message_parent', $message->id_message_parent)
                ->pluck('id')
                ->toArray();
        }

        foreach ($messageIds as $msgId) {
            Post::updateOrCreate(
                ['fk_telegram_messages_id' => $msgId],
                ['fk_owners_id' => $ownerId]
            );
        }

        // Reset state for the messages in the group
        foreach ($messageIds as $msgId) {
            unset($this->selectedOwnerId[$msgId]);
            unset($this->selectedOwnerUsername[$msgId]);
            unset($this->searchOwner[$msgId]);
            unset($this->searchResults[$msgId]);
        }
    }
}
