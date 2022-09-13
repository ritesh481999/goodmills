<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryLocation extends Model
{
    use SoftDeletes;

    protected $table = 'delivery_locations';

    protected $fillable = [
        'name', 'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function scopeActive($q, bool $status = true)
    {
        return $q->where($this->qualifyColumn('status'), $status);
    }
}
