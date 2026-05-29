<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageMediaPhoto extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function messageMedia()
    {
        return $this->belongsTo(MessageMedia::class);
    }
}