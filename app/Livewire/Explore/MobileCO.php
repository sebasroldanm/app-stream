<?php

namespace App\Livewire\Explore;

use App\Models\Customer;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MobileCO extends Component
{

    public $data;
    public $owners = [];
    public $limit = 60;
    public $offset = 0;
    public $endResults = false;

    public function render()
    {
        $this->loadData();

        $favs = Customer::find(Auth::guard('customer')->user()->id)->getOwnerFavoriteIds()->toArray();

        $this->dispatch('initExplorer');
        
        return view('livewire.explore.mobile-c-o', [
            'favs' => $favs
        ]);
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
                array_push($this->owners, ...$this->data->models);
                if (count($this->data->models) !== 60) {
                    $this->endResults = true;
                }
            } else {
                $this->data = false;
            }
        } catch (\Throwable $th) {
            $this->data = false;
        }
    }
}
