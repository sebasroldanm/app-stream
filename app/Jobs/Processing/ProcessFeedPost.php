<?php

namespace App\Jobs\Processing;

use App\Models\AlbumFeed;
use App\Models\Feed;
use App\Models\MediaPostFeed;
use App\Models\PhotoAlbumFeed;
use App\Models\PostFeed;
use App\Models\VideoFeed;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFeedPost implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postData;

    /**
     * Create a new job instance.
     * 
     * @param object|array $postData
     */
    public function __construct($postData)
    {
        // Ensure data is object as original code uses object syntax ($post->id)
        $this->postData = is_array($postData) ? (object) $postData : $postData;
    }

    public function handle(): void
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        $post = $this->postData;
        if (!isset($post->id) || !isset($post->type)) {
            return;
        }
        
        // We can just create a clean array/object for storage.
        
        $postDataForStorage = clone $post;
        $postDataForStorage->video = null;
        $postDataForStorage->album = null;
        $postDataForStorage->post = null;

        $feed = Feed::find($post->id);
        if (!$feed) {
            $feed = new Feed();
            $feed->id = $post->id;
        }
        $feed->likes = $post->likes ?? 0;
        $feed->accessMode = $post->accessMode ?? null;
        $feed->owner_id = $post->modelId ?? null;
        $feed->type = $post->type;
        $feed->data = $postDataForStorage;
        $updatedAt = str_replace('Z.', '.', $post->updatedAt ?? now()->toIso8601String());
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
        if (empty($data)) {
            return;
        }
        $data = (object) $data;

        if (!isset($data->id)) {
            return;
        }
        
        $album = AlbumFeed::find($data->id);
        $albumDataForStorage = clone $data;
        $albumDataForStorage->photos = null;
        
        if (!$album) {
            $album = new AlbumFeed();
            $album->id = $data->id;
        }
        $album->post_id = $post_id;
        $album->isDeleted = $albumDataForStorage->isDeleted ?? false;
        $album->owner_id = $albumDataForStorage->userId ?? null;
        $album->name = $albumDataForStorage->name ?? null;
        $album->description = $albumDataForStorage->description ?? null;
        $album->cost = $albumDataForStorage->cost ?? 0;
        $album->accessMode = $albumDataForStorage->accessMode ?? null;
        $album->photosCount = $albumDataForStorage->photosCount ?? 0;
        $album->likes = $albumDataForStorage->likes ?? 0;
        if (isset($albumDataForStorage->preview)) {
            $album->preview = $albumDataForStorage->preview;
        }
        $createdAt = str_replace('Z.', '.', $albumDataForStorage->createdAt ?? now()->toIso8601String());
        $album->createdAt = Carbon::parse($createdAt);
        $album->save();

        if (isset($data->photos)) {
            foreach ($data->photos as $ph) {
                $ph = (object) $ph;
                if (!isset($ph->id)) {
                    continue;
                }
                $photo = PhotoAlbumFeed::find($ph->id);
                if (!$photo) {
                    $photo = new PhotoAlbumFeed();
                    $photo->id = $ph->id;
                }
                if ($photo->picture_upload_id) {
                    continue;
                }
                $photo->album_feed_id = $album->id;
                $createdAt = str_replace('Z.', '.', $ph->createdAt ?? $albumDataForStorage->createdAt ?? now()->toIso8601String());
                $photo->createdAt = Carbon::parse($createdAt);
                $photo->isDeleted = $ph->isDeleted ?? false;
                $photo->album_id = $ph->albumId ?? null;
                $photo->order = $ph->order ?? 0;
                $photo->status = $ph->status ?? null;
                $photo->isNew = $ph->isNew ?? false;
                $photo->primaryColor = $ph->primaryColor ?? null;
                $photo->source = $ph->source ?? null;
                if (isset($ph->urlThumb)) {
                    $photo->urlThumb = $ph->urlThumb;
                }
                if (isset($ph->urlPreview)) {
                    $photo->urlPreview  = $ph->urlPreview;
                }
                $photo->urlThumbMicro = $ph->urlThumbMicro ?? null;
                $photo->save();

                if (isset($ph->url) && empty($photo->picture_upload_id)) {
                    // Upload photo into ServiceImage Job (Commented out in original)
                }
            }
        }
    }

    private function videoAdded($feed_id, $data)
    {
        if (empty($data)) {
            return;
        }
        $data = (object) $data;

        if (!isset($data->id)) {
            return;
        }

        try {
            $video = VideoFeed::find($data->id);
            if (!$video) {
                $video = new VideoFeed();
                $video->id = $data->id;
            }
            $video->feed_id = $feed_id;
            $video->owner_id = $data->userId ?? null;
            $createdAt = str_replace('Z.', '.', $data->createdAt ?? now()->toIso8601String());
            $video->createdAt = Carbon::parse($createdAt);
            $video->title = $data->title ?? null;
            $video->description = $data->description ?? null;
            $video->format_trailer = $this->returnFormatByUrl($data->trailerUrl ?? '');
            $video->cost = $data->cost ?? 0;
            $video->accessMode = $data->accessMode ?? null;
            $video->duration = $data->duration ?? 0;
            $video->trailerUrl = $data->trailerUrl ?? null;
            $video->coverUrl = $data->coverUrl ?? null;
            $video->microCoverUrl = $data->microCoverUrl ?? null;
            $video->likes = $data->likes ?? 0;
            if (isset($data->coverUrls)) {
                $video->coverUrls = json_encode($data->coverUrls);
            }
            if (isset($data->videoUrl)) {
                $video->videoUrl = $data->videoUrl;
                $video->format_video = $this->returnFormatByUrl($data->videoUrl);
            }
            $video->save();
        } catch (\Throwable $th) {
            // 
        }
    }

    private function postAdded($feed_id, $data, $owner_id)
    {
        if (empty($data)) {
            return;
        }
        $data = (object) $data;

        if (!isset($data->id)) {
            return;
        }

        $post = PostFeed::find($data->id);
        if (!$post) {
            $post = new PostFeed();
            $post->id = $data->id;
        }
        $post->feed_id = $feed_id;
        $createdAt = str_replace('Z.', '.', $data->createdAt ?? now()->toIso8601String());
        $post->createdAt = Carbon::parse($createdAt);
        $post->imageLink = $data->imageLink ?? null;
        $post->body = $data->body ?? null;
        $post->likes = $data->likes ?? 0;
        $post->accessMode = $data->accessMode ?? null;
        $post->imageUrl = isset($data->imageUrl) ? $data->imageUrl : null;
        $post->save();

        if (!empty($post->imageUrl) && empty($post->image_upload_id)) {
            // Upload logic commented out
        }
        
        if (isset($data->media)) {
            foreach ($data->media as $key => $med) {
                $med = (object) $med;
                if (!isset($med->recordId)) {
                    continue;
                }
                $media = MediaPostFeed::find($med->recordId);
                if (!$media) {
                    $media = new MediaPostFeed();
                    $media->id = $med->recordId;
                }
                $media->post_feed_id = $post->id;
                $media->type = $med->type ?? null;
                if(isset($med->data)) {
                    $medData = (object) $med->data;
                    $media->data_id = $medData->id ?? null;
                    $createdAt = str_replace('Z.', '.', $medData->createdAt ?? now()->toIso8601String());
                    $media->createdAt = Carbon::parse($createdAt);
                    $media->albumId = $medData->albumId ?? null;
                    $media->order = $medData->order ?? 0;
                    $media->primaryColor = $medData->primaryColor ?? null;
                    $media->source = $medData->source ?? null;
                    $media->url = isset($medData->url) ? $medData->url : null;
                    $media->urlThumb = isset($medData->urlThumb) ? $medData->urlThumb : null;
                    $media->urlPreview = isset($medData->urlPreview) ? $medData->urlPreview : null;
                }
                $media->save();
            }
        }
    }

    private function returnFormatByUrl($url)
    {
        if (empty($url)) return null;
        $urlWithoutQuery = strtok($url, '?');
        $extension = pathinfo($urlWithoutQuery, PATHINFO_EXTENSION);
        return $extension ? $extension : null;
    }
}
