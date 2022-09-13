<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BidLocationMaster extends Model
{
    use SoftDeletes;
    protected $hidden = [
        'pivot',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',

    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function scopeActive($q, bool $status = true)
    {
        return $q->where($this->qualifyColumn('status'), $status);
    }
    
}
