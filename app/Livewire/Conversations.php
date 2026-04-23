<?php

namespace App\Livewire;

use App\Models\Owner;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;
use Psy\CodeCleaner\AssignThisVariablePass;

class Conversations extends Component
{
    public $selectedConversation;
    public $messages;

    public function render()
    {
        $conversations = $this->getConversations();

        foreach ($conversations->conversations as $conv) {
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
        
        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.conversations', compact('conversations'));

        return $view->layoutData(['title' => 'Conversations']);
    }

    public function selectConversation($idMessage)
    {
        $this->selectedConversation = $idMessage;
        $this->messages = $this->getOwnerMessages($idMessage);
        // dd($this->messages);
    }

    public function getConversations()
    {
        $client = new Client([
            'verify' => false,
            'timeout' => 15,
        ]);

        $url = env('API_SERVER') . '/api/front/v2/users/' . env('COOKIE_CLIENT') . '/conversations';
        $query = [
            'offset' => 0,
            'limit' => 10,
            'uniq'   => 'f0h9ck6ub3vra2t1',
        ];

        $response = $client->get($url, [
            'headers' => [
                'accept'        => 'application/json, text/plain, */*',
                'user-agent'    => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'front-version' => '11.4.72',
                'cookie' => env('COOKIE_SERVER'),
            ],
            'query' => $query
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getOwnerMessages($idMessage, $beforeIdMessage = null)
    {
        $client = new Client([
            'verify' => false,
            'timeout' => 15,
        ]);

        $url = env('API_SERVER') . '/api/front/v2/users/' . env('COOKIE_CLIENT') . '/conversations' . '/' . $idMessage;
        $query = [
            'offset' => 0,
            'limit' => 10,
            'uniq'   => 'f0h9ck6ub3vra2t1',
        ];

        if ($beforeIdMessage) {
            $query['beforeMassMessageId'] = $beforeIdMessage;
        }

        $response = $client->get($url, [
            'headers' => [
                'accept'        => 'application/json, text/plain, */*',
                'user-agent'    => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'front-version' => '11.4.72',
                'cookie' => env('COOKIE_SERVER'),
            ],
            'query' => $query
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
