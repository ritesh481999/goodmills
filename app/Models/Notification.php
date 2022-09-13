<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Notification extends Model
{
    
    use SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'item_type',
        'item_id',
        'title',
        'description',
        'type',
        'device_type',
        'country_id',
        'ip_address',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    protected $appends = ['human_time']; 

    public function getHumanTimeAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->diffForHumans();
    }
    public function users()
    {
        return $this->hasMany(NotificationUser::class, 'notification_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(NotificationUser::class, 'notification_id', 'id');
    }

    public function country()
    {
        return $this->hasOne(CountryMaster::class, 'id', 'country_id');
    }
}
