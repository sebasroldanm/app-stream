<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OwnerCustomInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'info_type_id',
        'source_id',
        'data_info',
    ];

    protected $casts = [
        'data_info' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function type()
    {
        return $this->belongsTo(OwnerInfoType::class, 'info_type_id');
    }

    public function source()
    {
        return $this->belongsTo(OwnerInfoSource::class, 'source_id');
    }
}
