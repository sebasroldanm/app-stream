<?php

namespace App\Livewire;

use App\Models\Owner;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Psy\CodeCleaner\AssignThisVariablePass;

class Conversations extends Component
{
    public $selectedConversation;
    public $messages;

    public function render()
    {
        $conversations = $this->getConversations();



        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.conversations', compact('conversations'));

        return $view->layoutData(['title' => 'Conversations']);
    }

    public function selectConversation($idMessage)
    {
        $this->selectedConversation = $idMessage;
        $this->messages = $this->getOwnerMessages($idMessage);
    }

    public function getConversations()
    {
        $cookieClient = env('COOKIE_CLIENT');
        $cacheKey = 'conversations_user_' . $cookieClient;

        $conversations = Cache::remember($cacheKey, now()->addHours(2), function () use ($cookieClient) {

            $client = new Client([
                'verify' => false,
                'timeout' => 15,
            ]);

            $url = env('API_SERVER') . '/api/front/v2/users/' . $cookieClient . '/conversations';
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
                    'cookie'        => env('COOKIE_SERVER'),
                ],
                'query' => $query
            ]);

            $data = json_decode($response->getBody()->getContents());

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
        $cacheKey = 'messages_' . $cookieClient . '_' . $idMessage;

        $messages = Cache::remember($cacheKey, now()->addHours(2), function () use ($cookieClient, $idMessage, $beforeIdMessage) {

            $client = new Client([
                'verify' => false,
                'timeout' => 15,
            ]);

            $url = env('API_SERVER') . '/api/front/v2/users/' . $cookieClient . '/conversations' . '/' . $idMessage;
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
        });

        return $messages;
    }
}
