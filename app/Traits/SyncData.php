<?php

namespace App\Traits;

use App\Jobs\UploadImageService;
use App\Models\Album;
use App\Models\AlbumFeed;
use App\Models\Feed;
use App\Models\Intro;
use App\Models\Log;
use App\Models\MediaPostFeed;
use App\Models\Owner;
use App\Models\Panel;
use App\Models\PhotoAlbumFeed;
use App\Models\Photos;
use App\Models\PostFeed;
use App\Models\Video;
use App\Models\VideoFeed;
use Carbon\Carbon;
use GuzzleHttp\Client;

trait SyncData
{
    use OwnerProp;

    public function syncOwnerByUsername($username)
    {
        $client = new Client();

        try {
            $url = env('API_SERVER') . '/api/front/v2/models/username/' . $username . '/cam';

            $response = $client->get($url, [
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'PostmanRuntime/7.39.0',
                    'Accept' => '*/*',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive'
                ]
            ]);

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
                    if (empty($dataUser['username'])) {
                        $owner->username = $username;
                        $owner->lastUsername = $this->addUsernameToHistory($owner->lastUsername, $username);
                    } else {
                        $owner->username = $dataUser['username'];
                        $owner->lastUsername = $this->addUsernameToHistory($owner->lastUsername, $dataUser['username']);
                    }
                    $owner->name = $dataUser['name'];
                    $owner->previousUsername = $dataUser['previousUsername'];
                    $owner->avatar = (isset($dataUser['avatarUrlOriginal']) && !empty($dataUser['avatarUrlOriginal'])) ? $dataUser['avatarUrlOriginal'] : $dataUser['avatarUrl'];
                    $owner->preview = $dataUser['previewUrl'];
                    $owner->gender = $dataUser['gender'];
                    $owner->country = $dataUser['country'];
                    $owner->isOnline = $dataUser['isOnline'];
                    $owner->isLive = $dataUser['isLive'];
                    $owner->isMobile = $dataUser['isMobile'];
                    $owner->isDelete = $dataUser['isDeleted'];
                    // Date update platform
                    $statusRaw = $dataUser['statusChangedAt'] ?? null;
                    if (empty($statusRaw) || $statusRaw === '0000-00-00' || $statusRaw === '0000-00-00 00:00:00') {
                        $owner->statusChangedAt = Carbon::parse('1970-01-01 00:00:01');
                    } else {
                        $owner->statusChangedAt = Carbon::parse($statusRaw)->subHours(5);
                    }
                    $owner->data = $response;
                    $owner->save();


                    return $owner->id;
                }
            }
        } catch (\Throwable $th) {
            // dd($th);
            if (strpos($th->getMessage(), '"code":"500"')) {
                $owner = Owner::where('username', $username)->first();
                if (!$owner) {
                    $owner = new Owner();
                    $owner->username = $username;
                }
                // $owner->isError = true;
                $owner->save();
            }
            if (strpos($th->getMessage(), '"newUsername"')) {
                $body = (string) $th->getMessage();
                $body = trim($body);
                $body = explode("\n", $body);
                $json = json_decode($body[1], true);
                $newUsername = $json['data']['newUsername'] ?? null;
                return $newUsername;
            }
            $log = new Log();
            $log->type = 'error';
            $log->message = $th->getMessage();
            $log->trace = $th->getTraceAsString();
            $log->save();
        }
        return false;
    }

    /**
     * Actualiza un historial JSON de usuarios con fecha.
     *
     * @param string|null $jsonHistory  El JSON actual (puede ser cadena vacía o null).
     * @param string      $username     El nombre de usuario a añadir.
     * @return string                   El JSON actualizado.
     */
    function addUsernameToHistory(?string $jsonHistory, string $username): string
    {
        // Si viene null o cadena vacía, lo consideramos como historial vacío
        if (empty($jsonHistory)) {
            $history = [];
        } else {
            // Decodificamos el JSON, y si falla (invalid JSON), también iniciamos array vacío
            $decoded = json_decode($jsonHistory, true);
            $history = (is_array($decoded) ? $decoded : []);
        }
        // Comprobamos duplicados
        foreach ($history as $entry) {
            if (isset($entry['username']) && $entry['username'] === $username) {
                // Ya existe: devolvemos el JSON tal cual (normalizado)
                return json_encode($history, JSON_UNESCAPED_UNICODE);
            }
        }

        // No existía: lo añadimos con la fecha de hoy (YYYY-MM-DD)
        $history[] = [
            'username' => $username,
            'date'     => date('Y-m-d'),
        ];

        return json_encode($history, JSON_UNESCAPED_UNICODE);
    }

    public function syncPanelByOwnerId($id)
    {
        $client = new Client();
        try {
            $url = env('API_SERVER') . '/api/front/users/' . $id . '/panels';
            
            $response = $client->get($url, [
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'PostmanRuntime/7.39.0',
                    'Accept' => '*/*',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive'
                ]
            ]);

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

    public function syncAlbum($id_owner, $username)
    {
        $client = new Client();

        try {

            $url = env('API_SERVER') . '/api/front/v2/users/username/' . $username . '/albums';
    
            $response = $client->get($url, [
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'PostmanRuntime/7.39.0',
                    'Accept' => '*/*',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive'
                ]
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, true);
                if (isset($data['albums'])) {
                    $albums = $data['albums'];
                    if (count($albums) > 0) {
                        foreach ($albums as $data) {
                            $album = Album::find($data['id']);
                            if (!$album) {
                                $album = new Album();
                                $album->id = $data['id'];
                            }
                            $data_album = $data;
                            unset($data_album['photos']);
                            $album->owner_id = $id_owner;
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
                                    $photo->ownerId = $id_owner;
                                    $photo->order = $ph['order'];
                                    $photo->isNew = $ph['isNew'];
                                    $photo->url = isset($ph['url']) ? $ph['url'] : '';
                                    $photo->urlThumb = isset($ph['urlThumb']) ? $ph['urlThumb'] : '';
                                    $photo->urlPreview = isset($ph['urlPreview']) ? $ph['urlPreview'] : '';
                                    $photo->urlThumbMicro = $ph['urlThumbMicro'] ? $ph['urlThumbMicro'] : '';
                                    $photo->createdAt = Carbon::parse($ph['createdAt']);
                                    $photo->data = json_encode($ph);
                                    $photo->save();

                                    if (!empty($photo->url) && empty($photo->picture_upload_id)) {
                                        // Upload photo into ServiceImage Job
                                        // UploadImageService::dispatch('Photos', $photo->id, $photo->url, $id_owner);
                                    }
                                    
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
            $url = env('API_SERVER') . '/api/front/users/' . $id . '/intros';

            $response = $client->get($url, [
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'PostmanRuntime/7.39.0',
                    'Accept' => '*/*',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive'
                ]
            ]);

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


    public function syncVideo($id_owner, $username)
    {
        $client = new Client();

        try {
            $url = env('API_SERVER') . '/api/front/v2/users/username/' . $username . '/videos';
            
            $response = $client->get($url, [
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'PostmanRuntime/7.39.0',
                    'Accept' => '*/*',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive'
                ]
            ]);
            
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, true);
                if (isset($data['videos']) && count($data['videos']) > 0) {
                    $videos = $data['videos'];
                    foreach ($videos as $data) {
                        $video = Video::find($data['id']);
                        // dd($data);
                        if (!$video) {
                            $video = new Video();
                            $video->id = $data['id'];
                        }
                        $video->owner_id = $id_owner;
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

    public function syncFeedByOwnerId($id)
    {
        $client = new Client();

        try {
            $url = env('API_SERVER') . '/api/front/feed/model/' . $id;
            
            $response = $client->get($url, [
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'PostmanRuntime/7.39.0',
                    'Accept' => '*/*',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive'
                ]
            ]);
            
            $statusCode = $response->getStatusCode();

            $initNextParams = new class {
                public $createdAt = "2020-01-01T00:00:00Z";
                public $excludeIds = "123456789";
            };

            if ($statusCode === 200) {
                $response = $response->getBody()->getContents();
                $data = json_decode($response, false);
                $nextParams = $data->nextPageParams;

                if (isset($nextParams->excludeIds)) {
                    while (isset($nextParams->excludeIds) && $nextParams->excludeIds != $initNextParams->excludeIds) {

                        foreach ($data->posts as $key => $post) {
                            $this->saveFeed($post);
                        }
                        $url = env('API_SERVER') . '/api/front/feed/model/' . $id . '?createdAt=' . $nextParams->createdAt . '&excludeIds=' . $nextParams->excludeIds;
                        $response = $client->get($url, [
                            'verify' => false,
                            'headers' => [
                                'User-Agent' => 'PostmanRuntime/7.39.0',
                                'Accept' => '*/*',
                                'Accept-Encoding' => 'gzip, deflate, br',
                                'Connection' => 'keep-alive'
                            ],
                            'query' => [
                                'createdAt' => $nextParams->createdAt,
                                'excludeIds' => $nextParams->excludeIds,
                            ],
                        ]);
                        $response = $response->getBody()->getContents();
                        $data = json_decode($response, false);
                        $initNextParams = $nextParams;
                        $nextParams = $data->nextPageParams;
                    }
                } else {
                    foreach ($data->posts as $key => $post) {
                        $this->saveFeed($post);
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

    private function saveFeed($post)
    {
        $post_ = clone $post;
        $post_->video = null;
        $post_->album = null;
        $post_->post = null;
        $post_->video = null;
        $feed = Feed::find($post->id);
        if (!$feed) {
            $feed = new Feed();
            $feed->id = $post->id;
        }
        $feed->likes = $post->likes;
        $feed->accessMode = $post->accessMode;
        $feed->owner_id = $post->modelId;
        $feed->type = $post->type;
        $feed->data = json_encode($post_);
        $updatedAt = str_replace('Z.', '.', $post->updatedAt);
        $feed->updatedAt = Carbon::parse($updatedAt, 'UTC')->setTimezone(config('app.timezone'));
        $feed->save();

        if ($feed->type == 'albumUpdated') {
            $this->albumUpdated($post->id, $post->album);
        }

        if ($feed->type == 'videoAdded') {
            $this->videoAdded($feed->id, $post->video);
        }

        if ($feed->type == 'postAdded') {
            $this->postAdded($feed->id, $post->post, $feed->owner_id);
        }
    }

    private function albumUpdated($post_id, $data)
    {
        $album = AlbumFeed::find($data->id);
        $album_ = clone $data;
        $album_->photos = null;
        if (!$album) {
            $album = new AlbumFeed();
            $album->id = $data->id;
        }
        $album->post_id = $post_id;
        $album->isDeleted = $album_->isDeleted; // No se usa, no se para que lo puse xD
        $album->owner_id = $album_->userId;
        $album->name = $album_->name;
        $album->description = $album_->description;
        $album->cost = $album_->cost;
        $album->accessMode = $album_->accessMode;
        $album->photosCount = $album_->photosCount;
        $album->likes = $album_->likes;
        if (isset($album_->preview)) {
            $album->preview = $album_->preview;
        }
        $createdAt = str_replace('Z.', '.', $album_->createdAt);
        $album->createdAt = Carbon::parse($createdAt);
        $album->save();

        // Upload photo into ServiceImage & return ID
        if (empty($album->picture_upload_id)) {
            // UploadImageService::dispatch('AlbumFeed', $album->id, $album->preview, $album->owner_id);
        }

        foreach ($data->photos as $ph) {
            $photo = PhotoAlbumFeed::find($ph->id);
            if (!$photo) {
                $photo = new PhotoAlbumFeed();
                $photo->id = $ph->id;
            }
            if ($photo->picture_upload_id) {
                continue;
            }
            $photo->album_feed_id = $album->id;
            $createdAt = str_replace('Z.', '.', $album_->createdAt);
            $photo->createdAt = Carbon::parse($createdAt);
            $photo->isDeleted = $ph->isDeleted;
            $photo->album_id = $ph->albumId;
            $photo->order = $ph->order;
            $photo->status = $ph->status;
            $photo->isNew = $ph->isNew;
            $photo->primaryColor = $ph->primaryColor;
            $photo->source = $ph->source;
            if (isset($ph->urlThumb)) {
                $photo->urlThumb = $ph->urlThumb;
            }
            if (isset($ph->urlPreview)) {
                $photo->urlPreview  = $ph->urlPreview;
            }
            $photo->urlThumbMicro = $ph->urlThumbMicro;
            $photo->save();

            if (isset($ph->url) && empty($photo->picture_upload_id)) {
                // Upload photo into ServiceImage Job
                // UploadImageService::dispatch('PhotoAlbumFeed', $photo->id, $photo->url, $album->owner_id);
            }
        }
    }

    private function videoAdded($feed_id, $data)
    {
        // $video_ = clone $data;
        try {
            $video = VideoFeed::find($data->id);
            if (!$video) {
                $video = new VideoFeed();
                $video->id = $data->id;
            }
            $video->feed_id = $feed_id;
            $video->owner_id = $data->userId;
            $createdAt = str_replace('Z.', '.', $data->createdAt);
            $video->createdAt = Carbon::parse($createdAt);
            $video->title = $data->title;
            $video->description = $data->description;
            $video->format_trailer = $this->returnFormatByUrl($data->trailerUrl);
            $video->cost = $data->cost;
            $video->accessMode = $data->accessMode;
            $video->duration = $data->duration;
            $video->trailerUrl = $data->trailerUrl;
            $video->coverUrl = $data->coverUrl;
            $video->microCoverUrl = $data->microCoverUrl;
            $video->likes = $data->likes;
            if (isset($data->coverUrls)) {
                $video->coverUrls = json_encode($data->coverUrls);
            }
            if (isset($data->videoUrl)) {
                $video->videoUrl = $data->videoUrl;
                $video->format_video = $this->returnFormatByUrl($data->videoUrl);
            }
            $video->save();
        } catch (\Throwable $th) {
            dd($data);
        }
    }

    private function postAdded($feed_id, $data, $owner_id)
    {
        // $post_ = clone $data;
        $post = PostFeed::find($data->id);
        if (!$post) {
            $post = new PostFeed();
            $post->id = $data->id;
        }
        $post->feed_id = $feed_id;
        $createdAt = str_replace('Z.', '.', $data->createdAt);
        $post->createdAt = Carbon::parse($createdAt);
        $post->imageLink = $data->imageLink;
        $post->body = $data->body;
        $post->likes = $data->likes;
        $post->accessMode = $data->accessMode;
        $post->imageUrl = $data->imageUrl;
        $post->save();

        if (!empty($post->imageUrl) && empty($post->image_upload_id)) {
            // Upload photo into ServiceImage Job
            // UploadImageService::dispatch('PostFeed', $post->id, $post->imageUrl, $owner_id);
        }
        
        foreach ($data->media as $key => $med) {
            $media = MediaPostFeed::find($med->recordId);
            if (!$media) {
                $media = new MediaPostFeed();
                $media->id = $med->recordId;
            }
            $media->post_feed_id = $post->id;
            $media->type = $med->type;
            $media->data_id = $med->data->id;
            $createdAt = str_replace('Z.', '.', $med->data->createdAt);
            $media->createdAt = Carbon::parse($createdAt);
            $media->albumId = $med->data->albumId;
            $media->order = $med->data->order;
            $media->primaryColor = $med->data->primaryColor;
            $media->source = $med->data->source;
            $media->url = $med->data->url;
            $media->urlThumb = $med->data->urlThumb;
            $media->urlPreview = $med->data->urlPreview;
            $media->save();
        }
    }
}
