<?php

namespace App\Services\Owner;

use GuzzleHttp\Client;

class OwnerConversationService
{
    public function getConversations($cookieClient, $offset, $limit)
    {
        $client = new Client([
            'verify' => false,
            'timeout' => 15,
        ]);

        $url = env('API_SERVER') . '/api/front/v2/users/' . $cookieClient . '/conversations';
        $query = [
            'offset' => $offset,
            'limit' => $limit,
            'uniq'   => 'f0h9ck6ub3vra2t1',
        ];

        $response = $client->get($url, [
            'headers' => [
                'accept'        => 'application/json, text/plain, */*',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36',
                'front-version' => '11.4.72',
                'cookie'        => env('COOKIE_SERVER'),
            ],
            'query' => $query
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getOwnerMessages($cookieClient, $idMessage, $beforeIdMessage = null)
    {
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
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36',
                'front-version' => '11.4.72',
                'cookie' => env('COOKIE_SERVER'),
            ],
            'query' => $query
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
