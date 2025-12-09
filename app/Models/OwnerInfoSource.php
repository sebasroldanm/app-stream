<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OwnerInfoSource extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function customInfos()
    {
        return $this->hasMany(OwnerCustomInfo::class, 'source_id');
    }
}
