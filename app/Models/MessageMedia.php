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
}