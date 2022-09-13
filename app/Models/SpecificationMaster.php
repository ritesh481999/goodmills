<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecificationMaster extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','commodity_id','status'
    ];

    // protected $casts = [
    //     'status' => 'boolean'
    // ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function commodity()
    {
        return $this->belongsTo(CommodityMaster::class, 'commodity_id');
    }

    // public function scopeActive($q, bool $status = true)
    // {
    //     return $q->where('status', $status);
    // } 
}
