<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramPhoto extends Model
{
    use SoftDeletes;

    protected $table = 'telegram_photos';

    protected $fillable = [
        'fk_telegram_messages_id',
        'file_id',
        'file_unique_id',
        'file_size',
        'width',
        'height'
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(TelegramMessage::class, 'fk_telegram_messages_id');
    }
}
