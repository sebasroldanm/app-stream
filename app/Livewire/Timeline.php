<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Feed;
use App\Models\Owner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Timeline extends Component
{
    // public $feeds = []; // Removed to prevent large payload
    public $owner_birthday = [];
    public $owner_fav = [];
    public $limit = 10;

    public function loadMore()
    {
        $this->limit += 10;
    }

    public function render()
    {
        $favs = Customer::find(Auth::guard('customer')->user()->id)->getOwnerFavoriteIds()->toArray();

        // Cache depends on limit now
        $feeds = Cache::remember('timeline_limit_' . $this->limit, 1, function () {
            return Feed::with(["owner", "albumFeed.photos", "videoFeed", "postFeed.mediaPostFeeds"])
                ->orderBy("updatedAt", "desc")
                ->orderBy("id", "desc")
                ->limit($this->limit)
                ->get();
        });

        $today = Carbon::now();
        // Cache::forget('timeline_birthdays');
        $this->owner_birthday = Cache::remember('timeline_birthdays', 1440, function () use ($today) {
            return Owner::select("username", "avatar", "birthDate", "age")
                ->whereNotNull("birthDate")
                ->orderByRaw(
                    "
                        CASE
                            -- Manejo especial para 29/02
                            WHEN DATE_FORMAT(birthDate, '%m-%d') = '02-29' THEN
                                CASE
                                    -- Si el año objetivo es bisiesto, usar 29/02
                                    WHEN (
                                        MOD(
                                            (YEAR(CURDATE()) +
                                                (DATE_FORMAT(birthDate, '%m-%d') < DATE_FORMAT(CURDATE(), '%m-%d'))
                                            ),
                                            400
                                        ) = 0
                                        OR (
                                            MOD(
                                                (YEAR(CURDATE()) +
                                                    (DATE_FORMAT(birthDate, '%m-%d') < DATE_FORMAT(CURDATE(), '%m-%d'))
                                                ),
                                                4
                                            ) = 0
                                            AND MOD(
                                                (YEAR(CURDATE()) +
                                                    (DATE_FORMAT(birthDate, '%m-%d') < DATE_FORMAT(CURDATE(), '%m-%d'))
                                                ),
                                                100
                                            ) <> 0
                                        )
                                    )
                                    THEN STR_TO_DATE(
                                        CONCAT(
                                            YEAR(CURDATE()) +
                                                (DATE_FORMAT(birthDate, '%m-%d') < DATE_FORMAT(CURDATE(), '%m-%d')),
                                            DATE_FORMAT(birthDate, '-%m-%d')
                                        ),
                                        '%Y-%m-%d'
                                    )
                                    -- Si NO es bisiesto → usar 28/02
                                    ELSE STR_TO_DATE(
                                        CONCAT(
                                            YEAR(CURDATE()) +
                                                (DATE_FORMAT(birthDate, '%m-%d') < DATE_FORMAT(CURDATE(), '%m-%d')),
                                            '-02-28'
                                        ),
                                        '%Y-%m-%d'
                                    )
                                END

                            -- Fechas normales
                            ELSE STR_TO_DATE(
                                CONCAT(
                                    YEAR(CURDATE()) +
                                        (DATE_FORMAT(birthDate, '%m-%d') < DATE_FORMAT(CURDATE(), '%m-%d')),
                                    DATE_FORMAT(birthDate, '-%m-%d')
                                ),
                                '%Y-%m-%d'
                            )
                        END
                    "
                )
                ->limit(30)
                ->get();
        });

        // Cache::forget('timeline_favs');
        $this->owner_fav = Cache::remember('timeline_favs', 20, function () use ($favs) {
            return Owner::whereIn('id', $favs)
                ->where('isOnline', true)
                ->limit(6)
                ->orderBy('favoritedCount', 'desc')
                ->get();
        });

        $this->dispatch('initFullviewer');

        $this->dispatch('initVideosFeed');

        return view('livewire.timeline', [
            'feeds' => $feeds
        ]);
    }
}
