<?php

namespace App\Console\Commands;

use App\Models\AlbumUpload;
use App\Models\Owner;
use App\Models\PictureUpload;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class TestImgur extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-imgur';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        Log::info('Iniciando...');

        $ownerId = '191331956';
        $owner = Owner::find($ownerId);

        Log::info('Owner found.', [
            'owner_id' => $ownerId,
            'username' => $owner->username,
            'avatar' => $owner->avatar,
        ]);

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
            Log::info('Album create.', [
                'albumResp' => $albumResp->json(),
                'owner_id' => $album->owner_id,
                'id' => $album->id,
                'deletehash' => $album->deletehash,
            ]);
        } else {
            Log::info('Album found.', [
                'owner_id' => $album->owner_id,
                'id' => $album->id,
                'deletehash' => $album->deletehash,
            ]);
        }

        // Upload Image
        $imgClient = Http::get($owner->avatar);
        $contents = $imgClient->body();
        $base64 = base64_encode($contents);

        $name = ($owner->name) ? 'Image of ' . $owner->name : 'Image of ' . $owner->username;

        $response = Http::withToken(config('services.imgur.access_token'))
            ->post('https://api.imgur.com/3/image', [
                'image'       => $base64,
                'type'        => 'base64',
                'name'        => Uuid::uuid4()->toString(),
                'title'       => 'Avatar ' . $owner->username,
                'album'       => $album->id,
                'description' => $name,
                'nsfw'        => true,
            ]);
        if ($response->status() !== 200) {
            throw new \Exception('Error status: ' . $response->status() . ' detail: ' . $response->json('errors.0.detail'));
        }
        Log::info('API response received Upload Pic.', [
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

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
        $pic->is_album = $response->json('data.is_album');
        $pic->save();


        // Add to Album
        $add = Http::withToken(config('services.imgur.access_token'))
            ->post("https://api.imgur.com/3/album/{$album->id}/add", [
            'ids' => $pic->id,
        ]);

        Log::info('API response received Add to Album.', [
            'status' => $add->status(),
            'body' => $add->json(),
        ]);

        dd($add->json());
        // if ($response->successful()) {
        //     $link = $response->json('data.link');
        //     return response()->json(['url' => $link]);
        // }
    }
}
