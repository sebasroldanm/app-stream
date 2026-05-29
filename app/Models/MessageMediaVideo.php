<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageMediaVideo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'presets' => 'array',
        'introUrls' => 'array',
        'vrCameraSettings' => 'array',
    ];

    public function messageMedia()
    {
        return $this->belongsTo(MessageMedia::class);
    }
}