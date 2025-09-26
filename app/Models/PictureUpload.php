<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PictureUpload extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    
    public $incrementing = false;
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'deletehash',
        'account_id',
        'account_url',
        'display_url',
        'ad_type',
        'ad_url',
        'title',
        'description',
        'name',
        'type',
        'width',
        'height',
        'size',
        'views',
        'section',
        'vote',
        'bandwidth',
        'animated',
        'favorite',
        'in_gallery',
        'in_most_viral',
        'has_sound',
        'is_ad',
        'nsfw',
        'link',
        'tags',
        'datetime',
        'mp4',
        'hls',
        'is_album',
    ];
    
    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'account_id' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'size' => 'integer',
        'views' => 'integer',
        'bandwidth' => 'integer',
    ];
}
