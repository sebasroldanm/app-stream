<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mods extends Model
{
    use HasFactory;

    protected $table = 'mods';

    protected $fillable = [
        'snapshotUrl',
        'widgetPreviewUrl',
        'privateRate',
        'p2pRate',
        'isNonNude',
        'avatarUrl',
        'isPornStar',
        'id_mod',
        'country',
        'doSpy',
        'doPrivate',
        'gender',
        'isHd',
        'isVr',
        'is2d',
        'isExternalApp',
        'isMobile',
        'isModel',
        'isNew',
        'isLive',
        'isOnline',
        'previewUrl',
        'previewUrlThumbBig',
        'previewUrlThumbSmall',
        'broadcastServer',
        'broadcastGender',
        'snapshotServer',
        'status',
        'topBestPlace',
        'username',
        'statusChangedAt',
        'spyRate',
        'publicRecordingsRate',
        'genderGroup',
        'popularSnapshotTimestamp',
        'hasGroupShowAnnouncement',
        'groupShowType',
        'hallOfFamePosition',
        'snapshotTimestamp',
        'hlsPlaylist',
        'isAvatarApproved',
        'isTagVerified',
    ];
}
