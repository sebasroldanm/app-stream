<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    public function intro() {
        return $this->hasOne(Intro::class);
    }

    public function panel() {
        return $this->hasMany(Panel::class);
    }

    public function favoritedByCustomers()
    {
        return $this->belongsToMany(Customer::class, 'customer_owner_favorites');
    }
}

