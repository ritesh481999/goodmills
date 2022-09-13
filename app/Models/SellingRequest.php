<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Variety;
use App\Models\Farmer;
use App\Models\CommodityMaster;
use App\Models\DeliveryLocation;
use App\Models\SpecificationMaster;

class SellingRequest extends Model
{
    use SoftDeletes;

    public const STATUS = [
        '1' => 'Request Recieved',
        '2' => 'Bid Sent',
        '3' => 'Request Rejected by admin',
        '4' => 'Bid Accepted by farmer',
        '5' => 'Bid Rejected by farmer/Counter-offer received',
        '6' => 'Counter-offer Accepted by admin',
        '7' => 'Counter-offer Rejected by admin'
    ];

    protected $fillable = ['date_of_movement', 'commodity_id', 'specification_id', 'variety_id', 'delivery_location_id', 'farmer_id', 'country_id', 'tonnage', 'delivery_method', 'delivery_address', 'postal_code', 'status', 'reason'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getDeliveryAddressAttribute($value)
    {
        return $value ? $value : '';
    }

    public function getPostalCodeAttribute($value)
    {
        return $value ? $value : '';
    }

    public function getDeliveryLocationIdAttribute($value)
    {
        return $value ? $value : '';
    }

    public function getReasonAttribute($value)
    {
        return $value ? $value : '';
    }

    public function farmer()
    {
        return $this->hasOne(Farmer::class, 'id', 'farmer_id')->withTrashed();
    }

    public function commodity()
    {
        return $this->hasOne(CommodityMaster::class, 'id', 'commodity_id');
    }

    public function specification()
    {
        return $this->hasOne(SpecificationMaster::class, 'id', 'specification_id');
    }

    public function variety()
    {
        return $this->hasOne(Variety::class, 'id', 'variety_id');
    }

    public function deliveryLocation()
    {
        return $this->hasOne(DeliveryLocation::class, 'id', 'delivery_location_id');
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }


}
