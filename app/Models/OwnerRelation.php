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
        'related_owner_id',
        'verified',
        'description',
        'attributes',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'attributes' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function relatedOwner()
    {
        return $this->belongsTo(Owner::class, 'related_owner_id');
    }
}
?>
