<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fk_telegram_messages_id',
        'fk_owners_id',
        'body',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            if (is_null($post->fk_customer_id)) {
                $customerId = Auth::user()?->customer_id ?? Auth::id();
                $exists = Customer::where('id', $customerId)->exists();
                $post->fk_customer_id = $exists 
                    ? $customerId 
                    : Customer::first()?->id;
            }
        });
    }

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
