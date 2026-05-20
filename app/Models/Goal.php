<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id',
        'description',
        'goal',
        'spent',
        'left',
        'isEnabled',
    ];

    protected $casts = [
        'goal' => 'integer',
        'spent' => 'integer',
        'isEnabled' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }

    public function getPercentage(int $decimal = 0)
    {
        if (!$this->goal) {
            return null;
        }
        if ($this->goal == 0) {
            return 0;
        }
        $calculated = ($this->spent * 100) / $this->goal;

        return ($decimal == 0) ? (int) $calculated : round($calculated, $decimal);
    }
}
