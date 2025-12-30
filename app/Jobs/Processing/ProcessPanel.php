<?php

namespace App\Jobs\Processing;

use App\Models\Panel;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPanel implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $ownerId;

    /**
     * Create a new job instance.
     *
     * @param array $data Panel data from API
     * @param int $ownerId
     */
    public function __construct(array $data, int $ownerId)
    {
        $this->data = $data;
        $this->ownerId = $ownerId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        $data = $this->data;
        $panel = Panel::find($data['id']);
        
        if (!$panel) {
            $panel = new Panel();
            $panel->id = $data['id'];
        }

        $panel->title = $data['title'];
        $panel->body = $data['body'];
        $panel->imageUrl = $data['imageUrl'];
        $panel->owner_id = $this->ownerId;
        $panel->order = $data['position']['order'] ?? 0;
        $panel->column = $data['position']['column'] ?? 0;
        $panel->data = json_encode($data);
        $panel->createdAt = Carbon::parse($data['createdAt']);
        $panel->save();

        // Image saving logic was commented out in original trait, keeping it absent here as well.
        // if (!empty($panel->imageUrl)) {
        //     $this->saveImage($panel->imageUrl, $owner->username, 'feed');
        // }
    }
}
