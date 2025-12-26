<?php

namespace App\Livewire\Owner;

use App\Models\Customer;
use App\Models\Owner;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

use Livewire\Attributes\Lazy;

#[Lazy]
class Related extends Component
{
    public function placeholder()
    {
        return view('livewire.owner.related-skeleton');
    }
    public $owner;
    public $related;

    public function mount(Owner $owner)
    {
        $client = new Client();
        $this->owner = $owner;
        $url = env("API_SERVER") . "/api/front/models/username/" . $owner->username . "/related";
        try {
            $response = Cache::remember('related_' . $owner->username, 60, function () use ($client, $url) {
                $response = $client->get($url, [
                    'verify' => false,
                    'headers' => [
                        'User-Agent' => 'PostmanRuntime/7.39.0',
                        'Accept' => '*/*',
                        'Accept-Encoding' => 'gzip, deflate, br',
                        'Connection' => 'keep-alive'
                    ],
                    'query' => [
                        'limit' => 10,
                        'offset' => 0,
                        'primaryTag' => 'girls'
                    ]
                ]);
                return json_decode($response->getBody()->getContents());
            });
            $this->related = $response;
        } catch (\Exception $e) {
            $this->related = [];
        }
    }

    public function render()
    {
        sleep(5);
        $favs = Customer::find(Auth::guard('customer')->user()->id)->getOwnerFavoriteIds()->toArray();

        $this->dispatch('initSwiper');
        
        return view('livewire.owner.related', [
            'favs' => $favs
        ]);
    }
}
