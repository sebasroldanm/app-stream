<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoFeed extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'feed_id', 'owner_id', 'createdAt', 'title', 'description', 'cost', 'accessMode', 'format_video',
        'format_video', 'duration', 'trailerUrl', 'coverUrl', 'microCoverUrl', 'likes', 'coverUrls', 'videoUrl'
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
