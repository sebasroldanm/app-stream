<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Relación con el dueño del post.
     */
    public function owner(): BelongsTo {
        return $this->belongsTo(Owner::class, 'fk_owners_id');
    }

    /**
     * El mensaje de Telegram origen de este post.
     */
    public function telegramMessage(): BelongsTo {
        return $this->belongsTo(TelegramMessage::class, 'fk_telegram_messages_id');
    }
}
