<?php

namespace App\Observers;

use App\Models\Goal;
use App\Models\GoalHistory;

class GoalObserver
{
    /**
     * Handle the Goal "created" event.
     */
    public function created(Goal $goal): void
    {
        GoalHistory::create([
            'goal_id' => $goal->id,
            'event' => 'created',

            'old_data' => null,

            'new_data' => [
                'description' => $goal->description,
                'goal' => $goal->goal,
                'spent' => $goal->spent,
                'isEnabled' => $goal->isEnabled,
            ],
        ]);
    }

    /**
     * Handle the Goal "updated" event.
     */
    public function updated(Goal $goal): void
    {
        $changes = $goal->getChanges();

        unset($changes['updated_at']);

        if (empty($changes)) {
            return;
        }

        $oldData = [];

        foreach ($changes as $field => $newValue) {
            $oldData[$field] = $goal->getOriginal($field);
        }

        GoalHistory::create([
            'goal_id' => $goal->id,
            'event' => 'updated',

            'old_data' => $oldData,
            'new_data' => $changes,
        ]);
    }

    /**
     * Handle the Goal "deleted" event.
     */
    public function deleted(Goal $goal): void
    {
        $oldData = $goal->getOriginal();
        unset($oldData['id']);

        GoalHistory::create([
            'goal_id' => $goal->id,
            'event' => 'deleted',
            'old_data' => $oldData,
            'new_data' => null,
        ]);
    }

    /**
     * Handle the Goal "restored" event.
     */
    public function restored(Goal $goal): void
    {
        //
    }

    /**
     * Handle the Goal "force deleted" event.
     */
    public function forceDeleted(Goal $goal): void
    {
        //
    }
}
