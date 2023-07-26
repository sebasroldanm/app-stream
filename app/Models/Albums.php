<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Albums extends Model
{
    use HasFactory;

    protected $table = 'Albums';

    protected $fillable = [
        'albumId',
        'userId',
        'createdAt',
        'isDeleted',
        'accessMode',
        'isReserved',
        'name',
        'description',
        'preview',
        'previewUnverified',
        'previewMicro',
        'photosCount'
    ];
}
