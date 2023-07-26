<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMods extends Model
{
    use HasFactory;

    // protected $table = 'user_mods';

    protected $fillable = [
        'mod_id',
        'id_mod',
        'isDeleted',
        'name',
        'birthDate',
        'country',
        'region',
        'city',
        'cityId',
        'interestedIn',
        'bodyType',
        'ethnicity',
        'hairColor',
        'eyeColor',
        'subculture',
        'description',
        'showProfileTo',
        'amazonWishlist',
        'age',
        'kingId',
        'becomeKingThreshold',
        'favoritedCount',
        'whoCanChat',
        'spyRate',
        'privateRate',
        'p2pRate',
        'privateMinDuration',
        'p2pMinDuration',
        'privateOfflineMinDuration',
        'p2pOfflineMinDuration',
        'p2pVoiceRate',
        'groupRate',
        'ticketRate',
        'publicRecordingsRate',
        'status',
        'broadcastServer',
        'ratingPrivate',
        'ratingPrivateUsers',
        'topBestPlace',
        'statusChangedAt',
        'wentIdleAt',
        'broadcastGender',
        'isHd',
        'isHls240p',
        'isVr',
        'is2d',
        'isMlNonNude',
        'isDisableMlNonNude',
        'hasChatRestrictions',
        'isExternalApp',
        'isStorePrivateRecordings',
        'isStorePublicRecordings',
        'isMobile',
        'spyMinimum',
        'privateMinimum',
        'privateOfflineMinimum',
        'p2pMinimum',
        'p2pOfflineMinimum',
        'p2pVoiceMinimum',
        'previewUrl',
        'previewUrlThumbBig',
        'previewUrlThumbSmall',
        'doPrivate',
        'doP2p',
        'doSpy',
        'snapshotServer',
        'ratingPosition',
        'isNew',
        'isLive',
        'hallOfFamePosition',
        'isPornStar',
        'broadcastCountry',
        'username',
        'login',
        'domain',
        'gender',
        'genderDoc',
        'showTokensTo',
        'offlineStatus',
        'offlineStatusUpdatedAt',
        'isOnline',
        'isBlocked',
        'avatarUrl',
        'avatarUrlThumb',
        'isRegular',
        'isExGreen',
        'isGold',
        'isUltimate',
        'isGreen',
        'hasVrDevice',
        'isModel',
        'isStudio',
        'isAdmin',
        'isSupport',
        'isFinance',
        'isOfflinePrivateAvailable',
        'isApprovedModel',
        'isDisplayedModel',
        'hasAdminBadge',
        'isPromo',
        'isUnThrottled',
        'userRanking',
        'snapshotTimestamp',
        'contestGender'
    ];

/**
 * Get the mod that owns the UserMods
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function mod()
{
    return $this->belongsTo(Mods::class, 'id_mod', 'id_mod');
}

    /**
     * Get all of the photos for the UserMods
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photos::class, 'userId', 'id_mod');
    }
}
