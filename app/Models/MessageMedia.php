<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageMedia extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function photos()
    {
        return $this->hasMany(MessageMediaPhoto::class);
    }

    public function videos()
    {
        return $this->hasMany(MessageMediaVideo::class);
    }

    public function getPhotoAttribute()
    {
        if ($this->type === 'photo') {
            return $this->photos()->first();
        }
        return null;
    }

    public function getVideoAttribute()
    {
        if ($this->type === 'video') {
            return $this->videos()->first();
        }
        return null;
    }

    public function getMixedAttribute()
    {
        if ($this->type === 'mixed') {
            $photos = $this->photos()->get();
            $videos = $this->videos()->get();
            return $photos->concat($videos);
        }
        return null;
    }

    public function getAlbumAttribute()
    {
        if ($this->type === 'album') {
            return (object) [
                'photos' => $this->photos()->get()
            ];
        }
        return null;
    }
}
