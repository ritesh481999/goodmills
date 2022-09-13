<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticContent extends Model
{
    use SoftDeletes;

    protected $table = 'static_contents';

    protected $primaryKey = 'id';

    protected $fillable = [
        'country_id',
        'content_type',
        'contents',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
