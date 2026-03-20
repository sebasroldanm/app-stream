<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelegramChat extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function messages(): HasMany {
        return $this->hasMany(TelegramMessage::class, 'fk_telegram_chats_id');
    }
}
