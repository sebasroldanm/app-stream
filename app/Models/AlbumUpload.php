<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumUpload extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    
    public $incrementing = false;
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'deletehash',
        'ownerId',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
