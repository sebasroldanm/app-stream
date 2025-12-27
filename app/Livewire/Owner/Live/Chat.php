<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use GuzzleHttp\Client;
use Livewire\Component;

class Chat extends Component
{
    public Owner $owner;
    public $seenIds = [];

    public function mount(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function render()
    {
        $chat = $this->chat();
        $messages = collect($chat['messages']);
        
        $currentIds = [];
        $messages = $messages->map(function ($message) use (&$currentIds) {
            $id = $message['createdAt'];
            $currentIds[] = $id;

            $message['isNew'] = !empty($this->seenIds) && !in_array($id, $this->seenIds);
            
            $message['elapsedTime'] = Carbon::parse($message['createdAt'])->diffForHumans(null, CarbonInterface::DIFF_RELATIVE_TO_NOW, true);
            $message['createdAt'] = Carbon::parse($message['createdAt']);
            return $message;
        });

        // Actualizar los IDs vistos. Mantenemos una lista limitada.
        $this->seenIds = array_slice(array_unique(array_merge($this->seenIds, $currentIds)), -100);

        $messages = $messages->sortByDesc('createdAt');

        return view('livewire.owner.live.chat', [
            'messages' => $messages
        ]);
    }

    private function chat()
    {
        $client = new Client();
        $owner = $this->owner;
        $url = env("API_SERVER") . "/api/front/v2/models/" . $owner->id . "/chat";
        $response = $client->get($url, [
            'verify' => false,
            'headers' => [
                'User-Agent' => 'PostmanRuntime/7.39.0',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive'
            ],
            'query' => [
                'source' => 'regular'
            ],
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return $data;
    }
}
