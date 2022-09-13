<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryMaster extends Model
{
    protected $table = 'country_masters';

    protected $fillable = [
        'id',
        'name',
        'is_default',
        'language',
        'abbreviation',
        'time_zone',
        'dialing_code',
        'direction',
        'duration',
        'status',
        'abbreviation',
        'time_zone'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function setLanguageAttribute($value)
    {
        $this->attributes['language'] = strtolower($value);
    }

    public function setDirectionAttribute($value)
    {
        $this->attributes['direction'] = strtolower($value);
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'country_master_news', 'news_id', 'country_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function farmers()
    {
        return $this->hasMany(Farmer::class,'country_id','id');
    }
}
