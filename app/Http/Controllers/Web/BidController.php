<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Models\BidLocation;
use App\Models\FarmerGroup;
use App\Models\User;
use App\Models\BidLocationMaster;
use App\Models\SellingRequest;
use App\Models\Bid;
use App\Models\BidFarmer;
use App\Models\Variety;
use App\Models\CommodityMaster;
use App\Models\SpecificationMaster;
use App\Models\FarmerClient;
use App\Models\Farmer;
use Validator;
use App\Http\Requests\Bid\BidStoreRequest;
use App\Http\Requests\Bid\BidUpdateRequest;
use App\Http\Requests\FarmerSellBid\SellRequest;
use App\Http\Traits\SMSTrait;
use App\Models\CountryMaster;
use App\Models\DeliveryLocation;
use App\Utils\Sms;
use App\Utils\Email;
use App\Utils\PushNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Traits\NotificationTrait;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use SMSTrait;
    use NotificationTrait;
    public function index(Request $request)
    {

        if (!$request->ajax())
            return view('bid.index');

        $items =  Bid::select(['id', 'publish_on', 'bid_name', 'valid_till', 'created_at', 'max_tonnage', 'selling_request_id', 'date_of_movement'])
            ->with(['bidFarmer'])->where('status', '!=', 2);
        if ($request->filled('from_date'))
            $items = $items->whereDate('created_at', '>=', filterDate($request->from_date));
        if ($request->filled('to_date'))
            $items = $items->whereDate('created_at', '<=', filterDate($request->to_date));

        return datatables()::of($items)
            ->orderColumn('month_of_movement_display', function ($q, $order) {
                $q->orderBy('date_of_movement', $order);
            })
            ->addIndexColumn()
            ->addColumn('total_bid_accepted', function ($row) {
                return $row->bidFarmer->where('status', '1')->sum('tonnage');
            })
            ->addColumn('no_of_farmer', function ($row) {
                return $row->bidFarmer->count();
            })
            ->editColumn('created_at', function ($row) {
                return displayDate($row->created_at);
            })
            ->editColumn('valid_till', function ($row) {
                return displayDateTime($row->valid_till);
            })
            ->rawColumns(['action', 'no_of_farmer'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        
        $sell_request = null;
        if ($request->filled('selling_request_id')) {
            $sell_request = SellingRequest::where('status', '1')->find($request->selling_request_id);

            if (!$sell_request)
                return redirect()->back()->withError('This selling request can\'t be accepted.');
        }

        if ($request->ajax()) {
            $items = Farmer::select(['id', 'username'])->where('country_id', auth()->user()->selected_country_id)->orWhereHas('countries', function ($q) {
                $q->where('country_farmer.status', 1)
                    ->Where('country_farmer.country_id', auth()->user()->selected_country_id);
            });
            if ($sell_request) {
                $farmer = Farmer::find($sell_request->farmer_id);
                $items = $items->when($farmer !== null, function ($q) use ($farmer) {
                    $q->where('id', $farmer->id);
                });
            }
            return datatables()::of($items)
                ->make(true);
        }


        $commodity = CommodityMaster::where('status', 1)
            ->orderBy('name')
            ->select('id', 'name')
            ->get();
        $bidLocation = BidLocationMaster::active()
            ->orderBy('name')
            ->select('name', 'id')
            ->get();
        $deliveryLocations = DeliveryLocation::active()
            ->orderBy('name')
            ->select('name', 'id')
            ->get();

        $farmer_groups = FarmerGroup::select(['id', 'name'])
            ->where('country_id', auth()->user()->selected_country_id)
            ->where('status', 1)
            ->get();
        $countries = CountryMaster::where('status', 1)
            ->orderBy('id', 'desc')
            ->select('id', 'name')
            ->get();

        return view('bid.create', compact('commodity', 'deliveryLocations', 'sell_request', 'farmer_groups', 'bidLocation', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BidStoreRequest $request)
    {
        $data = $request->validated();
        $sell_request = null;
        if ($request->filled('sell_request_id')) {
            $sell_request = SellingRequest::where('status', '1')->find($request->sell_request_id);
            if (!$sell_request)
                return redirect()->back()->withError('This selling request can\'t be accepted.');
        }
        $data['bid_code'] = generateUniqueBidCode();
        $data['date_of_movement'] = date('Y-m-d', strtotime($data['month_of_movement'] . -01));
        $data['delivery_method'] == 2 ?  $data['delivery_location_id'] = $data['delivery_location_id'] : $data['delivery_address'] = $data['delivery_address'];
        $data['country_id'] = auth()->user()->selected_country_id;
        // $group_ids = explode(',',$inputs['group_ids']);
        $farmers = collect();

        try {
            DB::beginTransaction();
            if ($sell_request) {
                $sell_request->status = 2; // Bid Sent
                $data['selling_request_id'] = $sell_request->id;
                $sell_request->save();
            }
            $bid = Bid::create($data);
            $bid->bidLocation()->sync($data['bid_location_id']);
            if ($sell_request) {
                $farmers->push($sell_request->farmer);
                $bid->bidFarmer()->firstOrCreate([
                    'farmer_id' => $sell_request->farmer->id
                ]);
            } else {
                if ($data['group_or_individual'] == 1) {
                    $fgs = FarmerGroup::whereIn('id', $data['group_id'])
                        ->with('farmers')->get();

                    foreach ($fgs  as $fg) {
                        foreach ($fg->farmers as $farmer) {
                            $bid->bidFarmer()->firstOrCreate([
                                'farmer_id' => $farmer->id
                            ]);
                            $farmers->push($farmer);
                        }
                    }
                } else {
                    foreach ($data['farmer_id'] as $farmer_id) {
                        $farmer = Farmer::find($farmer_id);

                        $bid->bidFarmer()->firstOrCreate([
                            'farmer_id' => $farmer->id
                        ]);
                        $farmers->push($farmer);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        //create seperate function for push notification in helpers
        if (true == $bid->status) {
            $date_of_movement = Carbon::parse($bid->date_of_movement);

            $title = $bid->bid_name . " Bid Created";
            $body = trans('messages.bid_sms_text', ['app_name' => config('app.name'), 'commodity_name' => $bid->commodity->name, 'bid_location' => $bid->bidLocation->pluck('name')->implode(', '), 'date_of_movement' => $date_of_movement->format('M Y')]);
            $farmer_ids = $farmers->map(function ($farmer) {
                return $farmer->id;
            });
            $notification_data = [
                'item_id' => $bid->id,
                'title' => $title,
                'description' => $body,
                'item_type' => 3,
                'type' => 1,
                'device_type' => 1,
                'ip_address' => \Request::ip(),
                'country_id' => $data['country_id']
            ];
            $this->createNotification($notification_data, 'is_bids_received_notification', 1, auth()->user(), $farmer_ids->toArray());
            $farmer = new Farmer();
            $farmers = $farmer->getFarmersPhoneNumber('is_bids_received_sms', $farmer_ids->toArray());
            if (count($farmers) > 0) {
                foreach ($farmers as  $farmer) {
                    $this->sendSMS($body, $farmer['phone_number']);
                }
            }
        }

        // $smsFailed = [];
        // $data = [
        //     'Screen_Name' => 'BidDetails',
        //     'BidID' => $bid->id
        // ];

        // if ($farmers->count()) {
        //     $this->notification
        //         ->send($farmers->map(function ($farmer) {
        //             return $farmer->mb_id;
        //         }), $title, $body, $data);

        //     foreach ($farmers as $farmer) {
        //         if ($farmer->opt_in == 1 && $farmer->mobile_verified)
        //             $this->sms->send($body, $farmer->mobile_number);
        //     }
        // }

        return redirect('bid')->with('success', 'Bid Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Bid $bid)
    {

        if ($request->ajax()) {

            $items =  BidFarmer::join('farmers', function ($join) {
                $join->on('bid_farmers.farmer_id', '=', 'farmers.id');
            })->select(['bid_farmers.reason', 'bid_farmers.status', 'bid_farmers.tonnage', 'bid_farmers.farmer_id', 'bid_farmers.counter_offer', 'farmers.username as username', 'farmers.id as user_id', 'farmers.deleted_at', 'farmers.is_suspend', 'bid_farmers.bid_id'])->where('bid_id', $bid->id)->orderBy('farmers.id', 'desc');
            return datatables()::of($items)
                ->filter(function ($q) use ($request, $items) {
                    if ($request->filled('search.value'))
                        $q->where('farmers.username', 'LIKE', '%' . $request->input('search.value') . '%');
                })
                ->addColumn('username', function ($row) {
                    if ($row->deleted_at != null) {
                        return  $row->username . '&nbsp;&nbsp;<span class="badge badge-pill badge-danger">Deleted</span>';
                    } elseif ($row->is_suspend) {
                        return  $row->username . '&nbsp;&nbsp;<span class="badge badge-pill badge-warning">Suspended</span>';
                    } else {
                        return $row->username;
                    }
                })
                // ->addColumn('action', function ($row) {


                //     $row->status == 2 && $row->counter_offer > 0 ? $btn = '<a href="javascript:void(0)" class="accept_btn btn btn-outline-success btn-sm"  bid-id=' . $row->bid_id . ' farmer-id=' . $row->farmer_id . '>
                //         <i class="fa fa-check" aria-hidden="true"></i>
                //             </a>
                //             <a href="javascript:void(0)" 
                //             class="reject_btn btn btn-outline-danger btn-sm" bid-id=' . $row->bid_id . 'farmer-id=' . $row->farmer_id . '>
                //             <i class="fa fa-times" aria-hidden="true"></i>
                //         </a>' : $btn = "";

                //     return $btn;
                // })

                ->rawColumns(['action', 'username'])
                ->make(true);
        }
        $bid->with('variety', 'specification', 'commodity')->withCount(['bidFarmer', 'bidLocation'])->first();
        $isExpired = now()->gte(Carbon::parse($bid->valid_till));
        if ($request->n_id) {
            updateNotificationStatus($request->n_id);
        };

        return view('bid.show', compact('bid', 'isExpired'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        if ($request->ajax()) {
            $items =  User::select(['id', 'name'])->active()->role(config('common.user_role.FARMER'));
            return datatables()::of($items)
                ->addColumn('action', function ($row) {
                    $btn = '<input type="checkbox" id="user' . $row->id . '" onchange="on_checked(this)" value="' . $row->id . '">';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        // $temp=[];

        $bid = Bid::with('bid_user', 'commodity', 'variety', 'specification')->findOrFail($id);
        if (Carbon::parse($bid->validity)->lte(now()))
            return redirect()->back()->withError('You can\'t edit expired bid.');

        $bid->bid_location_id = BidLocation::where('bid_id', $bid->id)->pluck('bid_location_id')->toArray();
        $temp = BidUser::where('bid_id', $id)->pluck('user_id')->toArray();

        $bid->user_ids = implode(',', $temp);
        $bid->user_ids_arr = $temp;


        $commodity = CommodityMaster::where('status', 1)->orderBy('name')->pluck('name', 'id');
        $commodity->prepend($bid->commodity->name, $bid->commodity->id);
        $variety = Variety::where(['status' => 1, 'commodity_id' => $bid->commodity_id])->orderBy('name')->pluck('name', 'id');
        $variety->prepend($bid->variety->name, $bid->variety->id);
        $specification = SpecificationMaster::where(['status' => 1, 'commodity_id' => $bid->commodity_id])->orderBy('name')->pluck('name', 'id');
        $specification->prepend($bid->specification->name, $bid->specification->id);
        $bidLocation = BidLocationMaster::where('status', 1)->orderBy('name')->pluck('name', 'id');
        $tonnage = config('common.tonnage');

        return view('bid.edit', compact('bid', 'commodity', 'variety', 'specification', 'bidLocation', 'tonnage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $bid = Bid::findOrFail($id);
            if (Carbon::parse($bid->validity)->lte(now()))
                return redirect()->back()->withError('You can\'t edit expired bid.');
            $bid->bid_name = $request->bid_name;
            $bid->bid_date = $request->bid_date;
            $bid->commodity_id = $request->commodity_id;
            $bid->variety_id = $request->variety_id;
            $bid->specification_id = $request->specification_id;
            $bid->max_tonnage = $request->max_tonnage;
            $bid->price = $request->price;
            $bid->validity = $request->validity;

            $bid->status = 1;
            $bid->save();
            $bid_id = $bid->id;
            BidLocation::where('bid_id', $bid_id)
                ->whereNotIn('bid_location_id', $request->bid_location_id)
                ->forcedelete();

            $existing_locations = BidLocation::where('bid_id', $bid_id)->pluck('bid_location_id')->toArray();
            foreach ($request->bid_location_id as $key => $value) {
                if (!in_array($value, $existing_locations)) {
                    BidLocation::create([
                        'bid_id' => $bid_id,
                        'bid_location_id' => $value,
                    ]);
                }
            }


            $user_ids = explode(',', $request->user_ids);

            BidUser::where('bid_id', $bid_id)
                ->whereNotIn('user_id', $user_ids)
                ->forcedelete();

            $existing_user = BidUser::where('bid_id', $bid_id)->pluck('user_id')->toArray();

            foreach ($user_ids as $key => $value) {
                if (!in_array($value, $existing_user)) {
                    BidUser::create([
                        'bid_id' => $bid_id,
                        'user_id' => $value,
                    ]);
                }
            }

            DB::commit();

            return redirect('bid')->with('success', 'Bid Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('bid')->with('error', 'Bid update Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bid = Bid::findOrFail($id);
        try {

            if (Carbon::parse($bid->validity)->lte(now()))
                return redirect()->back()->withError('You can\'t delete expired bid.');
            $bid->destroy($id);



            return response()->json(['status' => 'true']);
        } catch (\Exception $e) {

            return response()->json(['status' => 'false']);
        }
    }
    public function get_data($id)
    {

        $data['variety'] = Variety::where(['status' => 1, 'commodity_id' => $id])->orderBy('name')->pluck('name', 'id');
        $data['specification'] = SpecificationMaster::where(['status' => 1, 'commodity_id' => $id])->orderBy('name')->pluck('name', 'id');
        return $data;
    }

    public function display_bid_status($status)
    {
        switch ($status) {
            case 0:
                return "Pending";
                break;
            case 1:
                return "Accepted";
                break;
            case 2:
                return "Rejected";
                break;
            case 3:
                return "Expired";
                break;
            default:
                return "Undefined";
        }
    }

    public function updateStatus(Request $request, $id)
    {
        if (!$request->filled('status') || ($request->status != 1 && $request->status != 0))
            return redirect()->back()->withError('Please select bid status.');

        $item = Bid::findOrFail($id);
        $item->status = $request->status;
        DB::transaction(function () use ($item) {
            $item->save();
        });

        return redirect()->route('bid.index')->withSuccess('Bid status successfully updated');
    }

    public function accept_counter_offer(Request $request)
    {
        // return $request->all();
        DB::beginTransaction();
        try {
            $bid = Bid::find($request->bid_id);
            $bid->bidFarmer()->where('farmer_id', $request->farmer_id)->update(['status' => 3]);
            $sell_request = $bid->singleSellingRequest()->where('farmer_id', $request->farmer_id);
            if ($sell_request) {
                $sell_request->update(['status' => 6]);
            }

            if (true == $bid->status) {
                $date_of_movement = Carbon::parse($bid->date_of_movement);

                $title = $bid->bid_name . '-' . __('app_notification.counter_offer_accepted');
                $body = trans('messages.bid_sms_text', ['app_name' => config('app.name'), 'commodity_name' => $bid->commodity->name, 'bid_location' => $bid->bidLocation->pluck('name')->implode(', '), 'date_of_movement' => $date_of_movement->format('M Y')]);
                $notification_data = [
                    'item_id' => $bid->id,
                    'title' => $title,
                    'description' => $body,
                    'item_type' => config('common.notification_item_type.counter_offer'),
                    'type' => 1,
                    'device_type' => 1,
                    'ip_address' => \Request::ip(),
                    'country_id' => $bid->country_id
                ];
                $this->createNotification($notification_data, 'is_bids_received_notification', 1, auth()->user(), [$request->farmer_id]);
                $farmer = new Farmer();
                $farmers = $farmer->getFarmersPhoneNumber('is_bids_received_sms',  [$bid->farmer_id]);
                if (count($farmers) > 0) {
                    foreach ($farmers as  $farmer) {
                        $this->sendSMS($body, $farmer['phone_number']);
                    }
                }
            }

            DB::commit();

            return response()->json(['status' => 'true']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'false']);
        }
    }


    public function reject_counter_offer(Request $request)
    {

        DB::beginTransaction();
        try {
            $bid = Bid::find($request->bid_id);
            $bid->bidFarmer()->where('farmer_id', $request->farmer_id)->update(['status' => 4, 'reason' => $request->reason]);
            $sell_request = $bid->singleSellingRequest()->where('farmer_id', $request->farmer_id);
            if ($sell_request) {
                $sell_request->update(['status' => 7, 'reason' => $request->reason]);
            }
            if (true == $bid->status) {
                $date_of_movement = Carbon::parse($bid->date_of_movement);

                $title = $bid->bid_name . '-' . __('app_notification.counter_offer_rejected');
                $body = trans('messages.bid_sms_text', ['app_name' => config('app.name'), 'commodity_name' => $bid->commodity->name, 'bid_location' => $bid->bidLocation->pluck('name')->implode(', '), 'date_of_movement' => $date_of_movement->format('M Y')]);
                $notification_data = [
                    'item_id' => $bid->id,
                    'title' => $title,
                    'description' => $body,
                    'item_type' => config('common.notification_item_type.counter_offer'),
                    'type' => 1,
                    'device_type' => 1,
                    'ip_address' => \Request::ip(),
                    'country_id' => $bid->country_id
                ];
                $this->createNotification($notification_data, 'is_bids_received_notification', 1, auth()->user(), [$request->farmer_id]);
                $farmer = new Farmer();
                $farmers = $farmer->getFarmersPhoneNumber('is_bids_received_sms',  [$bid->farmer_id]);
                if (count($farmers) > 0) {
                    foreach ($farmers as  $farmer) {
                        $this->sendSMS($body, $farmer['phone_number']);
                    }
                }
            }
            DB::commit();

            return response()->json(['status' => 'true']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'false']);
        }
    }
}
