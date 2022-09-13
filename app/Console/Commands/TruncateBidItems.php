<?php

namespace App\Console\Commands;

use App\Http\Requests\FarmerSellBid\SellRequest;
use App\Models\Bid;
use App\Models\BidFarmer;
use App\Models\CountryMaster;
use App\Models\Farmer;
use App\Models\SellingRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateBidItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:bidItems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Bid Items of Deleted Farmers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->deleteBidItems();
        $this->scheduledDeletionData();
    }

    private function deleteBidItems()
    {
        $countries = CountryMaster::where('status', 1)->get();
        $bid_delete_result = [];
        $selling_delete_request = [];
        foreach ($countries as $country) {
            $duration = $country->duration;
            $from_date = date('Y-m-d', strtotime("-$duration month"));
            $to_date = date('Y-m-d');
            $farmer_ids = Farmer::where('country_id', $country->id)->onlyTrashed()->whereBetween('deleted_at', [$from_date, $to_date])->pluck('id')->toArray();
            if (is_array($farmer_ids)) {
                $bid_ids = Bid::whereHas('bidFarmer', function ($query) use ($farmer_ids) {
                    $query->whereIn('farmer_id', $farmer_ids);
                })->pluck('id')->toArray();
                $bid_farmer = BidFarmer::whereIn('bid_id', $bid_ids)->whereNotIn('farmer_id', $farmer_ids)->get();
                if (count($bid_farmer) == 0) {
                    $bid = Bid::whereIn('id', $bid_ids)->delete();
                    if ($bid == true) {
                        $bid_delete_result[] = $bid_ids;
                    }
                }
                $selling_request_ids = SellingRequest::whereIn('farmer_id', $farmer_ids)
                    ->pluck('id')
                    ->toArray();
                if (count($selling_request_ids) > 0) {
                    $selling_request = SellingRequest::whereIn('id', $selling_request_ids)
                        ->delete();
                    if ($selling_request == true) {
                        $selling_delete_request[] = $selling_request_ids;
                    }
                }
            }
        }

        if (count($bid_delete_result) || count($selling_delete_request)) {
            echo 'Script executed successfully.';
        } else {
            echo 'Script failed.';
        }
    }

    private function scheduledDeletionData()
    {

        $farmers = Farmer::where('scheduled_deleted_date', '<=', Carbon::now())->get();
        if ($farmers->count() > 0) {
            foreach ($farmers as  $farmer) {
                $bid_ids = Bid::whereHas('bidFarmer', function ($query) use ($farmer) {
                    $query->where('farmer_id', $farmer->id);
                })->pluck('id')->toArray();
                $bid_farmer = BidFarmer::whereIn('bid_id', $bid_ids)->where('farmer_id','!=', $farmer->id)->get();
                if (count($bid_farmer) == 0) {
                    $bid = Bid::whereIn('id', $bid_ids)->delete();
                    if ($bid == true) {
                        $bid_delete_result[] = $bid_ids;
                    }
                }
                $selling_request_ids = SellingRequest::where('farmer_id', $farmer->id)
                    ->pluck('id')
                    ->toArray();
                if (count($selling_request_ids) > 0) {
                    $selling_request = SellingRequest::where('id', $selling_request_ids)
                        ->delete();
                    if ($selling_request == true) {
                        $selling_delete_request[] = $selling_request_ids;
                    }
                }
				$farmer->delete();
            }
        }
    }
}
