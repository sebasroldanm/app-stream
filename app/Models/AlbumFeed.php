<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumFeed extends Model
{
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'post_id',
        'createdAt',
        'isDeleted',
        'owner_id',
        'name',
        'description',
        'cost',
        'accessMode',
        'photosCount',
        'likes',
        'preview'
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class, 'post_id');
    }

    public function photos()
    {
        return $this->hasMany(PhotoAlbumFeed::class, 'album_id');
    }
}
