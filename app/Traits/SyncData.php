<?php

namespace App\Traits;

use App\Models\Album;
use App\Models\Intro;
use App\Models\Log;
use App\Models\Owner;
use App\Models\Panel;
use App\Models\Photos;
use App\Models\Video;
use Carbon\Carbon;
use GuzzleHttp\Client;

trait SyncData
{
    public function syncOwnerByUsername($username)
    {
        $client = new Client();

        try {
            $response = $client->request('GET', env('API_PROXY') . env('API_SERVER') . '/api/front/v2/models/username/' . $username . '/cam');

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, true);
                if (isset($data['user']) && isset($data['user']['user'])) {
                    $dataUser = $data['user']['user'];
                    $owner = Owner::find($dataUser['id']);
                    if (!$owner) {
                        $owner = new Owner();
                        $owner->id = $dataUser['id'];
                    }
                    $owner->name = $dataUser['name'];
                    $owner->username = $dataUser['username'];
                    $owner->avatar = (isset($dataUser['avatarUrlOriginal']) && !empty($dataUser['avatarUrlOriginal'])) ? $dataUser['avatarUrlOriginal'] : $dataUser['avatarUrl'];
                    $owner->preview = $dataUser['previewUrl'];
                    $owner->gender = $dataUser['gender'];
                    $owner->country = $dataUser['country'];
                    $owner->isMobile = $dataUser['isMobile'];
                    $owner->statusChangedAt = Carbon::parse($dataUser['statusChangedAt']);
                    $owner->data = $response;
                    $owner->save();
                }
                return true;
            }
        } catch (\Throwable $th) {
            if (strpos($th->getMessage(), '"code":"500"')) {
                $owner = Owner::where('username', $username)->first();
                if (!$owner) {
                    $owner = new Owner();
                    $owner->username = $username;
                }
                $owner->isError = true;
                $owner->save();
            }
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
        }
        return false;
    }

    public function syncPanelByOwnerId($id)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', env('API_PROXY') . env('API_SERVER') . '/api/front/users/' . $id . '/panels');

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, true);
                if (isset($data["panels"])) {
                    $panels = $data["panels"];
                    if (count($panels) > 0) {
                        // $owner = Owner::find($id);
                        foreach ($panels as $data) {
                            $panel = Panel::find($data['id']);
                            if (!$panel) {
                                $panel = new Panel();
                                $panel->id = $data['id'];
                            }
                            $panel->title = $data['title'];
                            $panel->body = $data['body'];
                            $panel->imageUrl = $data['imageUrl'];
                            $panel->owner_id = $id;
                            $panel->order = $data['position']['order'];
                            $panel->column = $data['position']['column'];
                            $panel->data = json_encode($data);
                            $panel->createdAt = Carbon::parse($data['createdAt']);
                            $panel->save();

                            // if (!empty($panel->imageUrl)) {
                            //     $this->saveImage($panel->imageUrl, $owner->username, 'feed');
                            // }
                        }
                    }
                }
                return true;
            }
        } catch (\Throwable $th) {
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
        }
        return false;
    }

    public function syncAlbumByUsername($username)
    {
        $client = new Client();

        try {
            $response = $client->request('GET', env('API_PROXY') . env('API_SERVER') . '/api/front/users/username/' . $username . '/albums');

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, true);
                if (isset($data['albums'])) {
                    $albums = $data['albums'];
                    if (count($albums) > 0) {
                        $escapedOwner = str_replace('-', '\\-', $username);
                        $owner = Owner::whereRaw("MATCH(username) AGAINST(? IN BOOLEAN MODE)", ['"' . $escapedOwner . '"'])->first();
                        foreach ($albums as $data) {
                            $album = Album::find($data['id']);
                            if (!$album) {
                                $album = new Album();
                                $album->id = $data['id'];
                            }
                            $data_album = $data;
                            unset($data_album['photos']);
                            $album->owner_id = $owner->id;
                            $album->name = $data['name'];
                            $album->description = $data['description'];
                            $album->accessMode = $data['accessMode'];
                            $album->likes = $data['likes'];
                            $album->createdAt = Carbon::parse($data['createdAt']);
                            $album->data = json_encode($data_album);
                            $album->save();

                            if (isset($data['photos']) && count($data['photos']) > 0) {
                                $photos = $data['photos'];
                                foreach ($photos as $ph) {
                                    $photo = Photos::find($ph['id']);
                                    if (!$photo) {
                                        $photo = new Photos();
                                        $photo->id = $ph['id'];
                                    }
                                    $photo->albumId = $album->id;
                                    $photo->ownerId = $owner->id;
                                    $photo->order = $ph['order'];
                                    $photo->isNew = $ph['isNew'];
                                    $photo->url = isset($ph['url']) ? $ph['url'] : '';
                                    $photo->urlThumb = isset($ph['urlThumb']) ? $ph['urlThumb'] : '';
                                    $photo->urlPreview = isset($ph['urlPreview']) ? $ph['urlPreview'] : '';
                                    $photo->urlThumbMicro = $ph['urlThumbMicro'] ? $ph['urlThumbMicro'] : '';
                                    $photo->createdAt = Carbon::parse($ph['createdAt']);
                                    $photo->data = json_encode($ph);
                                    $photo->save();
                                }
                            }
                        }
                    }
                }
                return true;
            }
        } catch (\Throwable $th) {
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
            return false;
        }
    }

    public function syncIntroByOwnerId($id)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', env('API_PROXY') . env('API_SERVER') . '/api/front/users/' . $id . '/intros');

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, true);
                $intro = Intro::find($data["id"]);
                if (!$intro) {
                    $intro = new Intro();
                    $intro->id = $data["id"];
                }
                $intro->type = $data["type"];
                $intro->url = $data[$data["type"]]["url"];
                $intro->data = $response;
                $intro->owner_id = $id;
                $intro->save();

                // if ($intro->type == 'image') {
                //     $this->saveImage($data['image']['url'], $username, 'intro');
                // } else {
                //     $this->saveVideo($data['video']['url'], $username, 'intro');
                // }
            }
        } catch (\Throwable $th) {
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
        }
    }


    public function syncVideoByUsername($username)
    {
        $client = new Client();

        try {
            $response = $client->request('GET', env('API_PROXY') . env('API_SERVER') . '/api/front/users/username/' . $username . '/videos');

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, true);
                if (isset($data['videos']) && count($data['videos']) > 0) {
                    $escapedOwner = str_replace('-', '\\-', $username);
                    $owner = Owner::whereRaw("MATCH(username) AGAINST(? IN BOOLEAN MODE)", ['"' . $escapedOwner . '"'])->first();
                    $videos = $data['videos'];
                    foreach ($videos as $data) {
                        $video = Video::find($data['id']);
                        // dd($data);
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
                        $video->videoUrl = isset($data['videoUrl']) ? $data['videoUrl'] : null;
                        $video->data = json_encode($data);
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
}
