<?php

namespace App\Livewire;

use App\Models\Album;
use App\Models\Customer;
use App\Models\Intro;
use App\Models\Owner;
use App\Models\Panel;
use App\Models\Video;
use App\Traits\SyncData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewOwner extends Component
{
    use SyncData;

    public $username;
    public $id_owner;
    public $isBanned = false;
    public $error_search = false;

    public $limitAlbums = 6;
    public $limitVideos = 50;
    public $limitPanels = 6;

    public $status_owner = false;
    public $status_panel = false;
    public $status_photos = false;
    public $status_intro = false;
    public $status_video = false;
    public $status_feed = false;

    public $showError = false;
    public $showFeed = true;
    public $showInformation = false;
    public $showAlbums = false;
    public $showVideos = false;
    public $showLive = false;

    public $force_sync = false;

    public function mount($username)
    {
        if (is_numeric($this->username)) {
            $owner = Owner::find($this->username);
            return redirect()->route('owner.feed', $owner->username);
        }

        $this->username = $username;

        $routeName = request()->route()->getName();

        match ($routeName) {
            'owner.feed' => $this->loadComponent('feed'),
            'owner.albums' => $this->loadComponent('albums'),
            'owner.videos' => $this->loadComponent('videos'),
            'owner.information' => $this->loadComponent('information'),
            'owner.live' => $this->loadComponent('live'),
            default => $this->loadComponent('feed'),
        };
    }

    public function loadComponent($component)
    {
        switch ($component) {
            case 'feed':
                $this->showFeed = true;
                $this->showInformation = false;
                $this->showAlbums = false;
                $this->showVideos = false;
                $this->showLive = false;
                break;
            case 'information':
                $this->showFeed = false;
                $this->showInformation = true;
                $this->showAlbums = false;
                $this->showVideos = false;
                $this->showLive = false;
                break;
            case 'albums':
                $this->showFeed = false;
                $this->showInformation = false;
                $this->showAlbums = true;
                $this->showVideos = false;
                $this->showLive = false;
                break;
            case 'videos':
                $this->showFeed = false;
                $this->showInformation = false;
                $this->showAlbums = false;
                $this->showVideos = true;
                $this->showLive = false;
                break;
            case 'live':
                $this->showFeed = false;
                $this->showInformation = false;
                $this->showAlbums = false;
                $this->showVideos = false;
                $this->showLive = true;
                break;
        }
    }

    public function render()
    {
        // Search simple and direct by username
        $owner = Owner::whereRaw('LOWER(username) = LOWER(?)', [$this->username])->first();

        // If not exists locally, sync once
        if (is_null($owner)) {
            $result = $this->syncOwnerByUsername($this->username);
            $owner  = $this->resolveOwnerFromSyncResult($result, $this->username);
        }

        if (is_null($owner)) {
            return view('livewire.404');
        }

        // Update canonical username if changed
        $this->username = $owner->username;

        // Re-sync only if cache is expired (>1 hour)
        $needsSync = is_null($owner->lastSync)
            || Carbon::parse($owner->lastSync)->diffInHours(Carbon::now()) > 1;

        // Re-sync if data is incomplete
        $ownerData  = $owner->data;
        $needsSync  = $needsSync || !isset($ownerData->user);

        if ($needsSync) {
            $result = $this->syncOwnerByUsername($this->username);
            $owner  = $this->resolveOwnerFromSyncResult($result, $this->username);
            $ownerData = $owner->data;
        }

        $this->isBanned = $owner->isBanned || $owner->isBlocked || $owner->isGeoBanned || !$owner->isActive || !$owner->isProfileAvailable;

        if (is_null($owner)) {
            return view('livewire.404');
        }

        // Redirect if canonical username differs
        if (strcasecmp($this->username, $owner->username) !== 0) {
            return redirect()->route('owner.feed', $owner->username);
        }

        $owner->data = $ownerData;
        $this->id_owner = $owner->id;

        $intro = Intro::where('owner_id', $owner->id)->orderBy('id', 'desc')->first();
        $albums = Album::with('photos')->where('owner_id', $owner->id)->get();
        $videos = Video::where('owner_id', $owner->id)->limit($this->limitVideos)->get();
        $panels = Panel::where('owner_id', $owner->id)->limit($this->limitPanels)->get();

        if ($intro) {
            if ($intro->type == 'video') {
                $intro->url = array_values(get_object_vars($intro->data->video->trailers))[0];
            }
        } else {
            $intro = new Intro();
            $intro->type = 'avatar';
            $intro->url = ($owner->avatar !== "") ? $owner->avatar : $owner->preview;
        }

        if (Auth::guard('customer')->check()) {
            $is_fav = DB::table('customer_owner_favorites')
                ->where('owner_id', $owner->id)
                ->where('customer_id', Auth::guard('customer')->user()->id)
                ->exists();

            $is_related = $owner->getRelatedOwnersAttribute();

            /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
            $view = view('livewire.view-owner', [
                'owner' => $owner,
                'intro' => $intro,
                'albums' => $albums,
                'videos' => $videos,
                'panels' => $panels,
                'is_fav' => $is_fav,
                'is_related' => $is_related,
            ]);

            return $view->layoutData(['title' => ' | ' . $this->username]);
        } else {
            /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
            $view = view('livewire.view-owner', [
                'owner' => $owner,
                'intro' => $intro,
                'albums' => $albums,
                'panels' => $panels,
                'videos' => $videos,
                'is_fav' => false,
                'is_related' => false,
            ]);

            return $view->layoutData(['title' => ' | ' . $this->username]);
        }
    }

    public function updateDataMod()
    {
        $this->status_owner = $this->syncOwnerByUsername($this->username);

        $this->status_panel = $this->syncPanelByOwnerId($this->id_owner);

        $this->status_photos = $this->syncAlbum($this->id_owner, $this->username);

        $this->status_intro = $this->syncIntroByOwnerId($this->id_owner);

        $this->status_video = $this->syncVideo($this->id_owner, $this->username);

        $this->status_feed = $this->syncFeedByOwnerId($this->id_owner);

        return redirect()->route('owner.feed', ['username' => $this->username]);
    }

    public function toggleFavorite()
    {
        $auth_customer = Auth::guard('customer')->user();
        $owner = Owner::findOrFail($this->id_owner);

        $customer = Customer::find($auth_customer->id);
        $customer->toggleOwnerFavorite($owner);
    }

    public function verifyAsync()
    {
        $this->status_owner = $this->syncOwnerByUsername($this->username);
    }

    public function force_sync_enable()
    {
        $this->force_sync = true;
        Owner::where('id', $this->id_owner)->update(['notFound' => false]);
    }

    private function resolveOwnerFromSyncResult(mixed $result, string $username): ?Owner
    {
        if (is_numeric($result)) {
            return Owner::find($result);
        }
        return Owner::whereRaw('LOWER(username) = LOWER(?)', [$username])->first();
    }
}
