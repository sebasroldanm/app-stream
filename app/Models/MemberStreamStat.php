<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberStreamStat extends Model
{
    protected $fillable = [
        'member_id',
        'stream_stat_id',
    ];

    protected $casts = [
        'member_id' => 'integer',
        'stream_stat_id' => 'integer',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function streamStat()
    {
        return $this->belongsTo(StreamStat::class);
    }
}
