<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use App\Traits\SyncData;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Info extends Component
{
    use SyncData;

    public Owner $owner;

    public $viewers = [];

    public $lastPercent = 0;
    public $percent = 0;

    public function render()
    {
        $this->syncOwnerByUsername($this->owner->username);

        $this->owner = Owner::where('id', $this->owner->id)->first();

        $this->viewers = $this->updateViewers();

        $this->owner->data = json_decode($this->owner->data);

        if (isset($this->owner->data->cam->goal->goal) && $this->owner->data->cam->goal->goal > 0) {
            $percent = ($this->owner->data->cam->goal->spent * 100) / $this->owner->data->cam->goal->goal;
            $this->percent = (round($percent) > 100) ? 100 : round($percent, 1);

            if ($this->lastPercent != $percent) {
                $this->lastPercent = $percent;
                $this->dispatch('updateBarInfo', [
                    'left' => $this->owner->data->cam->goal->left,
                    'goal' => $this->owner->data->cam->goal->goal,
                    'spent' => $this->owner->data->cam->goal->spent,
                    'description' => $this->owner->data->cam->goal->description,
                    'percent' => $this->percent,
                ]);
            }
        }

        // Implementar
        // https://design.spiderbees.com/bootstrap5/html-dark/chat.html

        return view('livewire.owner.live.info');
    }

    private function updateViewers()
    {
        $owner = $this->owner;
        $cacheKey = "members_list_" . $owner->username;

        $data = Cache::remember($cacheKey, 15, function () use ($owner) {
            $client = new Client();

            $url = env("API_SERVER") . "/api/front/models/username/" .   $owner->username . "/members";
            $response = $client->get($url, [
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'PostmanRuntime/7.39.0',
                    'Accept' => '*/*',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive'
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), false);

            $leagueOrder = [
                'legend' => 1,
                'royal'  => 2,
                'diamond' => 3,
                'gold'   => 4,
                'silver' => 5,
                'bronze' => 6,
                'grey'   => 7
            ];

            $data->members = collect($data->members)->sort(function ($a, $b) use ($leagueOrder) {
                // If it doesn't exist, apply more weight.
                $leagueA = $leagueOrder[strtolower($a->user->userRanking->league)] ?? 99;
                $leagueB = $leagueOrder[strtolower($b->user->userRanking->league)] ?? 99;

                if ($leagueA !== $leagueB) {
                    return $leagueA <=> $leagueB;
                }

                return $b->user->userRanking->level <=> $a->user->userRanking->level;
            })->values()->all(); // values() resetea las llaves numéricas del array

            return $data;
        });
        return $data;
    }
}
