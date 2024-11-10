<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoAlbumFeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_feed_id', 'createdAt', 'isDeleted', 'album_id', 'order', 'status', 
        'isNew', 'primaryColor', 'source', 'url', 'urlThumb', 'urlPreview'
    ];

    public function albumFeed()
    {
        return $this->belongsTo(AlbumFeed::class, 'album_id');
    }
}
