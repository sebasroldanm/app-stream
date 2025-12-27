<?php

namespace App\Livewire\Owner\TopNav;

use GuzzleHttp\Client;
use Livewire\Component;

class Conversations extends Component
{
    public function render()
    {
        $data = $this->getConversations();
        return view('components.layouts.top-nav.conversations', [
            'data' => $data
        ]);
    }

    public function getConversations()
    {
        $client = new Client([
            'verify' => false,
            'timeout' => 15,
        ]);

        $url = env('API_SERVER') . '/api/front/v2/users/' . env('COOKIE_CLIENT') . '/conversations';

        $response = $client->get($url, [
            'headers' => [
                'accept'        => 'application/json, text/plain, */*',
                'user-agent'    => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'front-version' => '11.4.72',
                'cookie' => env('COOKIE_SERVER'),
            ],
            'query' => [
                'offset' => 0,
                'limit' => 10,
                'uniq'   => 'd1jm8zxot9vipqgf',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
