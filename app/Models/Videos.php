<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;

    protected $table = 'Videos';

    protected $fillable = [
        'idVideo',
        'username',
        'createdAt',
        'isDeleted',
        'userId',
        'title',
        'description',
        'accessMode',
        'duration',
        'trailerUrl',
        'coverUrl',
        'microCoverUrl',
        'likes',
        'videoUrl',
        'isHls',
    ];
}
