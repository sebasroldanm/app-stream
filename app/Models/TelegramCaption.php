<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramCaption extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fk_telegram_messages_id',
        'caption',
        'type',
        'position',
        'offset',
        'length'
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(TelegramMessage::class, 'fk_telegram_messages_id');
    }
}
