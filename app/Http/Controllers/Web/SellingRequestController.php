<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use App\Models\Bid;
use App\Models\Notification;
use App\Models\SellingRequest;
use Carbon\Carbon;
use Hamcrest\Core\IsNull;
use Illuminate\Support\Facades\Route;
use App\Http\Traits\NotificationTrait;

class SellingRequestController extends Controller
{
    use NotificationTrait;
    const VIEW_DIR = "selling_request.";
    private $selling_request;

    public function __construct()
    {
        $this->selling_request = new SellingRequest;
    }

    public function index(Request $request)
    {
        try {
            DB::enableQueryLog();

            if ($request->ajax()) {
                $items = $this->selling_request->with(['farmer:id,name,username,deleted_at'])->select(['id', 'date_of_movement', 'created_at', 'status', 'farmer_id']);
                if ($request->filled('date_from'))
                    $items = $items->whereDate('created_at', '>=', filterDate($request->date_from));
                if ($request->filled('date_to'))
                    $items = $items->whereDate('created_at', '<=', filterDate($request->date_to));
                if ($request->filled('status'))
                    $items = $items->whereStatus($request->status);

                return datatables()::of($items)
                    ->addIndexColumn()
                    ->editColumn('date_of_movement', function ($row) {
                        return displayMonthYear($row->date_of_movement);
                    })
                    ->addColumn('farmers', function ($row) {
                        // return $row->farmer->name;
                        return $row->farmer->deleted_at != null ?  $row->farmer->username  . '&nbsp;&nbsp;<span class="badge badge-pill badge-danger">Deleted</span>' : $row->farmer->username;
                    })
                    ->editColumn('created_at', function ($row) {
                        return displayDate($row->created_at);
                    })
                    ->editColumn('status', function ($row) {
                        $status = $row->status;
                        switch ($status) {
                            case "1":
                                $color_code = 'primary';
                                break;
                            case "2":
                                $color_code = 'success';
                                break;
                            case "3":
                                $color_code = 'danger';
                                break;
                            case "4":
                                $color_code = 'success';
                                break;
                            case "5":
                                $color_code = 'danger';
                                break; 
                            case "6":
                                $color_code = 'success';
                                break;
                            case "7":
                                $color_code = 'danger';
                                break;

                        }
                        return sprintf(
                            '<span class="badge badge-pill badge-%s">%s</span>',
                            $color_code,
                            selling_request_status($row->status)
                        );
                    })
                    ->rawColumns(['status', 'farmers'])
                    ->make(true);
            }
            $statuses = SellingRequest::STATUS;
            return view(self::VIEW_DIR . 'index', compact('statuses'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function show(Request $request, $id)
    {

        if ($request->n_id) {
            updateNotificationStatus($request->n_id);
        };
        $item = $this->selling_request->with('farmer:id,name,deleted_at', 'specification:id,name', 'variety:id,name', 'commodity:id,name', 'deliveryLocation:id,name', 'bid:id,bid_code')->findOrFail($id);

        //$status = SellingRequest::STATUS[$item->status]; 



        //$item->load(['farmer', 'specification', 'variety', 'commodity']);
        return view(self::VIEW_DIR . '.show', compact('item'));
    }

    public function reject(Request $request)
    {
        $item = $this->selling_request->findOrFail($request->selling_request_id);
        if ($item->status != 1)
            return redirect()->back()->withError(trans('common.selling_request.reject_error'));
        $item->status = 3;
        $item->reason = $request->reason;
        $item->save();
        $bid_details = [
            'date_of_movement' => $item->date_of_movement,
            'commodity_id' => $item->commodity_id,
            'specification_id' => $item->specification_id,
            'variety_id' => $item->variety_id,
            'country_id' => $item->country_id,
            'max_tonnage' => $item->tonnage,
            'delivery_location_id' => !empty($item->delivery_location_id) && !is_null($item->delivery_location_id) ? $item->delivery_location_id : null,
            'delivery_method' => !empty($item->delivery_method) && !is_null($item->delivery_method) ?  $item->delivery_method  : null,
            'delivery_address' => !empty($item->delivery_address) && !is_null($item->delivery_address) ?   $item->delivery_address  : null,
            'status' => 2,
            'bid_code' => generateUniqueBidCode(),
            'selling_request_id' => $item->id
        ];

        Bid::create($bid_details);
        if ($item->status == 3 && !empty($item->reason)) {
            $date_of_movement = Carbon::parse($item->date_of_movement);

            $title = trans('messages.selling_request_title_reject_message', ['app_name' => config('app.name')]);
            $body = trans('messages.selling_request_reject_message', ['app_name' => config('app.name'), 'commodity_name' => $item->commodity->name, 'date_of_movement' => $date_of_movement->format('M Y')]);
            $notification_data = [
                'item_id' => $item->id,
                'title' => $title,
                'description' => $body,
                'item_type' => config('common.notification_item_type.selling_request'),
                'type' => 1,
                'device_type' => 1,
                'ip_address' => \Request::ip(),
                'country_id' => $item->country_id
            ];
            $this->createNotification($notification_data, 'is_bids_received_notification', 1, auth()->user(), [$item->farmer_id]);
        }

        return redirect()->route('selling_request.index')->withSuccess(trans('common.selling_request.reject_success'));
    }

    public function accept(Request $request, $id)
    {
        $item = $this->model->findOrFail($id);
        if ($item->status != 5)
            return redirect()->back()->withError('Selling request status not satisfied.');

        $allow_tonnages = array_values(array_filter(
            config('common.tonnage'),
            function ($v) use ($item) {
                return $v <= $item->tonnage;
            }
        ));
        $this->validate($request, [
            'tonnage' => 'required|in:' . implode(',', $allow_tonnages),
            'offer_amount' => 'required|numeric|min:1'
        ]);

        $now = now();
        $bid = new Bid;
        $bid->bid_name = 'AUTO GENERATED BID';
        $bid->bid_date = $now->toDateString();
        $bid->commodity_id = $item->commodity_id;
        $bid->variety_id = $item->variety_id;
        $bid->specification_id = $item->specification_id;
        $bid->country_id = $item->country_id;
        $bid->max_tonnage = $request->tonnage;
        $bid->price = $request->offer_amount;
        $bid->validity = $now->addDays(10)->toDateTimeString();
        $bid->status = 1;
        $bid->farmer_sell_bid_id = $item->id;
        $bid->save();

        $bid->bid_user()->create([
            'user_id' => $item->farmer_user_id,
            'tonnage' => $bid->max_tonnage
        ]);

        if (!empty($item->drop_off_location_id) && $item->drop_off_location_id > 0)
            $bid->bid_location()->create(['bid_location_id' => $item->drop_off_location_id]);

        $item->status = 2; // Bid Sent
        $item->save();

        return redirect()->route('farmer_sell_bid.index')->withSuccess('Bid sent successfully.');
    }
}
