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
        $feed->likes = $post->likes;
        $feed->accessMode = $post->accessMode;
        $feed->owner_id = $post->modelId;
        $feed->type = $post->type;
        $feed->data = json_encode($postDataForStorage);
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
        $data = (object) $data;
        
        $album = AlbumFeed::find($data->id);
        $albumDataForStorage = clone $data;
        $albumDataForStorage->photos = null;
        
        if (!$album) {
            $album = new AlbumFeed();
            $album->id = $data->id;
        }
        $album->post_id = $post_id;
        $album->isDeleted = $albumDataForStorage->isDeleted ?? false;
        $album->owner_id = $albumDataForStorage->userId;
        $album->name = $albumDataForStorage->name;
        $album->description = $albumDataForStorage->description;
        $album->cost = $albumDataForStorage->cost;
        $album->accessMode = $albumDataForStorage->accessMode;
        $album->photosCount = $albumDataForStorage->photosCount;
        $album->likes = $albumDataForStorage->likes;
        if (isset($albumDataForStorage->preview)) {
            $album->preview = $albumDataForStorage->preview;
        }
        $createdAt = str_replace('Z.', '.', $albumDataForStorage->createdAt);
        $album->createdAt = Carbon::parse($createdAt);
        $album->save();

        if (isset($data->photos)) {
            foreach ($data->photos as $ph) {
                $ph = (object) $ph;
                $photo = PhotoAlbumFeed::find($ph->id);
                if (!$photo) {
                    $photo = new PhotoAlbumFeed();
                    $photo->id = $ph->id;
                }
                if ($photo->picture_upload_id) {
                    continue;
                }
                $photo->album_feed_id = $album->id;
                $createdAt = str_replace('Z.', '.', $albumDataForStorage->createdAt);
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
                    // Upload photo into ServiceImage Job (Commented out in original)
                }
            }
        }
    }

    private function videoAdded($feed_id, $data)
    {
        $data = (object) $data;
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
            $video->format_trailer = $this->returnFormatByUrl($data->trailerUrl ?? '');
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
            // 
        }
    }

    private function postAdded($feed_id, $data, $owner_id)
    {
        $data = (object) $data;
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
        $post->imageUrl = isset($data->imageUrl) ? $data->imageUrl : null;
        $post->save();

        if (!empty($post->imageUrl) && empty($post->image_upload_id)) {
            // Upload logic commented out
        }
        
        if (isset($data->media)) {
            foreach ($data->media as $key => $med) {
                $med = (object) $med;
                $media = MediaPostFeed::find($med->recordId);
                if (!$media) {
                    $media = new MediaPostFeed();
                    $media->id = $med->recordId;
                }
                $media->post_feed_id = $post->id;
                $media->type = $med->type;
                if(isset($med->data)) {
                    $medData = (object) $med->data;
                    $media->data_id = $medData->id;
                    $createdAt = str_replace('Z.', '.', $medData->createdAt);
                    $media->createdAt = Carbon::parse($createdAt);
                    $media->albumId = $medData->albumId;
                    $media->order = $medData->order;
                    $media->primaryColor = $medData->primaryColor;
                    $media->source = $medData->source;
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
