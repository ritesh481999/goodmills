<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $table = 'news';

    protected $appends = ['image_link', 'app_date_time'];


    protected $fillable = [
        'title', 'short_description', 'description', 'image', 'status', 'type', 'is_sms', 'is_notification', 'date_time','country_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getImageLinkAttribute()
    {
        if (!empty($this->image))
            return fileUrl($this->image);
        return null;
    }

    public function getAppDateTimeAttribute()
    {
        if (!empty($this->date_time))
            return date('F dS', strtotime($this->date_time));
        return null;
    }

    public function countries()
    {
        return $this->belongsToMany(CountryMaster::class, 'country_master_news', 'news_id', 'country_id');
    }

    public function country()
    {
        return $this->hasOne(CountryMaster::class,'id','country_id');
    }
}
