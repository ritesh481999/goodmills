<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmerGroup extends Model
{
	protected $fillable = ['name', 'status','country_id'];

    public function farmers() {
        return $this->belongsToMany('App\Models\Farmer', 'farmer_group_farmers', 'farmer_group_id','farmer_id');
    }

    public function country()
    {
        return $this->hasOne(CountryMaster::class, 'id', 'country_id');
    }
}