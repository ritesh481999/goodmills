<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bid extends Model
{
    use SoftDeletes;

    protected $table = 'bids';
    protected $appends = ['month_of_movement_display','valid_for']; 
    protected $fillable = [
        'bid_code',
        'selling_request_id',
        'commodity_id',
        'specification_id',
        'variety_id',
        'delivery_location_id',
        'delivery_method',
        'delivery_address',
        'postal_code',
        'bid_name',
        'publish_on',
        'date_of_movement',
        'max_tonnage',
        'price',
        'valid_till',
        'country_id',
        'status',
    ];

    protected $hidden = [
        'commodity_id',
        'specification_id',
        'variety_id',
        'selling_request_id',
        'valid_till',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function scopeActive($q, $active = true)
    {
        return $q->where('status', $active ? '1' : '0');
    }

    public function getPublishOnAttribute($value)
    {

        return $value ? displayDate($value, 'd/m/Y') : '';
    }

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

    public function getValidBidDateAttribute()
    {
        return $this->valid_till ? remainingTime($this->valid_till) : '';
    }

    public function getValidForAttribute()
    {
        $val = $this->valid_till ? remainingTime($this->valid_till) : '' ; 
        return $val == 0 ? '0' : $val;
    }

    public function getMonthOfMovementDisplayAttribute()
	{
		if(empty($this->date_of_movement))
			return '-';
		$c = Carbon::parse($this->date_of_movement);
		return $c->format('F, Y');
	}

    public function delivery()
    {
        return $this->belongsTo(DeliveryLocation::class, 'delivery_location_id');
    }

    public function commodity()
    {
        return $this->belongsTo(CommodityMaster::class, 'commodity_id');
    }

    public function variety()
    {
        return $this->belongsTo(Variety::class, 'variety_id');
    }

    public function specification()
    {
        return $this->belongsTo(SpecificationMaster::class, 'specification_id');
    }

    public function sellingRequest()
    {
        return $this->belongsTo(SellingRequest::class, 'selling_request_id');
    }

    public function bidFarmer()
    {
        return $this->hasMany(BidFarmer::class, 'bid_id');
    }

    public function bidLocation()
    {
        return $this->belongsToMany(BidLocationMaster::class, 'bid_locations', 'bid_id', 'bid_location_id');
    }
    public function singleFarmer()
    {
        return $this->hasOne(BidFarmer::class, 'bid_id');
    }


    public function scopeWhereDateBetween($query, $fieldName, $fromDate, $todate)
    {
        return $query->where($fieldName, '>=', $fromDate)->where($fieldName, '<=', $todate);
    }

    public function country()
    {
        return $this->hasOne(CountryMaster::class,'id','country_id');
    }

    public function singleSellingRequest()
    {
        return $this->hasOne(SellingRequest::class,'id', 'selling_request_id');
    }
}
