<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    public function intro()
    {
        return $this->hasOne(Intro::class);
    }

    public function panel()
    {
        return $this->hasMany(Panel::class);
    }

    public function favoritedByCustomers()
    {
        return $this->belongsToMany(Customer::class, 'customer_owner_favorites');
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

    public function relatedOwners()
    {
        return $this->belongsToMany(Owner::class, 'owner_relations', 'owner_id', 'related_owner_id')
                    ->withPivot(['verified', 'description', 'attributes'])
                    ->withTimestamps();
    }
}
