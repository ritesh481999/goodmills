<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Farmer\FarmerCreateRequest;
use App\Http\Requests\FarmerSellBid\SellRequest;
use App\Mail\SendAccAcceptOrRejectEmail;
use App\Models\Farmer;
use App\Models\Notification;
use App\Models\SellingRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Traits\NotificationTrait;
use Illuminate\Support\Facades\Log;


class FarmerController extends Controller
{
    use NotificationTrait;
    const VIEW_DIR = "farmers.";
    private $farmer;

    public function __construct(Farmer $farmer)
    {
        $this->farmer = $farmer;
    }

    public function index(Request $request)
    {

        $farmer_id = $request->farmer_id;

        // $items =  Farmer::orderBy('id', 'desc')->with('countries')->get();
        // $countryArr = [];
        // foreach($items->countries() as $country)
        // {
        //     if($country)
        //     {
        //         $countryArr[]=$country->name;
        //     }
        // }
        // dd($countryArr);
        // if ($roleName !== 'Department') {

        //     $html .=    '<li class="dropdown-item" role="presentation"><a role="menuitem" tabindex="-1" href="#"><button type="button" name="dept" id="' . $data->id . '" class="dept btn btn-info btn-sm">Dept</button></a></li>';
        // }
        if ($request->ajax()) {
            $items =  Farmer::with('countries')->orderBy('id', 'desc');
            if ($request->filled('from_date'))
                $items = $items->whereDate('created_at', '>=', filterDate($request->from_date));
            if ($request->filled('to_date'))
                $items = $items->whereDate('created_at', '<=', filterDate($request->to_date));

            return datatables()::of($items)
                ->addIndexColumn()

                ->editColumn('created_at', function ($row) {
                    return displayDate($row->created_at);
                })

                ->editColumn('status', function ($row) {
                    return sprintf(
                        '<span style="cursor: pointer;" class="status badge badge-pill badge-%s" data-status="%s" data-id="%s">%s</span>',
                        $row->status ? 'success' : 'danger',
                        $row->status ? 0 : 1,
                        $row->id,
                        $row->status ? 'Active' : 'In-active'
                    );
                })->addColumn('action', function ($row) {
                    $view =  route('farmer.edit', $row->id);
                    $btn = '<a href=' . "{$view}" . ' class="edit btn btn-primary btn-sm editNews"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0)" data-id=' . $row->id . ' class="delete btn btn-danger btn-sm deleteFarmer"><i class="fas fa-trash"></i></a>
                        <a href="javascript:void(0)" data-id=' . $row->id . ' class="btn btn-danger btn-sm countryApproval"><i class="fas fa-tasks"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $notification_id = $request->n_id;
        if ($notification_id) {
            updateNotificationStatus($notification_id);
        }
        return view('farmers.index', compact('farmer_id'));
    }


    public function create()
    {

        return view(self::VIEW_DIR . 'create');
    }


    public function store(FarmerCreateRequest $request)
    {



        $data = $request->validated();
        $data['country_id'] = auth()->user()->selected_country_id;
        $data['pin'] = Hash::make($data['pin']);
        if ($data['others']) {
            $data['user_type'] = $data['others'];
        }
        $data['is_suspend'] = $request->is_suspend ? true : false;
        $farmer = $this->farmer->create($data);
        $farmer->countries()->attach($data['country_id'], ['status' => 1]);

        return redirect()->route('farmer.index')->with('success', 'Farmer Created Successfully');
    }


    public function edit(Farmer $farmer)
    {
        return view(self::VIEW_DIR . 'edit', compact('farmer'));
    }

    public function update(FarmerCreateRequest $request, Farmer $farmer)
    {

       
            $data = $request->validated();
            if ($data['others']) {
                $data['user_type'] = $data['others'];
            }
            $data['status'] == 1 ? $data['reason'] = null : '';
            $data['is_suspend'] = $request->is_suspend ? true : false;
            $farmer->update($data);
           
            if ($farmer) {
                try {
                    sendEmail($farmer);
                } catch (\Exception $e) {
                    Log::error($e);
                }
              
            }
           
            // DB::commit();
            return redirect()->route('farmer.index')->with('success', 'Farmer Detail Updated Successfully');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return redirect()->route('farmer.index')->with('error', 'Farmer updation Failed');
        // }
    }


    public function destroy(Farmer $farmer)
    {

        DB::beginTransaction();
        try {
            // $selling_request = SellingRequest::where('farmer_id', $farmer->id)
            //     ->get();

            // if ((count($selling_request))) {
            //     $msg = "This Farmer has been used in" . count($selling_request) . " selling request";
            //     return response()->json(['status' => 'false', 'message' => $msg]);
            // }
            $farmer->delete();

            DB::commit();

            return response()->json(['status' => 'true']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'false']);
        }
    }


    public function viewFarmerCountries($id)
    {
        DB::beginTransaction();
        try {
            $farmer = Farmer::with('countries')->find($id);

            DB::commit();

            return response()->json(['status' => true, 'farmer' => $farmer]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false]);
        }
    }

    public function updateFarmerCountry(Request $request)
    {
        DB::beginTransaction();
        try {
            $farmer = Farmer::with('farmer_device')->find($request->id);
            $farmer->countries()->updateExistingPivot($request->country_id, ['status' => $request->status]);
            if ($farmer && $farmer->farmer_device) {
                switch ($request->status) {
                    case 0:
                        $this->sendPushNotification(
                            [
                                'title' => __('common.notification_message.title_pending'),
                                'description' => __('common.notification_message.description_pending'),
                                'item_id' => $farmer->id,
                                'item_type' => config('common.notification_item_type.country_request_by_farmer'),
                                'country_id' => $farmer->country_id,
                                'type' => 1,
                                'device_type' => $farmer->farmer_device->device_type,
                            ],
                            [
                                'user_id' => $farmer->id,
                                'user_type' => 2,
                            ],
                            [$farmer->farmer_device->fcm_token],
                            'en',
                            $farmer->farmer_device->device_type
                        );
                        break;
                    case 1:

                        $this->sendPushNotification(
                            [
                                'title' => __('common.notification_message.title_approval'),
                                'description' => __('common.notification_message.description_approval'),
                                'item_id' =>  $farmer->id,
                                'item_type' => config('common.notification_item_type.country_request_by_farmer'),
                                'country_id' => $farmer->country_id,
                                'type' => 1,
                                'device_type' => $farmer->farmer_device->device_type,
                            ],
                            [
                                'user_id' => $farmer->id,
                                'user_type' => config('common.notification_user_type.FARMER'),
                            ],
                            [$farmer->farmer_device->fcm_token],
                            $farmer->country->language ?? config('common.default_language'),
                            $farmer->farmer_device->device_type
                        );

                        break;
                    case 2:
                        $this->sendPushNotification(
                            [
                                'title' => __('common.notification_message.title_rejection'),
                                'description' => __('common.notification_message.description_rejection'),
                                'item_id' =>  $farmer->id,
                                'item_type' => config('common.notification_item_type.country_request_by_farmer'),
                                'country_id' => $farmer->country_id,
                                'type' => 1,
                                'device_type' => $farmer->farmer_device->device_type,
                            ],
                            [
                                'user_id' => $farmer->id,
                                'user_type' => config('common.notification_user_type.FARMER'),
                            ],
                            [$farmer->farmer_device->fcm_token],
                            $farmer->country->language ?? config('common.default_language'),
                            $farmer->farmer_device->device_type
                        );

                        break;
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'success' => 'Status has been updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false]);
        }
    }
}
