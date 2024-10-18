<?php

namespace App\Livewire;

use App\Models\Album;
use App\Models\Customer;
use App\Models\Intro;
use App\Models\Log;
use App\Models\Owner;
use App\Models\Panel;
use App\Models\Photos;
use App\Models\Video;
use App\Traits\SyncData;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewMod extends Component
{
    use SyncData;

    public $mod;

    public $id_mod;

    public $limitAlbums = 6;
    public $limitVideos = 50;
    public $limitPanels = 6;

    public $status_owner = false;
    public $status_panel = false;
    public $status_photos = false;

    public function mount($mod)
    {
        $this->mod = $mod;
    }

    public function render()
    {
        $result = Owner::where('username', $this->mod)->first();
        $this->id_mod = $result->id;
        $intro = Intro::where('owner_id', $result->id)->first();
        $albums = Album::with('photos')->where('owner_id', $result->id)->get();
        $videos = Video::where('owner_id', $result->id)->limit($this->limitVideos)->get();
        $panels = Panel::where('owner_id', $result->id)->limit($this->limitPanels)->get();

        // dd($albums);
        // dd($intro);
        if ($intro) {
            $intro->content = json_decode($intro->content);
            if ($intro->type ==  'image') {
                $introImage = $intro->url;
            } else {
                $point = '720p';
                $introImage = $intro->content->previews->$point;
            }
        } else {
            $introImage = 'https://placehold.co/1000x300?text=Cover+Photo';
        }

        if (Auth::guard('customer')->check()) {
            $is_fav = DB::table('customer_owner_favorites')
                ->where('owner_id', $result->id)
                ->where('customer_id', Auth::guard('customer')->user()->id)
                ->exists();

            return view('livewire.view-mod', [
                'data_mod' => $result,
                'intro' => $introImage,
                'albums' => $albums,
                'videos' => $videos,
                'panels' => $panels,
                'status_owner' => $this->status_owner,
                'status_panel' => $this->status_panel,
                'is_fav' => $is_fav
            ]);
        } else {
            return view('livewire.view-mod', [
                'data_mod' => $result,
                'intro' => $introImage,
                'albums' => $albums,
                'panels' => $panels,
                'status_owner' => $this->status_owner,
                'status_panel' => $this->status_panel,
                'videos' => $videos,
            ]);
        }
    }

    public function updateDataMod()
    {
        $this->status_owner = $this->syncOwnerByUsername($this->mod);

        $this->status_panel = $this->syncPanelByOwnerId($this->id_mod);

        $this->status_photos = $this->syncAlbumByUsername($this->mod);

        // $this->updateDataVideo();
    }

    public function updateDataVideo()
    {
        $client = new Client();

        try {
            $response = $client->request('GET', env('API_PROXY') . env('API_SERVER') . '/api/front/users/username/' . $this->mod . '/videos');

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, true);
                if (isset($data['videos']) && count($data['videos']) > 0) {
                    $owner = Owner::where('username', $this->username)->first();
                    $videos = $data['videos'];
                    foreach ($videos as $data) {
                        $video = Video::find($data['id']);
                        if (!$video) {
                            $video = new Video();
                            $video->id = $data['id'];
                        }
                        $video->owner_id = $owner->id;
                        $video->title = $data['title'];
                        $video->description = $data['description'];
                        $video->accessMode = $data['accessMode'];
                        $video->duration = $data['duration'];
                        $video->coverUrl = $data['coverUrl'];
                        $video->trailerUrl = $data['trailerUrl'];
                        $video->data = $response;
                        $video->save();
                    }
                }
            }
        } catch (\Throwable $th) {
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
        }
    }

    public function toggleFavorite()
    {
        $auth_customer = Auth::guard('customer')->user();
        $owner = Owner::findOrFail($this->id_mod);

        $customer = Customer::find($auth_customer->id);
        $customer->toggleOwnerFavorite($owner);
    }
}
