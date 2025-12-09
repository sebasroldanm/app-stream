<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OwnerInfoType extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'label', 'data_type', 'category', 'is_active',
    ];

    public function customInfos()
    {
        return $this->hasMany(OwnerCustomInfo::class, 'info_type_id');
    }
}
