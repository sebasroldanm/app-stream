<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'old_data',
        'new_data',
        'event'
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id', 'id');
    }
}
