<?php

namespace App\Livewire\Owner\Information;

use App\Models\Owner;
use GuzzleHttp\Client;
use Livewire\Component;

class Similarity extends Component
{
    public Owner $owner;

    public $similarity;
    public $see_full = false;

    public function render()
    {
        $this->initSimility();

        return view('livewire.owner.information.similarity');
    }

    public function seeFull()
    {
        $this->see_full = !$this->see_full;
    }

    private function initSimility()
    {
        $client = new Client();

        $this->similarity = collect();

        try {
            $response = $client->request('GET', env('API_IA_SIMILARITY') . $this->owner->username . '/similar');
            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, false);
                foreach ($data as $key => $lote) {
                    foreach ($lote as $key => $result) {
                        $this->similarity->push((object) $result);
                    }
                }
            }

            $this->similarity = $this->similarity->sortBy('distance')->take(50);
        } catch (\Throwable $th) {
            $this->similarity = false;
        }
    }
}
