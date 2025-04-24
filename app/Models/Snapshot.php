<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
    use HasFactory;

    public function picture()
    {
        return $this->hasOne(PictureUpload::class, 'id', 'picture_upload_id');
    }
}
