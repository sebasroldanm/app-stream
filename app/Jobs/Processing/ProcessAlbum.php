<?php

namespace App\Jobs\Processing;

use App\Models\Album;
use App\Models\Photos;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAlbum implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $ownerId;

    public function __construct(array $data, int $ownerId)
    {
        $this->data = $data;
        $this->ownerId = $ownerId;
    }

    public function handle(): void
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        $data = $this->data;
        $id_owner = $this->ownerId;

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
