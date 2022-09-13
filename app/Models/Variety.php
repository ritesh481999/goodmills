<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variety extends Model
{
    use SoftDeletes;

    protected $table = 'varieties';

    protected $fillable = [
        'name', 'commodity_id', 'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function commodity()
    {
        return $this->belongsTo(CommodityMaster::class, 'commodity_id');
    }
}
