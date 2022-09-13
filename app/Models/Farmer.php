<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use phpDocumentor\Reflection\Types\Integer;

class Farmer extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens;

    protected $table = 'farmers';
    protected $softDelete = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'company_name',
        'registration_number',
        'business_partner_id',
        'pin',
        'dialing_code',
        'phone',
        'address',
        'aditional_details',
        'country_id',
        'user_type',
        'block_login_time',
        'status',
        'reason',
        'is_suspend',
        'is_news_sms',
        'is_marketing_sms',
        'is_bids_received_sms',
        'is_news_notification',
        'is_marketing_notification',
        'is_bids_received_notification',
    ];

    protected $hidden = [
        'pin',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function setUserTypeAttribute($value)
    {
        $this->attributes['user_type'] = ucwords($value);
    }

    public function country()
    {
        return $this->hasOne(CountryMaster::class, 'id', 'country_id');
    }

    public function scopeActive($q, $active = true)
    {
        return $q->where('status', $active ? '1' : '0');
    }
    public function farmer_device()
    {
        return $this->hasOne(FarmerDevice::class, 'farmer_id', 'id');
    }

    public function countries()
    {
        return $this->belongsToMany(CountryMaster::class, 'country_farmer', 'farmer_id', 'country_id')->withPivot(['status']);
    }

    public function getFcmTokens($notification_key, int $device_type = 2, array $farmer_ids = [])
    {
        $farmers = DB::table('farmers')
            ->join('farmer_device', function ($join) {
                $join->on('farmer_device.farmer_id', '=', 'farmers.id');
            })->select(['farmers.id', 'farmer_device.fcm_token'])
            ->where('farmers.status', 1)
            ->where('farmers.is_suspend', 0)
            ->where('farmer_device.device_type', $device_type)
            ->where('farmers.' . $notification_key, 1)
            ->where('farmer_device.device_type', $device_type)
            ->where('farmers.country_id', auth()->user()->selected_country_id)
            ->where('farmer_device.deleted_at', null);
        if (count($farmer_ids) > 0) {
            $farmers->whereIn('farmers.id', $farmer_ids);
        }
        $farmers =    $farmers->get()->toArray();

        return array_column($farmers, 'fcm_token');
    }

    public function getUserData($notification_key, int $device_type = 2, array $farmer_ids = [])
    {
        $userData = $this->join('farmer_device', function ($join) {
            $join->on('farmer_device.farmer_id', '=', 'farmers.id');
        })->select(['farmers.id as user_id', DB::raw("2 as user_type")])
            ->where('farmers.status', 1)
            ->where('farmers.is_suspend', 0)
            ->where('farmers.' . $notification_key, 1)
            ->where('farmer_device.device_type', $device_type)
            ->where('farmers.country_id', auth()->user()->selected_country_id)
            ->where('farmer_device.deleted_at', null);
        if (count($farmer_ids) > 0) {
            $userData->whereIn('farmers.id', $farmer_ids);
        }
        $farmers =    $userData->get()->toArray();

        return $farmers;
    }

    public function getUserDataWithFcm($notification_key, int $device_type = 2, array $farmer_ids = [])
    {
        $userData = $this->join('farmer_device', function ($join) {
            $join->on('farmer_device.farmer_id', '=', 'farmers.id');
        })->select(['farmers.id as user_id', 'farmer_device.fcm_token', DB::raw("2 as user_type")])
            ->where('farmers.status', 1)
            ->where('farmers.' . $notification_key, 1)
            ->where('farmer_device.device_type', $device_type)
            ->where('farmer_device.deleted_at', null);
        if (count($farmer_ids) > 0) {
            $userData->whereIn('farmers.id', $farmer_ids);
        }
        $farmers =    $userData->get()->toArray();

        return $farmers;
    }

    public function getFarmersPhoneNumber(string $sms_key, array $farmer_ids = [])
    {
        $farmers = Farmer::where('status', 1)
            ->where($sms_key, 1)
            ->select(['name as full_name', DB::raw('CONCAT(dialing_code,phone) AS phone_number')]);
        if (count($farmer_ids) > 0) {
            $farmers->whereIn('farmers.id', $farmer_ids);
        }
        $farmersPhoneNumber =  $farmers->get()->toArray();

        return $farmersPhoneNumber;
    }


    public function bids()
    {
        return $this->belongsToMany(Bid::class, 'bid_farmers', 'bid_id', 'farmer_id');
    }


    public function getFarmerWithFcmToken($notification_key = null, $notification_value = null, $country_id, array $farmer_ids = [])
    {

        $farmers = DB::table('farmers')
            ->join('farmer_device', function ($join) {
                $join->on('farmer_device.farmer_id', '=', 'farmers.id');
            })->select(['farmers.id', 'farmer_device.fcm_token', DB::raw("2 as user_type"), 'farmer_device.device_type'])
            ->where('farmers.status', 1)
            ->where('farmers.is_suspend', 0)
            ->where('farmers.country_id', $country_id)
            ->where('farmer_device.deleted_at', null);
        if($notification_key)
        {
            $farmers =   $farmers->where("farmers." . $notification_key, $notification_value);
        }  
        if (count($farmer_ids) > 0) {
            $farmers =   $farmers->whereIn('farmers.id', $farmer_ids);
        }
        $farmers =    $farmers->get()->toArray();
        return $farmers;
    }
}
