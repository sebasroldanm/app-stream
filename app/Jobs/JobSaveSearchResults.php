<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class JobSaveSearchResults implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param array $models
     */
    public function __construct(protected array $models)
    {
        $this->onQueue('low');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $batch = [];
        foreach ($this->models as $modelData) {
            $batch[] = new SyncOwnerByUsername($modelData->username);
        }

        if (!empty($batch)) {
            Bus::batch($batch)
                ->onQueue('low')
                ->dispatch();
        }
    }
}
