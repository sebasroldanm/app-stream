<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use App\Services\Owner\OwnerChatService;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Chat extends Component
{
    public Owner $owner;

    public function mount(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function placeholder()
    {
        return view('livewire.owner.live.chat-placeholder');
    }

    public function render()
    {
        $messages = $this->chat();

        $messages->transform(function ($message) {
            $message->elapsedTime = $message->createdAt->diffForHumans(null, CarbonInterface::DIFF_RELATIVE_TO_NOW, true);
            return $message;
        });

        return view('livewire.owner.live.chat', [
            'messages' => $messages
        ]);
    }

    private function chat()
    {
        $chatService = app(OwnerChatService::class);
        return $chatService->syncSuperChats($this->owner);
    }
}
