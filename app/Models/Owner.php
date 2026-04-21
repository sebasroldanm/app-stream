<?php

namespace App\Models;

use App\Traits\OwnerProp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory, OwnerProp;
    
    protected $fillable = [
        'name',
        'username',
        'previousUsername',
        'lastUsername',
        'avatar',
        'preview',
        'gender',
        'country',
        'isMobile',
        'statusChangedAt',
        'isLive',
        'isOnline',
        'isError',
        'isDelete',
        'isInfoCustom',
        'isMediaCustom',
        'data',
        'bodyType',
        'eyeColor',
        'age',
        'birthDate',
        'favoritedCount',
        'offlineStatusUpdatedAt',
        'notFound',
        'lastSync',
        'isGeoBanned',
        'isProfileAvailable',
        'isBanned',
        'isActive',
        'isBlocked',
    ];

    protected $casts = [
        'isMobile' => 'boolean',
        'isLive' => 'boolean',
        'isOnline' => 'boolean',
        'isError' => 'boolean',
        'isDelete' => 'boolean',
        'isInfoCustom' => 'boolean',
        'isMediaCustom' => 'boolean',
        'notFound' => 'boolean',
        'isGeoBanned' => 'boolean',
        'isProfileAvailable' => 'boolean',
        'isBanned' => 'boolean',
        'isActive' => 'boolean',
        'isBlocked' => 'boolean',
        'data' => 'object',
        'statusChangedAt' => 'datetime',
        'offlineStatusUpdatedAt' => 'datetime',
        'lastSync' => 'datetime',
        'birthDate' => 'date',
        'favoritedCount' => 'integer',
        'age' => 'integer',
    ];

    public function intro()
    {
        return $this->hasOne(Intro::class);
    }

    public function panel()
    {
        return $this->hasMany(Panel::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_owner_favorites');
    }

    public function scopeFavoritedByCustomers($query, $customerId)
    {
        return $query->whereHas('customers', function ($q) use ($customerId) {
            $q->where('customer_id', $customerId);
        });
    }

    public function scopeNotFavoritedByCustomer($query, $customerId)
    {
        return $query->whereDoesntHave('customers', function ($q) use ($customerId) {
            $q->where('customer_id', $customerId);
        });
    }

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }

    public function latestSnapshots()
    {
        return $this->hasMany(Snapshot::class)->orderBy('created_at', 'desc')->limit(10);
    }

    public function customInfos()
    {
        return $this->hasMany(OwnerCustomInfo::class);
    }
    public function relations()
    {
        return $this->hasMany(OwnerRelation::class, 'owner_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'fk_owners_id');
    }

    public function relatedOwners()
    {
        // This is a bit complex in pure Eloquent for "Many Groups -> Many Owners", 
        // but assuming for "same person" typically one group.
        // We can use a custom accessor or a complex relationship.
        // For simplicity and compatibility with standard usage:

        return $this->hasOneThrough(
            OwnerRelationGroup::class,
            OwnerRelation::class,
            'owner_id', // Foreign key on owner_relations table...
            'id', // Foreign key on owner_relation_groups table...
            'id', // Local key on owners table...
            'owner_relation_group_id' // Local key on owner_relations table...
        );
        // Wait, hasOneThrough gets ONE group.
        // If we want the OWNERS, it's harder.
        // Let's keep `relations` as the hasMany to the pivot-like model.
        // And `activeGroup` to get the group if we assume 1.
    }

    public function getRelationGroupAttribute()
    {
        return $this->relations()->with('group')->first()?->group;
    }

    public function getRelatedOwnersAttribute()
    {
        $group = $this->relation_group;
        if (!$group) return collect();

        return $group->owners()->where('owners.id', '!=', $this->id)->get();
    }

    public function getGender()
    {
        return $this->data?->user?->user?->gender;
    }

    public function getGenderIcon()
    {
        return $this->iconGender($this->getGender());
    }

    /**
     * Get the continent
     * @return string|null
     */
    public function getContinent()
    {
        return $this->data?->user?->modelTopPosition?->continent;
    }

    /**
     * Get the hair color
     * @return string|null
     */
    public function getHairColor()
    {
        return $this->data?->user?->user?->hairColor;
    }

    /**
     * Get the eye color
     * @return string|null
     */
    public function getEyeColor()
    {
        return $this->data?->user?->user?->eyeColor;
    }

    /**
     * Get the body type
     * @return string|null
     */
    public function getBodyType()
    {
        return $this->data?->user?->user?->bodyType;
    }

    /**
     * Get the ethnicity
     * @return string|null
     */
    public function getEthnicity()
    {
        return $this->data?->user?->user?->ethnicity;
    }

    /**
     * Get the top position
     * @return string|null
     */
    public function getTopPosition()
    {
        return number_format($this->data?->user?->modelTopPosition?->position, 2);
    }

    /**
     * Get the top points
     * @return string|null
     */
    public function getTopPoints()
    {
        return number_format($this->data?->user?->modelTopPosition?->points, 2);
    }

    /**
     * Get the rating private
     * @return float|bool
     */
    public function getRatingPrivate()
    {
        return $this->data?->user?->user?->ratingPrivate ?? false;
    }

    /**
     * Get the interests
     * @return array
     */
    public function getInterests()
    {
        return $this->data?->user?->user?->interests ?? [];
    }

    /**
     * Get the public activities
     * @return array
     */
    public function getPublicActivities()
    {
        return $this->data?->user?->user?->publicActivities ?? [];
    }

    /**
     * Get the private activities
     * @return array
     */
    public function getPrivateActivities()
    {
        return $this->data?->user?->user?->privateActivities ?? [];
    }

    /**
     * Get the preview url thumb small
     * @return string|null
     */
    public function getPreviewUrlThumbSmall()
    {
        return $this->data?->user?->user?->previewUrlThumbSmall;
    }

    /**
     * Get the preview url thumb big
     * @return string|null
     */
    public function getPreviewUrlThumbBig()
    {
        return $this->data?->user?->user?->previewUrlThumbBig;
    }

    /**
     * Get the preview url thumb large
     * @return string|null
     */
    public function getAvatarUrl()
    {
        return $this->data?->user?->user?->avatarUrl;
    }

    public function getAvatarUrlThumb()
    {
        return $this->data?->user?->user?->avatarUrlThumb;
    }
    public function getPicProfileAttribute()
    {
        if (empty($this->avatar)) {
            return "https://ui-avatars.com/api/?name=" . $this->username . "&background=fff&color=fa377b";
        }
        return $this->avatar;
    }

    public function getOwnerCamBroadcastConfigFpsAttribute()
    {
        return $this->data?->cam?->broadcastConfig?->flashFps ?? null;
    }

    public function getOwnerCamBroadcastConfigWidthAttribute()
    {
        return $this->data?->cam?->broadcastConfig?->flashWidth ?? null;
    }

    public function getOwnerCamBroadcastConfigHeightAttribute()
    {
        return $this->data?->cam?->broadcastConfig?->flashHeight ?? null;
    }

    public function getOwnerCamBroadcastConfigRatioAttribute()
    {
        if ($this->data?->cam?->broadcastConfig && $this->data?->cam?->broadcastConfig?->flashWidth) {
            $gcd = function ($a, $b) use (&$gcd) {
                return $b === 0 ? $a : $gcd($b, $a % $b);
            };

            $divisor = $gcd($this->data?->cam?->broadcastConfig?->flashWidth, $this->data?->cam?->broadcastConfig?->flashHeight);
            return $this->data?->cam?->broadcastConfig?->flashWidth / $divisor . ":" . $this->data?->cam?->broadcastConfig?->flashHeight / $divisor;
        }
        return "16:9";
    }

    public function getShowModelAttribute()
    {
        return $this->data?->cam?->show?->mode ?? false;
    }
}
