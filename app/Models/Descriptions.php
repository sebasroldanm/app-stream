<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descriptions extends Model
{
    use HasFactory;

    protected $table = 'descriptions';

    protected $fillable = [
        'mod_id',
        'canAddFriends',
        'isInFavorites',
        'isPmSubscribed',
        'isSubscribed',
        'subscriptionModel',
        'isProfileAvailable',
        'friendship',
        'isBanned',
        'isMuted',
        'isStudioModerator',
        'isStudioAdmin',
        'isBannedByKnight',
        'banExpiresAt',
        'isGeoBanned',
        'photosCount',
        'videosCount',
        'currPosition',
        'currPoints',
        'relatedModelsCount',
        'shouldShowOtherModels',
        'previewReviewStatus',
        'feedAvailable',
    ];
}
