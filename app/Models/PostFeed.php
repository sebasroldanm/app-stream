<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'feed_id', 'createdAt', 'imageLink', 'body', 'likes', 'accessMode', 'imageUrl'
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function mediaPostFeeds()
    {
        return $this->hasMany(MediaPostFeed::class);
    }
}
