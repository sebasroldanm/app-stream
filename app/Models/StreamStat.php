<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamStat extends Model
{
    protected $fillable = [
        'owner_id',
        'guests',
        'spies',
        'invisibles',
        'greens',
        'golds',
        'regulars',
    ];

    protected $casts = [
        'guests' => 'integer',
        'spies' => 'integer',
        'invisibles' => 'integer',
        'greens' => 'integer',
        'golds' => 'integer',
        'regulars' => 'integer',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_stream_stats');
    }

    public function getViewersAttribute()
    {
        return $this->guests + $this->spies + $this->invisibles + $this->greens + $this->golds + $this->regulars;
    }
}
