<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommodityMaster extends Model
{
    use SoftDeletes;

    protected $table = 'commodity_masters';

    protected $fillable = [
        'name',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function variety()
    {
        return $this->hasMany(Variety::class, 'commodity_id', 'id');
    }

    public function specifications()
    {
        return $this->hasMany(SpecificationMaster::class, 'commodity_id', 'id');
    }
}
