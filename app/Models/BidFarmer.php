<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BidFarmer extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = ['bid_id', 'farmer_id', 'tonnage', 'counter_offer', 'status'];

    public const STATUS = [
        '0' => 'Pending',
        '1' => 'Accepted',
        '2' => 'Rejected',
        '3' => 'Accepted Counter Offer',
        '4' => 'Rejected Counter Offer', 
        
    ];

     protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function bid()
    {
        return $this->belongsTo(Bid::class, 'bid_id');
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'farmer_id');
    }
}
