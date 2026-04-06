<?php

namespace App\Livewire;

use App\Models\Owner;
use App\Models\Post;
use App\Models\TelegramChat;
use App\Models\TelegramMessage;
use App\Services\TelegramService;
use Livewire\Component;
use Livewire\WithPagination;
use Telegram\Bot\Laravel\Facades\Telegram;

class PostManagement extends Component
{
    use WithPagination;

    public $selectedChat;
    public $messageSearch = '';

    public $searchOwner = [];
    public $searchResults = [];
    public $selectedOwnerId = [];
    public $selectedOwnerUsername = [];
    
    public $editingMessageId;
    public $editingCaption;
    public $isModalOpen = false;

    public function render()
    {
        $telegram_chats = TelegramChat::all();

        $messages = collect();
        if ($this->selectedChat) {
            $messages = TelegramMessage::with(['captions', 'photo', 'video', 'post.owner'])
                ->where('fk_telegram_chats_id', $this->selectedChat->id)
                ->when($this->messageSearch, function ($query) {
                    $query->where(function ($q) {
                        $q->where('text', 'like', '%' . $this->messageSearch . '%')
                        ->orWhereHas('captions', function ($q2) {
                            $q2->where('caption', 'like', '%' . $this->messageSearch . '%');
                        });
                    });
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

    public function selectChat($chatId)
    {
        $this->selectedChat = TelegramChat::with(['messages', 'messages.captions', 'messages.photo', 'messages.video', 'messages.post.owner'])->find($chatId);
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

    public function editCaption($messageId)
    {
        $message = TelegramMessage::with('captions')->find($messageId);
        if (!$message) return;

        $this->editingMessageId = $messageId;
        // Concatenate all captions parts into a single string for editing
        $this->editingCaption = $message->captions->sortBy('position')->pluck('caption')->implode('');
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['editingMessageId', 'editingCaption']);
    }

    public function saveCaption(TelegramService $telegramService)
    {
        $message = TelegramMessage::with('chat')->find($this->editingMessageId);
        if (!$message || !$message->chat) {
            $this->closeModal();
            return;
        }

        try {
            if (!is_null($message->text)) {
                $response = Telegram::editMessageText([
                    'chat_id' => '@' . $message->chat->username,
                    'message_id' => $message->message_id,
                    'text' => $this->editingCaption,
                ]);
            } else {
                $response = Telegram::editMessageCaption([
                    'chat_id' => '@' . $message->chat->username,
                    'message_id' => $message->message_id,
                    'caption' => $this->editingCaption,
                ]);
            }

            $content = $response->getCaption() ?? $response->getText();
            $entities = $response->getCaptionEntities() ?? $response->getEntities();

            $parsed = $telegramService->parseEntities($content, $entities);
            $telegramService->updateCaptions($message, $parsed);

            $message->update([
                'text' => $response->getText()
            ]);

            $this->closeModal();
            session()->flash('message', 'Caption actualizado correctamente.');
        } catch (\Exception $e) {
            // Log error or notify user
            session()->flash('error', 'Error al actualizar en Telegram: ' . $e->getMessage());
        }
    }
}
