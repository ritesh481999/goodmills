<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQ extends Model
{
    use SoftDeletes;

    protected $table = 'faqs';

    protected $primaryKey = 'id';

    protected $fillable = ['country_id', 'question', 'answer', 'status'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
