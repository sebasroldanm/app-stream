<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TelegramMessage extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function chat(): BelongsTo {
        return $this->belongsTo(TelegramChat::class, 'fk_telegram_chats_id');
    }

    public function captions(): HasMany {
        return $this->hasMany(TelegramCaption::class, 'fk_telegram_messages_id');
    }

    public function photos(): HasMany {
        return $this->hasMany(TelegramPhoto::class, 'fk_telegram_messages_id');
    }

    public function post(): HasOne {
        return $this->hasOne(Post::class, 'fk_telegram_messages_id');
    }
}
