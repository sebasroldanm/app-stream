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
        'title',
        'url_viewer',
        'url',
        'display_url',
        'width',
        'height',
        'size',
        'time',
        'expiration',
        'image_filename',
        'image_name',
        'image_mime',
        'image_extension',
        'image_url',
        'thumb_filename',
        'thumb_name',
        'thumb_mime',
        'thumb_extension',
        'thumb_url',
        'medium_filename',
        'medium_name',
        'medium_mime',
        'medium_extension',
        'medium_url',
        'delete_url',
        'success',
        'status',
    ];
    
    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'size' => 'integer',
        'time' => 'integer',
        'expiration' => 'integer',
        'success' => 'boolean',
        'status' => 'integer',
    ];
}
