<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laragear\WebAuthn\Contracts\WebAuthnAuthenticatable;
use Laragear\WebAuthn\WebAuthnAuthentication;
use Laragear\WebAuthn\WebAuthnData;

class Customer extends Authenticatable implements AuthenticatableContract, WebAuthnAuthenticatable
{
    use Notifiable, SoftDeletes, AuthAuthenticatable, WebAuthnAuthentication;

    protected $fillable = [
        'username',
        'avatar',
        'country',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
        'password_change_required_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password_change_required_at' => 'datetime',
    ];

    public function webAuthnData(): WebAuthnData
    {
        return new WebAuthnData(
            (string) $this->email,
            (string) $this->username
        );
    }

    public function ownerFavorites()
    {
        return $this->belongsToMany(Owner::class, 'customer_owner_favorites');
    }

    public function getOwnerFavoriteIds()
    {
        return $this->ownerFavorites()->pluck('owner_id');
    }

    public function isOwnerFavorite() {
        return $this->ownerFavorites()->where('owner_id', $this->id)->exists();
    }

    public function toggleOwnerFavorite(Owner $owner)
    {
        if ($this->ownerFavorites()->where('owner_id', $owner->id)->exists()) {
            // Si ya es favorito, lo elimina
            $this->ownerFavorites()->detach($owner->id);
        } else {
            // Si no es favorito, lo agrega
            $this->ownerFavorites()->attach($owner->id, ['created_at' => now()]);
        }
    }
}
