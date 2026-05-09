<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramVideo extends Model
{
    use SoftDeletes;

    protected $table = 'telegram_videos';

    protected $fillable = [
        'fk_telegram_messages_id',
        'duration',
        'width',
        'height',
        'file_name',
        'mime_type',
        'file_id',
        'file_unique_id',
        'file_size',
        'thumbnail_file_id',
        'thumbnail_file_unique_id',
        'thumbnail_file_size',
        'thumbnail_width',
        'thumbnail_height',
        'thumb_file_id',
        'thumb_file_unique_id',
        'thumb_file_size',
        'thumb_width',
        'thumb_height'
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(TelegramMessage::class, 'fk_telegram_messages_id');
    }
}
