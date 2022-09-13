<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\Error;
use DB;
use Auth;
use Carbon\Carbon;
use App\Utils\Email;
use App\Models\Bid;
use App\Models\BidFarmer;
use App\Models\FarmerSellBid;


class BidController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Bid;
    }

    public function getList(Request $request)
    {
        $now = now();
        
        $farmer_id = Auth::guard('api')->id();
        $bidObj = new Bid;

        $variety = $bidObj->variety()->getRelated();
        $specification = $bidObj->specification()->getRelated();
        $commodity = $bidObj->commodity()->getRelated();
        $bl = $bidObj->bid_locations()->getRelated();

        $model = $this->model
        ->leftJoin(
            $commodity->getTable(),
            $commodity->qualifyColumn('id'),
            '=',
            $bidObj->qualifyColumn('commodity_id')
        )
        ->leftJoin(
            $variety->getTable(),
            $variety->qualifyColumn('id'),
            $bidObj->qualifyColumn('variety_id')
        )
        ->leftJoin(
            $specification->getTable(),
            $specification->qualifyColumn('id'),
            $bidObj->qualifyColumn('specification_id')
        )
        ->active()
        // ->where('bid_date', '<=', $now->toDateString()) // available bid for date
        ->where('validity', '>', $now->toDateTimeString()) // bid which is not expired
        ->whereHas('bid_farmer', function($q) use($farmer_id){
            $q->where('farmer_id', $farmer_id)
            ->where('bid_status', '0');
        })
        ->orderBy($bidObj->qualifyColumn('id'), 'desc') // latest bids commes first
        ->with(['bid_locations'=>function($q) use($bl){
            $q->active()
            ->select($bl->qualifyColumn('id'), $bl->qualifyColumn('name'));
        }])
        ->select([
            $bidObj->qualifyColumn('id'),
            $bidObj->qualifyColumn('bid_date'),
            $bidObj->qualifyColumn('validity'),
            $bidObj->qualifyColumn('bid_name'),
            $bidObj->qualifyColumn('date_of_movement'),
            $bidObj->qualifyColumn('price'),
            $bidObj->qualifyColumn('commodity_id'), 
            $commodity->qualifyColumn('name').' as commodity_name',
            $bidObj->qualifyColumn('specification_id'),
            $specification->qualifyColumn('name').' as specification_name',
            $bidObj->qualifyColumn('variety_id'),
            $variety->qualifyColumn('name').' as variety_name'
        ]);
        
        return apiPaginationResponse(
            $model, 
            $request->page ?? 1,
            'Returning Available Bid List'
        );
    }

    private function getAvailableTonnageSelection(Bid $item, int $max)
    {
        $isSellingRequest = !empty($item->farmer_sell_bid_id);
        $tonnages =  array_filter(
            config('common.tonnage'), 
            function($v) use($max, $isSellingRequest){
                if($isSellingRequest)
                    return $v==$max;
                return $v <= $max;
            }
        );
        
        if(!in_array($max, $tonnages))
            array_push($tonnages, $max);

        rsort($tonnages);
        return $tonnages;
    }

    public function getTonnageSelection(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        
        $bid = $this->model->find($request->id);

        if(!$bid)
            Error::error('Bid details not found.');

        $bid_farmer = $bid->bid_farmer()
        ->where('farmer_id', Auth::guard('api')->id())
        ->first();

        if(!$bid_farmer)
            Error::error('Bid details not found.');

        $now = now();
        $res = [
            'max_tonnage'=>0,
            'available_tonnage_selections'=>[]
        ]; 
        if($bid_farmer->bid_status=='3' || ($bid_farmer->bid_status == '0' && ($bid->status==0 || $now->gte(Carbon::parse($bid->validity)) || $this->maxAvailableTonnage($bid) < 1)))
            $res['status'] = 3; // expired
        elseif($bid_farmer->bid_status == '0'){
            $res['status'] = 1; // pending , actionable
            $res['available_tonnage_selections'] = $this->getAvailableTonnageSelection($bid, $this->maxAvailableTonnage($bid));
            $res['max_tonnage'] = $res['available_tonnage_selections'][0] ?? 0;
        }
        elseif($bid_farmer->bid_status == '1')
            $res['status'] = 5; // accepted
        elseif($bid_farmer->bid_status == '2')
            $res['status'] = 6; // rejected
        else
            $res['status'] = 0; // unavailbale
        
        return apiFormatResponse(
            'Bid max tonnage and available tonnage for accepting bid',
            $res
        );
    }

    public function get(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        
        $user_id = Auth::guard('api')->id();
        $bm = $this->model->bid_locations()->getModel();

        $item = $this->model->active()
        ->with(['commodity:id,name','variety:id,name','specification:id,name', 'bid_locations:'.$bm->qualifyColumn('id').','.$bm->qualifyColumn('name')])
        ->find($request->id);

        !$item && Error::error('Bid details not found');

        $bid_farmer = $item->bid_farmer()->where('farmer_id', $user_id)->first();
        
        !$bid_farmer && Error::error('Bid details not found');
        // dd($bid_farmer);
        $data = $item->only(['id','bid_name','bid_date','validity', 'validity_utc', 'commodity_id', 'variety_id', 'specification_id','bid_locations', 'max_tonnage', 'price', 'month_of_movement_display']);
        $data['commodity_name'] = $item->commodity->name ?? null;
        $data['specification_name'] = $item->specification->name ?? null;
        $data['variety_name'] = $item->variety->name ?? null;
        $data['selected_tonnage'] = $bid_farmer->tonnage;
    

        if($bid_farmer->bid_status == '1')
            $data['status_code'] = 5;
        elseif($bid_farmer->bid_status == '2')
            $data['status_code'] = 6;
        elseif($item->status <> 1 || $bid_farmer->bid_status == '3' || ($bid_farmer->bid_status == '0' && Carbon::parse($item->validity)->lte(Carbon::now())))
            $data['status_code'] = 3;
        elseif($bid_farmer->bid_status == '0')
            $data['status_code'] = 1;
        else
            $data['status_code'] = 0;

        // switch ($data['status_code']) {
        //     case 3:
        //         $data['status'] = 'Expired';
        //         break;
        //     case 5:
        //         $data['status'] = 'Accepted';
        //         break;
        //     case 6:
        //         $data['status'] = 'Rejected';
        //         break;
        //     default:
        //         $data['status'] = 'Unavailable';
        //         break;
        // }
        // $data['status_og'] = $bid_farmer->bid_status;
        $data['status'] = getFarmerBidStatusesDisplay()[$data['status_code']] ?? '-';
        return apiFormatResponse(
            'Bid details for requested bid id.',
            $data
        );
    }

    private function maxAvailableTonnage(Bid $item)
    {
        $tonnagesAccepted = $item->bid_farmer()->where('bid_status', '1')->sum('tonnage');
        return $item->max_tonnage - $tonnagesAccepted;
    }

    private function hasActionDoneAndGetBidUser($item)
    {
        $now = now();
        $farmer_id = Auth::guard('api')->id();
        $bidFarmer = $item->bid_farmer()->where('farmer_id', $farmer_id)->first();

        if(!$bidFarmer)
            Error::error('Bid details not found');
        elseif($bidFarmer->bid_status != '0')
            Error::error('The bid has been either accepted, rejected or expired.');
        // elseif($now->lt(Carbon::parse($item->bid_date)))
        //     Error::error('Bid details not found');
        elseif($this->maxAvailableTonnage($item) < 1 || $item->status != 1 || $now->gte(Carbon::parse($item->validity)))
            Error::error('The bid has been expired.');
        
        return $bidFarmer;
    }

    
    public function reject(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $farmer = Auth::guard('api')->user();

        $item = $this->model->find($request->id);

        if(!$item)
            Error::error('Bid details not found');

        $bidFarmer = $this->hasActionDoneAndGetBidUser($item);
        $bidFarmer->bid_status = '2'; // rejected
        DB::transaction(function () use($bidFarmer, $item){
            $bidFarmer->save();
            if(!empty($item->farmer_sell_bid_id) && !empty($item->farmer_sell_bid))
            {
                $item->farmer_sell_bid->status = '5'; // rejected by farmer
                $item->farmer_sell_bid->save();
            }
        });


        $subject = 'Someone has rejected a bid';
        $msg = "<b>{$farmer->farmer->mb_name}</b> has rejected your bid for <b>{$item->commodity->name}</b>";
        $this->emailNotifyAdmin($subject, $msg);

        return apiFormatResponse('Bid rejected successfully');
    } 

    public function accept(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $farmer = Auth::guard('api')->user();
        $userId = Auth::id();
        $item = $this->model->find($request->id);

        if(!$item)
            Error::error('Bid details not found');

        $bidFarmer = $this->hasActionDoneAndGetBidUser($item);
        
        $this->validate($request, [
            'tonnage'=> 'required|numeric|in:'.implode(',', $this->getAvailableTonnageSelection($item, $this->maxAvailableTonnage($item)))
        ]);

        $bidFarmer->bid_status = '1'; // accepted
        $bidFarmer->tonnage = $request->tonnage; 

        DB::transaction(function () use($bidFarmer, $item){
            $bidFarmer->save(); 
            
            if(!empty($item->farmer_sell_bid_id) && !empty($item->farmer_sell_bid))
            {
                $item->farmer_sell_bid->status = '4'; // accepted by farmer
                $item->farmer_sell_bid->save();
            } 
            
            if($this->maxAvailableTonnage($item) < 1)
                $item->bid_farmer()->where('bid_status','0')->update(['bid_status'=>'3']);
        });

        $subject = 'Someone has accepted a bid';
        $msg = "<b>{$farmer->farmer->mb_name}</b> has accepted your bid for <b>{$item->commodity->name}</b> of <b>{$bidFarmer->tonnage} tonnage(s)</b>";
        $this->emailNotifyAdmin($subject, $msg);

        return apiFormatResponse('Bid accepted successfully');
    }

    public function history(Request $request)
    {
        if($request->filled('date_from') && !$request->filled('date_to'))
            Error::error('From date and to date both must be selected.');
        if(!$request->filled('date_from') && $request->filled('date_to'))
            Error::error('From date and to date both must be selected.');

        if($request->filled('date_from') && $request->filled('date_to'))
        {
            $date = [
                'from' => Carbon::parse($request->input('date_from'))->startOfDay()->toDateTimeString(),
                'to' => Carbon::parse($request->input('date_to'))->endOfDay()->toDateTimeString()
            ];
        }else{
            $now = now();
            $date = [
                'from' => $now->copy()->subQuarter()->startOfDay()->toDateTimeString(),
                'to' => $now->endOfDay()->toDateTimeString()
            ];
        }

        $now = now();
        $farmerUserId = Auth::guard('api')->id();
        
        $statuses = getFarmerBidStatusesDisplay();

        $table = [
            'bid' => (new Bid)->getTable(),
            'bid_farmer' => (new BidFarmer)->getTable(),
            'sell' => (new FarmerSellBid)->getTable()
        ];

        /*
            Rough Note
            sell.status = 1 Pending(1)
            sell.status = 2 and bid.status = 1 and bid.validity > now Bid Sent(2)
            sell.status = 2 and (bid.status = 0 or bid.validity < now) Expired(3)
            sell.status = 3 Rejected by DG(4)
            sell.status = 4 Accepted(5)
            sell.status = 5 Rejected(6)
        */
        $u1 = DB::table($table['sell'])
        
        ->leftJoin($table['bid'], function($j) use($table){
            $j->on($table['bid'].'.farmer_sell_bid_id', '=', $table['sell'].'.id')
            ->whereNotNull($table['bid'].'.farmer_sell_bid_id');
        })
        ->leftJoin($table['bid_farmer'], $table['bid_farmer'].'.bid_id', '=', $table['bid'].'.id')
        ->where($table['sell'].'.farmer_id', $farmerUserId)
        ->whereRaw("({$table['bid_farmer']}.farmer_id=? OR {$table['bid_farmer']}.farmer_id is null)", [$farmerUserId])
        ->whereBetween("{$table['sell']}.created_at", $date)
        ->selectRaw(
            "{$table['sell']}.id as sell_id, {$table['bid']}.id as bid_id, CONCAT('S',{$table['sell']}.id) as id, (CASE WHEN {$table['bid_farmer']}.id is null then {$table['sell']}.updated_at else {$table['bid_farmer']}.updated_at end) as lastActionAt, DATE({$table['sell']}.created_at) as date, 'Sell' as type,
            @status_code := (CASE when {$table['sell']}.status = '1' then 1 when {$table['sell']}.status = '2' and {$table['bid']}.status = 1 and {$table['bid']}.validity > '{$now->toDateTimeString()}' then 2 when {$table['sell']}.status = '2' and ({$table['bid']}.status = 0 or {$table['bid']}.validity < '{$now->toDateTimeString()}') then 3 when {$table['sell']}.status = '3' then 4 when {$table['sell']}.status = '4' then 5 when {$table['sell']}.status = '5' then 6 else 0 end) as status_code, (CASE WHEN @status_code = 0 then '{$statuses[0]}' WHEN @status_code = 1 then '{$statuses[1]}' WHEN @status_code = 2 then '{$statuses[2]}' WHEN @status_code = 3 then '{$statuses[3]}' WHEN @status_code = 4 then '{$statuses[4]}' WHEN @status_code = 5 then '{$statuses[5]}' WHEN @status_code = 6 then '{$statuses[6]}' end) as status"
        );

        /*
            Rough Note:
            bid_farmer.bid_status = 0 and bid.validity < now Expired(3)
            bid_farmer.bid_status = 3 Expired(3) TonnageExhausted
            bid_farmer.bid_status = 1 Accepted(5)
            bid_farmer.bid_status = 2 Rejected(6)
        */
        /*
        $u2 = DB::table($table['sell'])
        ->rightJoin($table['bid'], function($j) use($table){
            $j->on($table['bid'].'.farmer_sell_bid_id', '=', $table['sell'].'.id')
            ->whereNotNull($table['bid'].'.farmer_sell_bid_id');
        })
        ->whereNull($table['sell'].'.id')
        */

        $u2 = DB::table($table['bid'])
        ->join($table['bid_farmer'], $table['bid_farmer'].'.bid_id', '=', $table['bid'].'.id')
        ->whereNull($table['bid'].'.farmer_sell_bid_id')
        ->whereBetween("{$table['bid']}.bid_date", $date)
        ->where($table['bid_farmer'].'.farmer_id', $farmerUserId)
        ->where(function($w) use($table){
            $w->where($table['bid'].'.status', true)
            ->orWhere($table['bid_farmer'].'.bid_status', '!=', '0');
        })
        ->where(function($w) use($table, $now){
            $w->where($table['bid'].'.validity', '<', $now->toDateTimeString())
            ->orWhere($table['bid_farmer'].'.bid_status', '!=', '0');
        })
        ->selectRaw(
            "null as sell_id,  {$table['bid']}.id as bid_id, CONCAT('B',{$table['bid']}.id) as id, {$table['bid_farmer']}.updated_at as lastActionAt, {$table['bid']}.bid_date as date, 'Bid' as type,
            @status_code := (CASE when {$table['bid_farmer']}.bid_status = '3' or ({$table['bid_farmer']}.bid_status = '0' and {$table['bid']}.validity < '{$now->toDateTimeString()}') then 3 when {$table['bid_farmer']}.bid_status = '0' then 2 when {$table['bid_farmer']}.bid_status = '1' then 5 when {$table['bid_farmer']}.bid_status = '2' then 6 else 0 end) as status_code, (CASE WHEN @status_code = 0 then '{$statuses[0]}' WHEN @status_code = 1 then '{$statuses[1]}' WHEN @status_code = 2 then '{$statuses[2]}' WHEN @status_code = 3 then' {$statuses[3]}' WHEN @status_code = 4 then '{$statuses[4]}' WHEN @status_code = 5 then '{$statuses[5]}' WHEN @status_code = 6 then '{$statuses[6]}' end) as status"
        )
        ->unionAll($u1);
        
        $records = DB::table(DB::raw('('.$u2->toSql().') as zombie'))
        ->orderBy('zombie.lastActionAt', 'desc')
        ->selectRaw('sell_id,bid_id,id,date,type,status_code,status'
        )
        ->mergeBindings($u2);
        return apiPaginationResponse($records, 1, 'Retrive account history');
    }
}
