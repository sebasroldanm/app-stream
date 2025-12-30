<?php

namespace App\Jobs\Processing;

use App\Models\Video;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessVideo implements ShouldQueue
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

        $video = Video::find($data['id']);
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
