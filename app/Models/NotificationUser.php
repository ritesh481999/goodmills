<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationUser extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'notification_id',
        'user_type',
        'is_seen',
        'firebase_response',
        'created_at',
        'updated_at'    
    ];

}
