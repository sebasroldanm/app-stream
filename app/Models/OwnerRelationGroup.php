<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerRelationGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'verified',
        'description',
        'attributes',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'attributes' => 'array',
    ];

    public function relations()
    {
        return $this->hasMany(OwnerRelation::class);
    }

    public function owners()
    {
        return $this->hasManyThrough(Owner::class, OwnerRelation::class, 'owner_relation_group_id', 'id', 'id', 'owner_id');
    }
}
