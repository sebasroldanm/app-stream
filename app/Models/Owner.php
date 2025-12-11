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
}
