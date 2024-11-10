<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumFeed extends Model
{
    // use HasFactory;

    protected $fillable = [
        'post_id', 'createdAt', 'isDeleted', 'owner_id', 'name', 
        'description', 'cost', 'accessMode', 'photosCount', 'likes', 'preview'
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
