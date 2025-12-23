<?php

namespace App\Livewire;

use App\Models\Album;
use App\Models\Customer;
use App\Models\Intro;
use App\Models\Owner;
use App\Models\Panel;
use App\Models\Video;
use App\Traits\SyncData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewOwner extends Component
{
    use SyncData;

    public $username;
    public $id_owner;
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

    public function mount($username)
    {
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
        // //PROV
        // $this->syncOwnerByUsername($this->username);
        // //PROV
        $escapedOwner = str_replace('-', '\\-', $this->username);
        $owner = Owner::whereRaw("MATCH(username) AGAINST(? IN BOOLEAN MODE)", ['"' . $escapedOwner . '"'])->first();
        $new_username = "";
        if (empty($owner)) {
            $new_username = $this->syncOwnerByUsername($this->username);
            $owner = Owner::whereRaw("MATCH(username) AGAINST(? IN BOOLEAN MODE)", ['"' . $escapedOwner . '"'])->first();
        }
        
        if (!empty($new_username) && is_string($new_username)) {
            $this->username = $new_username;
        }
        
        if (is_null($owner) || strcasecmp($owner->username, $this->username) !== 0) {
            $this->error_search = true;
            $own_id = $this->syncOwnerByUsername($this->username);
            $owner = Owner::find($own_id);
            // $owner = Owner::where('username', $this->username)->first();
        }

        if (is_null($owner)) {
            return view('livewire.404');
        }

        $owner->data = json_decode($owner->data);
        if (!isset($owner->data->user)) {
            $own_id = $this->syncOwnerByUsername($this->username);
            if ($own_id) {
                $owner = Owner::find($own_id);
            }
        }
        $this->id_owner = $owner->id;
        $intro = Intro::where('owner_id', $owner->id)->orderBy('id', 'desc')->first();
        $albums = Album::with('photos')->where('owner_id', $owner->id)->get();
        $videos = Video::where('owner_id', $owner->id)->limit($this->limitVideos)->get();
        $panels = Panel::where('owner_id', $owner->id)->limit($this->limitPanels)->get();

        if ($intro) {
            $intro->data = json_decode($intro->data);
            if ($intro->type == 'video') {
                $intro->url = array_values(get_object_vars($intro->data->video->trailers))[0];
            }
        } else {
            $intro = new Intro();
            $intro->type = 'avatar';
            $intro->url = ($owner->avatar !== "") ? $owner->avatar : $owner->preview;
        }

        if ($owner->avatar !== "") {
            $owner->pic_profile = $owner->avatar;
        } elseif ($owner->preview !== "") {
            $owner->pic_profile = $owner->preview;
        } else {
            $owner->pic_profile = 'https://placehold.co/150x150?text=Profile+Pic';
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
}
