<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    use HasFactory;

    protected $table = 'Photos';

    protected $fillable = [
        'photoId',
        'albumId',
        'userId',
        'createdAt',
        'isDeleted',
        'aspectRatio',
        'order',
        'primaryColor',
        'urlThumbMicro',
        'url',
        'urlThumb',
        'urlPreview',
    ];
}
