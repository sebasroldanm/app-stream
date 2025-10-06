<?php

namespace App\Livewire\Owner\Information;

use App\Models\Owner;
use App\Models\Snapshot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Snapshots extends Component
{
    public Owner $owner;

    public function render()
    {
        $this->saveSnapshot($this->owner->id);

        $snapshots = Snapshot::where('owner_id', $this->owner->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($snapshot) {
                // Agrupa por día usando solo la fecha (sin la hora)
                return Carbon::parse($snapshot->created_at)->format('Y-m-d');
            });

        $this->dispatch('initFullviewer');

        return view('livewire.owner.information.snapshots', [
            'snapshots' => $snapshots
        ]);
    }

    private function saveSnapshot($owner_id): bool
    {
        $owner = Owner::find($owner_id);
        if (! $owner || empty($owner->data)) {
            return false;
        }

        $owner_data = json_decode($owner->data);
        if (! $owner_data) {
            return false;
        }

        $snap_time = $owner_data->user?->user?->snapshotTimestamp ?? null;
        if (! $snap_time) {
            return false;
        }

        $snapshotUrl = "https://img.strpst.com/thumbs/{$snap_time}/{$owner_id}_webp";

        $response = Http::get($snapshotUrl);
        if (! $response->successful()) {
            $owner->isLive = false;
            $owner->update();
            return false;
        }

        $remoteBody = $response->body();

        $contentType = $response->header('Content-Type', '');
        if (! str_starts_with($contentType, 'image') && ! str_contains($snapshotUrl, '.webp')) {
            return false;
        }

        $dir = 'snapshots/' . ($owner->username ?? $owner_id);
        if (! Storage::disk('public')->exists($dir)) {
            Storage::disk('public')->makeDirectory($dir);
        }

        $filePath = "{$dir}/{$snap_time}.webp";

        if (! Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->put($filePath, $remoteBody);
        } else {
            $existing = Storage::disk('public')->get($filePath);
            if (md5($existing) !== md5($remoteBody)) {
                Storage::disk('public')->put($filePath, $remoteBody);
            }
        }

        $snapshot = Snapshot::firstOrNew([
            'owner_id' => $owner_id,
            'snapshotTimestamp' => $snap_time,
        ]);

        if (! $snapshot->exists) {
            $snapshot->snapshotUrl = $snapshotUrl;
            $snapshot->local_url = "/storage/" . $filePath;
            $snapshot->save();
        }

        return (bool) true;
    }
}
