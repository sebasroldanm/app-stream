<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperChat extends Model
{
    protected $fillable = [
        'id',
        'owner_id',
        'createdAt',
        'isDeleted',
        'cacheId',
        'type',
        'details',
        'userData',
        'additionalData',
    ];

    protected $casts = [
        'details' => 'array',
        'userData' => 'array',
        'additionalData' => 'array',
        'createdAt' => 'datetime',
        'isDeleted' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }
}
