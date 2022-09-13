<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FarmerDevice extends Model
{
    use SoftDeletes;

    protected $table = 'farmer_device';

    protected $fillable = ['farmer_id', 'fcm_token', 'device_token', 'device_type'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
