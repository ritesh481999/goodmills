<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WrongAttemptPin extends Model
{
    protected $table = 'wrong_attempt_pin';
    
    public $timestamps = false;

    protected $fillable = [
        'farmer_id',
        'attempt_time',
    ];

}
