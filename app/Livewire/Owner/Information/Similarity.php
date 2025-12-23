<?php

namespace App\Livewire\Owner\Information;

use App\Models\Owner;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
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
        $this->similarity = Cache::remember('owner_similarity_' . $this->owner->id, now()->addDay(), function () {
            $client = new Client();
            $similarity = collect();

            try {
                $response = $client->request('GET', env('API_IA_SIMILARITY') . $this->owner->username . '/similar');
                $statusCode = $response->getStatusCode();
                if ($statusCode === 200) {
                    $responseContent = $response->getBody()->getContents();
                    $data = json_decode($responseContent, false);
                    foreach ($data as $key => $lote) {
                        foreach ($lote as $key => $result) {
                            $similarity->push((object) $result);
                        }
                    }
                }

                return $similarity
                    ->unique('model')
                    ->sortBy('distance')
                    ->take(200);

            } catch (\Throwable $th) {
                return false;
            }
        });
    }
}
