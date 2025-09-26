<?php

namespace App\Jobs;

use App\Models\AlbumFeed;
use App\Models\AlbumUpload;
use App\Models\Owner;
use App\Models\PhotoAlbumFeed;
use App\Models\Photos;
use App\Models\PictureUpload;
use App\Models\PostFeed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UploadImageService implements ShouldQueue
{
    use Queueable;

    protected string $type;
    protected string $id;
    protected string $url;
    protected string $ownerId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $type, string $id, string $url, string $ownerId)
    {
        $this->type = $type;
        $this->id = $id;
        $this->url = $url;
        $this->ownerId = $ownerId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $type = $this->type;
        $id = $this->id;
        $url = $this->url;
        $ownerId = $this->ownerId;

        // Find Owner
        $owner = Owner::find($ownerId);

        // Find or Create Album
        $album = AlbumUpload::where('owner_id', $ownerId)->first();
        if (!$album) {
            $albumResp = Http::withToken(config('services.imgur.access_token'))
                ->post('https://api.imgur.com/3/album', [
                    'title'       => $owner->username,
                    'description' => 'Images ' . $owner->username,
                    'privacy'     => 'hidden',
                ]);

            $album = new AlbumUpload();
            $album->owner_id = $ownerId;
            $album->id = $albumResp->json('data.id');
            $album->deletehash = $albumResp->json('data.deletehash');
            $album->save();
        }

        // Upload Image
        $imgClient = Http::get($url);
        $contents = $imgClient->body();
        $base64 = base64_encode($contents);
        $name = ($owner->name) ? 'Image of ' . $owner->name : 'Image of ' . $owner->username;
        $response = Http::withToken(config('services.imgur.access_token'))
            ->post('https://api.imgur.com/3/image', [
                'image'       => $base64,
                'type'        => 'base64',
                'name'        => Uuid::uuid4()->toString(),
                'title'       => $type . ' ' . $owner->username,
                'album'       => $album->id,
                'description' => $name,
                'nsfw'        => true,
            ]);
        if ($response->status() !== 200) {
            Log::info('Response: ' . json_encode($response->json()));
            throw new \Exception('Error status: ' . $response->status() . ' detail: ' . $response->json('errors.0.detail'));
        }
        // Save Picture
        $pic = new PictureUpload();
        $pic->id = $response->json('data.id');
        $pic->deletehash = $response->json('data.deletehash');
        $pic->account_id = $response->json('data.account_id');
        $pic->account_url = $response->json('data.account_url');
        $pic->display_url = $response->json('data.display_url');
        $pic->ad_type = $response->json('data.ad_type');
        $pic->ad_url = $response->json('data.ad_url');
        $pic->title = $response->json('data.title');
        $pic->description = $response->json('data.description');
        $pic->name = $response->json('data.name');
        $pic->type = $response->json('data.type');
        $pic->width = $response->json('data.width');
        $pic->height = $response->json('data.height');
        $pic->size = $response->json('data.size');
        $pic->views = $response->json('data.views');
        $pic->section = $response->json('data.section');
        $pic->vote = $response->json('data.vote');
        $pic->bandwidth = $response->json('data.bandwidth');
        $pic->animated = $response->json('data.animated');
        $pic->favorite = $response->json('data.favorite');
        $pic->in_gallery = $response->json('data.in_gallery');
        $pic->in_most_viral = $response->json('data.in_most_viral');
        $pic->has_sound = $response->json('data.has_sound');
        $pic->is_ad = $response->json('data.is_ad');
        $pic->nsfw = $response->json('data.nsfw');
        $pic->link = $response->json('data.link');
        $pic->tags = json_encode($response->json('data.tags'));
        $pic->datetime = $response->json('data.datetime');
        $pic->mp4 = $response->json('data.mp4');
        $pic->hls = $response->json('data.hls');
        $pic->save();

        // Add to Album
        $add = Http::withToken(config('services.imgur.access_token'))
            ->post("https://api.imgur.com/3/album/{$album->id}/add", [
                'ids' => $pic->id,
            ]);

        // Update Relation pic to album
        if ($add->json('success')) {
            $pic->is_album = $album->id;
            $pic->update();
        }

        // Update Relation pic to model
        $modelMap = [
            'Photos' => Photos::class,
            'PhotoAlbumFeed' => PhotoAlbumFeed::class,
            'AlbumFeed' => AlbumFeed::class,
            'PostFeed' => PostFeed::class,
        ];

        if (isset($modelMap[$type])) {
            $model = $modelMap[$type]::find($id);
            if ($model) {
                $model->picture_upload_id = $pic->id;
                $model->save();
            }
        }
    }
}
