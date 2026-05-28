<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use App\Traits\SyncData;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Info extends Component
{
    use SyncData;

    public Owner $owner;

    public object $viewers;

    public $percent = 0;

    public $lastState = [];

    public $views_count = 0;

    public function placeholder()
    {
        return view('livewire.owner.live.info-placeholder');
    }

    public function render()
    {
        $this->syncOwnerByUsername($this->owner->username);

        $this->owner = Owner::where('id', $this->owner->id)->first();

        // Detectar cambios de estado
        $currentState = [
            'isLive' => $this->owner->isLive,
            'isOnline' => $this->owner->isOnline,
            'showMode' => $this->owner->show_mode,
            'snapshot' => $this->owner->snapshot_timestamp,
        ];

        if ($this->lastState !== null && $this->lastState !== $currentState) {
            $this->dispatch('owner-status-updated');
        }
        $this->lastState = $currentState;

        $this->viewers = $this->updateViewers();

        $this->views_count = $this->viewers->guests + $this->viewers->spies + $this->viewers->invisibles + $this->viewers->greens + $this->viewers->golds + $this->viewers->regulars;

        $this->percent = $this->owner->latestGoal?->getPercentage() ?? 0;

        if ($this->owner->isLive) {
            if ($this->owner->show_mode == null) {
                $state = "Live";
            } else {
                $state = $this->owner->show_mode;
            }
            $type = 'badge border border-danger text-danger text-bold';
        } else if ($this->owner->isOnline) {
            $state = 'Online';
            $type = 'badge border border-success text-success text-bold';
        } else {
            $state = 'Offline';
            $type = 'badge border border-secondary text-secondary text-bold';
        }

        $historyGoals = $this->owner->latestGoal?->historyWithoutSpent;

        // dd($historyGoals);

        return view('livewire.owner.live.info', compact('state', 'type', 'historyGoals'));
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
