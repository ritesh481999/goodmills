<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FarmerSellBid;
use App\Http\Requests\FarmerSellBid\SellRequest;
use App\Utils\Error;
use DB;
use Carbon\Carbon;

class FarmerSellBidController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new FarmerSellBid;
    }

    public function sellRequest(SellRequest $request)
    {
        $data = $request->validated();
        $farmer = $request->user();
        // if($data['delivery_method'] != 1)
        //     $data['drop_off_location_id'] = null;
        // elseif($data['delivery_method'] != 2)
        //     $data['postal_code'] = '';

        if($data['delivery_method'] != 1)
            $data['postal_code'] = '';
        elseif($data['delivery_method'] != 2){
            $data['postal_code'] = $data['postal_code'] ?? '';
            $data['drop_off_location_id'] = null;
        }

        $data['date_of_movement'] = $data['month_of_movement'] . '-01';
        $data['farmer_id'] = $farmer->id;
        $data['status'] = '1';
        
        DB::transaction(function () use($data, $farmer) {
            $fsb = FarmerSellBid::create($data);
            $subject = 'Someone has sent a selling request';
            $msg = "<b>{$farmer->farmer->mb_name}</b> has sent a selling request for 
            <b>{$fsb->commodity->name}</b> of <b>{$fsb->tonnage} tonnage(s)</b>";
            $this->emailNotifyAdmin($subject, $msg);
        });
        

        return apiFormatResponse('Selling request created successfully');
    }

    public function get(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        
        $user_id = $request->user()->id;
        $item = $this->model->where('farmer_id', $user_id)
        ->with(['commodity:id,name','variety:id,name','specification:id,name','deliveryLocation:id,name'])
        ->find($request->id);
        
        !$item && Error::error('Selling request not found');

        $res = $item->only(['id','commodity_id','specification_id','variety_id','drop_off_location_id','tonnage','delivery_method','postal_code', 'month_of_movement_display']);
        $res['commodity_name'] = $item->commodity->name ?? null;
        $res['specification_name'] = $item->specification->name ?? null;
        $res['variety_name'] = $item->variety->name ?? null;
        $res['drop_off_location_name'] = $item->deliveryLocation->name ?? null;
        $res['status_code'] = 0;
        // dd($item->bid);
        if($item->status == '1') {
            $res['status_code'] = 1;
        }
        elseif($item->status == '3') {
            $res['status_code'] = 4;
         }
        elseif($item->status == '4') {
            $res['status_code'] = 5;
        }
        elseif($item->status == '5') {
            $res['status_code'] = 6;
        }
        elseif($item->status == '2' && $item->bid) {
           
            $validity = Carbon::parse($item->bid->validity);
            $now = now();
            if($item->bid->status == 1 && $validity->gt($now))
                $res['status_code'] = 2;
            elseif($item->bid->status == 0 || $validity->lte($now))
                $res['status_code'] = 3;
        }
        $res['status'] = getFarmerBidStatusesDisplay()[$res['status_code']] ?? '-';

        return apiFormatResponse('Retrieving the bid selling request', $res);
    }

    public function getTonnageSelectionList()
    {
        $tonnages = getTonnages('asc');
        return apiFormatResponse('Retrieving the list of tonnage selection', $tonnages);
    }
}