<?php

namespace App\Livewire;

use App\Models\Feed;
use App\Traits\SyncData;
use Carbon\Carbon;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Stories extends Component
{
    use SyncData;

    public $owner_id;

    public function render()
    {
        $stories = $this->getStories();

        if ($stories) {
            return view('components.stories.stories', [
                'stories' => $stories,
                'owner_id' => $this->owner_id
            ]);
        }

        return "<div></div>";
    }

    public function placeholder()
    {
        return view('components.stories.stories-placeholder');
    }

    public function getStories()
    {
        if ($this->owner_id) {
            $stories = Feed::query()
                ->whereIn('type', ['offlineStatusChanged'])
                ->where('owner_id', $this->owner_id)
                ->orderByDesc('updatedAt')
                ->get();
        } else {
            $stories = Feed::query()
                ->where('updatedAt', '>', now()->subDays(1))
                ->whereIn('type', ['offlineStatusChanged'])
                ->orderByDesc('updatedAt')
                ->get();
        }

        $stories = $stories
            ->groupBy('owner_id')
            ->map(function ($userStories, $ownerId) {

                // Primer story del usuario (la más reciente)
                $firstStory = $userStories->first();

                // Usuario relacionado
                $user = $firstStory->owner;

                $username = $user->username;
                $avatar = $user->pic_profile;

                $contents = [];

                foreach ($userStories as $story) {
                    $data = $story->data;

                    $contents[] = [
                        'type' => 'text',
                        'textContent' => $data->data->offlineStatus,
                        'duration' => 8000,
                        'timeAgo' => Carbon::parse($story->updatedAt)->diffForHumans(null, false, true, 1),
                    ];
                }

                return [
                    'username' => $username,
                    'avatar' => $avatar,
                    'contents' => $contents,
                ];
            })
            ->values()
            ->toArray();

        return $stories;
    }
}
