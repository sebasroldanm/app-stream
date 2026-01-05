<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intro extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'type', 'url', 'data', 'owner_id'];

    public function owner() {
        return $this->hasOne(Owner::class);
    }
}
