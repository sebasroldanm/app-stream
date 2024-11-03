<?php

namespace App\Livewire\Explore;

use GuzzleHttp\Client;
use Livewire\Component;

class MobileCO extends Component
{

    public $data;
    public $limit = 60;
    public $offset = 0;

    public function render()
    {
        $this->loadData();

        return view('livewire.explore.mobile-c-o');
    }

    public function prevPage()
    {
        $this->offset -= 60;
    }

    public function nextPage()
    {
        $this->offset += 60;
    }

    private function loadData()
    {
        $client = new Client();

        try {
            $url = "models?limit=" . $this->limit . "&offset=" . $this->offset . "&primaryTag=girls&filterGroupTags=%5B%5B%22tagLanguageColombian%22%5D%2C%5B%22mobile%22%5D%5D&sortBy=stripRanking&parentTag=mobile";
            $url = env('API_SERVER') . '/api/front/' . $url;

            $data = [
                's' => $url
            ];

            $response = $client->post(env('API_PROXY_SERVER') . 'testOTP', [
                'verify' => false,
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $this->data = json_decode($response, false);
            } else {
                $this->data = false;
            }
        } catch (\Throwable $th) {
            $this->data = false;
        }
    }
}
