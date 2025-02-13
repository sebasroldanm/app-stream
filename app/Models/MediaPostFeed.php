<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaPostFeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_feed_id', 'type', 'data_id', 'createdAt', 'albumId', 'order', 
        'primaryColor', 'source', 'url', 'urlThumb', 'urlPreview'
    ];

    public function postFeed()
    {
        return $this->belongsTo(PostFeed::class);
    }
}
