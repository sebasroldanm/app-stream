<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'likes', 'accessMode', 'owner_id', 'type', 'data'
    ];

    public function owner() {
        return $this->hasOne(Owner::class, 'id', 'owner_id');
    }

    public function videoFeed()
    {
        return $this->hasMany(VideoFeed::class);
    }

    public function postFeed()
    {
        return $this->hasMany(PostFeed::class, 'feed_id');
    }

    public function albumFeed()
    {
        return $this->hasMany(AlbumFeed::class, 'post_id');
    }
}
