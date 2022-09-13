<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingFile extends Model
{
  

    protected $fillable = [
        'marketing_id',
        'file_name',
        'file_mime_type'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'marketing_id'
    ];
    
    protected $table = 'marketing_files';
    public function getFileNameAttribute($value)
    {
        return empty($value) ? '' : fileUrl($value);
    }

}
