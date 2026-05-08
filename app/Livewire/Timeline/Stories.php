<?php

namespace App\Livewire\Timeline;

use App\Models\Feed;
use Carbon\Carbon;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Stories extends Component
{
    public function render()
    {
        $stories = $this->getStories();

        return view('livewire.timeline.stories', compact('stories'));
    }

    public function placeholder()
    {
        return view('livewire.timeline.stories-placeholder');
    }

    public function getStories()
    {
        $stories = Feed::query()
            ->where('updatedAt', '>', now()->subDays(1))
            ->whereIn('type', ['offlineStatusChanged'])
            ->orderByDesc('updatedAt')
            ->get();

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

                    // dd($data->data->offlineStatus ?? $data);

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
