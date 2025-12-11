<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerRelation extends Model
{
    use HasFactory;

    protected $table = 'owner_relations';

    protected $fillable = [
        'owner_id',
        'owner_relation_group_id',
    ];

    public function group()
    {
        return $this->belongsTo(OwnerRelationGroup::class, 'owner_relation_group_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}
