<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        // Ranking
        'ranking_league',
        'ranking_level',
        'ranking_isEx',

        // Status
        'isDeleted',
        'username',
        'isOnline',
        'isBlocked',
        'isRegular',
        'isExGreen',
        'isUltimate',
        'isGreen',
        'hasVrDevice',
        'isModel',
        'isStudio',
        'isAdmin',
        'isSupport',
        'hasAdminBadge',
        'isPermanentlyBlocked',
    ];

    protected $casts = [
        // Ranking
        'ranking_isEx' => 'boolean',

        // Status
        'isDeleted' => 'boolean',
        'isOnline' => 'boolean',
        'isBlocked' => 'boolean',
        'isRegular' => 'boolean',
        'isExGreen' => 'boolean',
        'isUltimate' => 'boolean',
        'isGreen' => 'boolean',
        'hasVrDevice' => 'boolean',
        'isModel' => 'boolean',
        'isStudio' => 'boolean',
        'isAdmin' => 'boolean',
        'isSupport' => 'boolean',
        'hasAdminBadge' => 'boolean',
        'isPermanentlyBlocked' => 'boolean',
    ];

    public function streamStats()
    {
        return $this->belongsToMany(StreamStat::class, 'member_stream_stat');
    }
}
