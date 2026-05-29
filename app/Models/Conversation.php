<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'isBookmark' => 'boolean',
        'hasTokens' => 'boolean',
        'hasUnreadWithTokens' => 'boolean',
        'metadataFriendship' => 'array',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'counterpartId');
    }

    public function counterpart()
    {
        return $this->belongsTo(Owner::class, 'counterpartId');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->orderBy('createdAt', 'desc');
    }
}
