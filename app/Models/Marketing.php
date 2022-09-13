<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marketing extends Model
{
    use SoftDeletes;

    protected $table = 'marketings';

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'image',
        'publish_on',
        'country_id',
        'status',
        'type',
        'is_sms',
        'is_notification',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getImageAttribute($value)
    {
        return empty($value) ? '' : fileUrl($value);
    }

    public function getPublishOnAttribute($value)
    {
        return empty($value) ? '' : date('F dS', strtotime($value));
    }

    public function country()
    {
        return $this->hasOne(CountryMaster::class, 'id', 'country_id');
    }

    public function marketing_files()
    {
        return $this->hasMany(MarketingFile::class, 'marketing_id', 'id');
    }
}
