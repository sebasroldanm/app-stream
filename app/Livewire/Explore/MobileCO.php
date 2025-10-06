<?php

namespace App\Livewire\Explore;

use App\Models\Customer;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            $url = env('API_SERVER') . '/api/front/models';

            $response = $client->get($url, [
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'PostmanRuntime/7.39.0',
                    'Accept' => '*/*',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive'
                ],
                'query' => [
                    'limit' => 60,
                    'offset' => 0,
                    'primaryTag' => 'girls',
                    'filterGroupTags' => '[["tagLanguageColombian"],["mobile"]]',
                    'sortBy' => 'trending', // stripRanking
                    'parentTag' => 'mobile',
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
            Log::error($th->getMessage());
        }
    }
}
