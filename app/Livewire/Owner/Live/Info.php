<?php

namespace App\Livewire\Owner\Live;

use App\Models\Owner;
use App\Services\Owner\OwnerStatService;
use App\Traits\SyncData;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Info extends Component
{
    use SyncData;

    public Owner $owner;

    public object $viewers;

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

        $stats = $this->updateViewers();

        $percent = $this->owner->latestGoal?->getPercentage() ?? 0;

        if ($this->owner->isLive) {
            if ($this->owner->show_mode == null) {
                $state = "live";
            } else {
                $state = $this->owner->show_mode;
            }
            $type = 'badge border border-danger text-danger text-bold';
        } else if ($this->owner->isOnline) {
            $state = 'online';
            $type = 'badge border border-success text-success text-bold';
        } else {
            $state = 'offline';
            $type = 'badge border border-secondary text-secondary text-bold';
        }

        $historyGoals = $this->owner->latestGoal?->historyWithoutSpent;

        return view('livewire.owner.live.info', compact('state', 'type', 'percent', 'stats', 'historyGoals'));
    }

    private function updateViewers()
    {
        $owner = $this->owner;
        $cacheKey = "members_list_" . $owner->username;

        $stat = Cache::remember($cacheKey, 15, function () use ($owner) {
            $stat = app(OwnerStatService::class)->syncStreamStat($owner);

            if ($stat == null) {
                return null;
            }

            $leagueOrder = [
                'legend' => 1,
                'royal'  => 2,
                'diamond' => 3,
                'gold'   => 4,
                'silver' => 5,
                'bronze' => 6,
                'grey'   => 7
            ];

            $stat->members = collect($stat->members)->sort(function ($a, $b) use ($leagueOrder) {
                // If it doesn't exist, apply more weight.
                $leagueA = $leagueOrder[strtolower($a->ranking_league)] ?? 99;
                $leagueB = $leagueOrder[strtolower($b->ranking_league)] ?? 99;

                if ($leagueA !== $leagueB) {
                    return $leagueA <=> $leagueB;
                }

                return $b->ranking_level <=> $a->ranking_level;
            })->values()->all(); // values() resetea las llaves numéricas del array

            return $stat;
        });
        return $stat;
    }
}
