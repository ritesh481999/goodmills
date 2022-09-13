<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Models\Bid;
use App\Models\Variety;
use App\Models\BidFarmer;
use App\Models\CommodityMaster;
use App\Models\DeliveryLocation;
use App\Models\SellingRequest;
use App\Models\SpecificationMaster;
use App\Http\Traits\NotificationTrait;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

/**
 * @group  Sell Request
 *
 * APIs for managing Sell Request
 */

class SellController extends Controller
{

    use NotificationTrait;

    /**
     * Sells Master Data 
     * @response  
     * {
                    "APIService": {
                        "header": {
                            "version": "v1",
                            "serviceName": "Sells Master",
                            "timestamp": "2022-01-11 13:52:51"
                        },
                        "body": {
                            "status": true,
                            "msg": "Sells Master Datas",
                            "data": {
                                "month_of_movement": [
                                    {
                                        "date": "2022-01-11",
                                        "month": "Jan 2022"
                                    },
                                    {
                                        "date": "2022-02-11",
                                        "month": "Feb 2022"
                                    },
                                    {
                                        "date": "2022-03-11",
                                        "month": "Mar 2022"
                                    },
                                    {
                                        "date": "2022-04-11",
                                        "month": "Apr 2022"
                                    },
                                    {
                                        "date": "2022-05-11",
                                        "month": "May 2022"
                                    },
                                    {
                                        "date": "2022-06-11",
                                        "month": "Jun 2022"
                                    },
                                    {
                                        "date": "2022-07-11",
                                        "month": "Jul 2022"
                                    },
                                    {
                                        "date": "2022-08-11",
                                        "month": "Aug 2022"
                                    },
                                    {
                                        "date": "2022-09-11",
                                        "month": "Sep 2022"
                                    },
                                    {
                                        "date": "2022-10-11",
                                        "month": "Oct 2022"
                                    },
                                    {
                                        "date": "2022-11-11",
                                        "month": "Nov 2022"
                                    },
                                    {
                                        "date": "2022-12-11",
                                        "month": "Dec 2022"
                                    },
                                    {
                                        "date": "2023-01-11",
                                        "month": "Jan 2023"
                                    },
                                    {
                                        "date": "2023-02-11",
                                        "month": "Feb 2023"
                                    },
                                    {
                                        "date": "2023-03-11",
                                        "month": "Mar 2023"
                                    },
                                    {
                                        "date": "2023-04-11",
                                        "month": "Apr 2023"
                                    },
                                    {
                                        "date": "2023-05-11",
                                        "month": "May 2023"
                                    },
                                    {
                                        "date": "2023-06-11",
                                        "month": "Jun 2023"
                                    },
                                    {
                                        "date": "2023-07-11",
                                        "month": "Jul 2023"
                                    },
                                    {
                                        "date": "2023-08-11",
                                        "month": "Aug 2023"
                                    },
                                    {
                                        "date": "2023-09-11",
                                        "month": "Sep 2023"
                                    },
                                    {
                                        "date": "2023-10-11",
                                        "month": "Oct 2023"
                                    },
                                    {
                                        "date": "2023-11-11",
                                        "month": "Nov 2023"
                                    },
                                    {
                                        "date": "2023-12-11",
                                        "month": "Dec 2023"
                                    },
                                    {
                                        "date": "2024-01-11",
                                        "month": "Jan 2024"
                                    },
                                    {
                                        "date": "2024-02-11",
                                        "month": "Feb 2024"
                                    },
                                    {
                                        "date": "2024-03-11",
                                        "month": "Mar 2024"
                                    },
                                    {
                                        "date": "2024-04-11",
                                        "month": "Apr 2024"
                                    },
                                    {
                                        "date": "2024-05-11",
                                        "month": "May 2024"
                                    },
                                    {
                                        "date": "2024-06-11",
                                        "month": "Jun 2024"
                                    },
                                    {
                                        "date": "2024-07-11",
                                        "month": "Jul 2024"
                                    },
                                    {
                                        "date": "2024-08-11",
                                        "month": "Aug 2024"
                                    },
                                    {
                                        "date": "2024-09-11",
                                        "month": "Sep 2024"
                                    },
                                    {
                                        "date": "2024-10-11",
                                        "month": "Oct 2024"
                                    },
                                    {
                                        "date": "2024-11-11",
                                        "month": "Nov 2024"
                                    },
                                    {
                                        "date": "2024-12-11",
                                        "month": "Dec 2024"
                                    },
                                    {
                                        "date": "2025-01-11",
                                        "month": "Jan 2025"
                                    }
                                ],
                                "tonnage": [
                                    25,
                                    50,
                                    75,
                                    100,
                                    125,
                                    150,
                                    175,
                                    200,
                                    225,
                                    250,
                                    275,
                                    300,
                                    325,
                                    350,
                                    375,
                                    400,
                                    425,
                                    450,
                                    475,
                                    500,
                                    1000,
                                    10000
                                ],
                                "commodity": [
                                    {
                                        "id": 1,
                                        "name": "Wheat",
                                        "status": 1
                                    },
                                    {
                                        "id": 2,
                                        "name": "Rice",
                                        "status": 1
                                    }
                                ],
                                "specification": [
                                    {
                                        "id": 1,
                                        "name": "LONDON WHEAT",
                                        "commodity_id": 1,
                                        "status": 1
                                    },
                                    {
                                        "id": 2,
                                        "name": "BASMATI RICE",
                                        "commodity_id": 2,
                                        "status": 1
                                    }
                                ],
                                "variety": [
                                    {
                                        "id": 1,
                                        "name": "WHEAT FLOUR",
                                        "commodity_id": 1,
                                        "status": 1
                                    },
                                    {
                                        "id": 2,
                                        "name": "SELLA BASMATI RICE",
                                        "commodity_id": 2,
                                        "status": 1
                                    }
                                ],
                                "delivery_location": [
                                    {
                                        "id": 1,
                                        "name": "Berlin",
                                        "status": 1
                                    },
                                    {
                                        "id": 2,
                                        "name": "Humburg",
                                        "status": 1
                                    }
                                ]
                            }
                        }
                    }
                }
     */
    public function sellsMaster()
    {
        $serviceName =  'Sells Master';

        $data = [
            'month_of_movement' => getMonthOfMovement(),
            'tonnage' => config('common.tonnage'),
            'commodity' => CommodityMaster::whereStatus(1)->get(),
            'specification' => SpecificationMaster::whereStatus(1)->get(),
            'variety' => Variety::whereStatus(1)->get(),
            'delivery_location' => DeliveryLocation::whereStatus(1)->get(),
        ];

        return apiFormatResponse(trans('app_sell.sell_master'), $data, $serviceName);
    }

    /**
     * Sells Request 
     * 
     * @bodyParam  date_of_movement date_format required The date_format field is required.(date_format:Y-m-d)
     * @bodyParam  additional_comment optional  Enter additional comment.
     * @bodyParam  tonnage int required The tonnage field is required.
     * @bodyParam  commodity_id int required The commodity_id field is required.
     * @bodyParam  variety_id int required The variety_id field is required.
     * @bodyParam  specification_id int required The specification_id field is required.
     * @bodyParam  delivery_method int required The delivery_method field is required. (1->Ex Exam, 2->Deliver(Select Drop off Location))
     * @bodyParam  delivery_address string required The delivery_address field is required. (1->Enter maniual location, 2->Select Drop off Location)
     * @bodyParam  delivery_location_id int required The delivery_location_id field is required when will delivery_method 2 .
     * @bodyParam  postal_code int required The postal_code field is required when will delivery_method 2 .
     * @response  400  {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": " Selling Request",
                                "timestamp": "2022-01-11 13:59:05"
                            },
                            "body": {
                                "status": false,
                                "msg": "The Date of movement is required.",
                                "data": []
                            }
                        }
                    }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": " Selling Request",
                                "timestamp": "2022-01-11 14:29:32"
                            },
                            "body": {
                                "status": true,
                                "msg": "Your request is submitted successfully",
                                "data": []
                            }
                        }
                    }
     */

    public function sellsRequest(Request $request)
    {
        $serviceName = ' Selling Request';

        $validator = Validator::make($request->all(), [
            'date_of_movement' => 'required|date_format:Y-m-d',
            'tonnage' => 'required|integer',
            'commodity_id' => 'required|integer',
            'variety_id' => 'required|integer',
            'specification_id' => 'required|integer',
            'delivery_method' => 'required|integer|in:1,2',
            //'delivery_address' => 'required_if:delivery_method,==,1',
            'delivery_location_id' => 'required_if:delivery_method,==,2',
            'postal_code' => 'required_if:delivery_method,==,1',
        ], [
            'date_of_movement.required' => trans('app_sell_error.date_of_movement.required'),
            'date_of_movement.date_format' => trans('app_sell_error.date_of_movement.date_format'),
            'tonnage.required' => trans('app_sell_error.tonnage.required'),
            'tonnage.integer' => trans('app_sell_error.tonnage.integer'),
            'commodity_id.required' => trans('app_sell_error.commodity_id.required'),
            'commodity_id.integer' => trans('app_sell_error.commodity_id.integer'),
            'variety_id.required' => trans('app_sell_error.variety_id.required'),
            'variety_id.integer' => trans('app_sell_error.variety_id.integer'),
            'specification_id.required' => trans('app_sell_error.specification_id.required'),
            'specification_id.integer' => trans('app_sell_error.specification_id.integer'),
            'delivery_method.required' => trans('app_sell_error.delivery_method.required'),
            'delivery_method.integer' => trans('app_sell_error.delivery_method.integer'),
            'delivery_address.required_if' => trans('app_sell_error.delivery_address.required_if'),
            'delivery_location_id.required_if' => trans('app_sell_error.delivery_location_id.required_if'),
            'postal_code.required_if' => trans('app_sell_error.postal_code.required_if'),
            //'postal_code.integer' => trans('app_sell_error.postal_code.integer'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), [], $serviceName, false, 400);
        }

        $data = $validator->validated();
        $data['farmer_id'] = auth()->guard('api')->id();
        $data['country_id'] = auth()->guard('api')->user()->country_id;
        $data['status'] = 1;

        if ($data['delivery_method'] == 1) {
            $data['delivery_address'] = $request->delivery_address ?? null;
            unset($data['delivery_location_id']);
            //unset($data['postal_code']);
        } else if ($data['delivery_method'] == 2) {
            unset($data['delivery_address']);
        }
        $result = SellingRequest::create($data);

        ////////////////// Sending Push Notification //////////////////
        $super_admin = getSuperAdminData();
        $device_type = getDeviceType(auth()->guard('api')->user()->id);
        $res = $this->sendPushNotification(
            [
                'title' => trans('app_notification.send_selling_request', ['farmer_name' => auth()->guard('api')->user()->name]),
                'item_id' => $result->id,
                'item_type' => config('common.notification_item_type.selling_request'),
                'country_id' => auth()->guard('api')->user()->country_id,
                'type' => 1,
                'device_type' => $device_type,
            ],
            [
                'user_id' => $super_admin['id'],
                'user_type' => $super_admin['role_id'],
            ],
            [$super_admin['fcm_token']],
            $super_admin['selected_country']['language'] ?? config('common.default_language'),
            $device_type
        );
        ////////////////// Sending Push Notification //////////////////


        return apiFormatResponse(trans('app_sell.selling_request'), [], $serviceName);
    }

    /**
     * Bid List
     *  
     * @bodyParam  page int required The page field is required.
     * @bodyParam  limit int required The limit field is required.
     * @response  400 {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Bid List",
                                "timestamp": "2022-01-11 14:32:10"
                            },
                            "body": {
                                "status": false,
                                "msg": "The page field is required."
                            }
                        }
                    }
     * @response  {
                    "APIService": {
                        "header": {
                            "version": "v1",
                            "serviceName": "Bid List",
                            "timestamp": "2022-01-11 14:34:38"
                        },
                        "body": {
                            "status": true,
                            "msg": "Bid list",
                            "data": [
                                {
                                    "id": 3,
                                    "bid_code": "GMG-34811434",
                                    "month_of_movement_display": "-",
                                    "valid_for": "16 Days 5 Hrs 20 Mins",
                                    "commodity": {
                                        "id": 1,
                                        "name": "Wheat"
                                    }
                                }
                            ],
                            "total": 1,
                            "current_page": 1,
                            "last_page": 1
                        }
                    }
                }
     */

    public function getBids(Request $request)
    {
        $serviceName =  'Bid List';

        $validator = Validator::make($request->all(), [
            'page' => 'required|integer',
            'limit' => 'required|integer',
        ], [
            'page.required' => trans('app_sell_error.page.required'),
            'page.integer' => trans('app_sell_error.page.integer'),
            'limit.required' => trans('app_sell_error.limit.required'),
            'limit.integer' => trans('app_sell_error.limit.integer'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $limit = $request->limit ?? config('common.api_max_result_set');
        $farmer_id = auth()->guard('api')->id();
        $country_id = Auth::guard('api')->user()->country_id;

        $bids = Bid::whereDate('publish_on', '<=', Carbon::now())
            ->whereCountryId($country_id)
            ->whereDate('valid_till', '>', Carbon::now())
            ->with(['commodity:id,name'])
            ->whereHas('bidFarmer', function ($query) use ($farmer_id) {
                $query->where('farmer_id', $farmer_id);
                $query->where('status', 0);
            })
            ->select([
                'id',
                'bid_code',
                'valid_till',
                'commodity_id',
            ])
            ->orderBy('id', 'desc')
            ->paginate($limit);

        if (count($bids)) {
            return paginationResponse(
                $bids,
                trans('app_sell.bid_list'),
                $serviceName,
                true,
                200,
                [],
            );
        }

        return apiFormatResponse(trans('app_sell.not_found'), [], $serviceName, false, 404);
    }

    /**
     * Bid details
     * 
     * @bodyParam  bid_id int required The bid_id field is required. 
     * @response  400 {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Bid Details",
                                    "timestamp": "2022-01-11 14:37:08"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The bid id  field is required."
                                }
                            }
                        }
     * @response  {
                    "APIService": {
                        "header": {
                            "version": "v1",
                            "serviceName": "Bid Details",
                            "timestamp": "2022-01-11 14:37:38"
                        },
                        "body": {
                            "status": true,
                            "msg": "Bid detail found",
                            "data": {
                                "id": 3,
                                "bid_code": "GMG-34811434",
                                "delivery_location_id": 2,
                                "delivery_address": "",
                                "postal_code": "",
                                "date_of_movement": "2022-12-01",
                                "max_tonnage": 200,
                                "price": 1209,
                                "tonnage_list": [
                                    200,
                                    175,
                                    150,
                                    125,
                                    100,
                                    75,
                                    50,
                                    25
                                ],
                                "month_of_movement_display": "December, 2022",
                                "valid_for": "16 Days 5 Hrs 17 Mins",
                                "commodity": {
                                    "id": 1,
                                    "name": "Wheat"
                                },
                                "delivery": {
                                    "id": 2,
                                    "name": "Humburg"
                                },
                                "variety": {
                                    "id": 1,
                                    "name": "WHEAT FLOUR"
                                },
                                "specification": {
                                    "id": 1,
                                    "name": "LONDON WHEAT"
                                },
                                "bid_location": [
                                    {
                                        "id": 1,
                                        "name": "dxx"
                                    }
                                ]
                            }
                        }
                    }
                }
     */

    public function bidDetails(Request $request)
    {
        $serviceName =  'Bid Details';

        $validator = Validator::make($request->all(), [
            'bid_id' => 'required|integer|exists:bids,id',
        ], [
            'bid_id.required' => trans('app_sell_error.bid_id.required'),
            'bid_id.integer' => trans('app_sell_error.bid_id.integer'),
            'bid_id.exists' => trans('app_sell_error.bid_id.exists'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $limit = $request->limit ?? config('common.api_max_result_set');
        $farmer_id = auth()->guard('api')->id();
        $country_id = auth()->guard('api')->user()->country_id;

        $bids = Bid::whereDate('publish_on', '<=', Carbon::now())
            ->whereCountryId($country_id)
            ->with(['commodity:id,name', 'delivery:id,name', 'variety:id,name', 'specification:id,name', 'bidLocation'])
            //->with('bid_location:name')
            ->whereHas('bidFarmer', function ($query) use ($farmer_id) {
                $query->where('farmer_id', $farmer_id);
            })
            ->select([
                'id',
                'bid_code',
                'publish_on',
                'selling_request_id',
                'valid_till',
                'commodity_id',
                'specification_id',
                'variety_id',
                'delivery_location_id',
                'delivery_address',
                'postal_code',
                'date_of_movement',
                'max_tonnage',
                'price',
            ])
            ->find($request->bid_id);


        if ($bids) {

            $bids->price = number_format( $bids->price,2) ;
            $bids->max_tonnage =  $this->maxAvailableTonnage($bids);
            $tonnages = $this->getAvailableTonnageSelection($bids, $bids->max_tonnage);
            $bids->tonnage_list = $tonnages;
            return apiFormatResponse(
                trans('app_sell.bid_detail_found'),
                $bids->toArray(),
                $serviceName,
            );
        }

        return apiFormatResponse(trans('app_sell.bid_detail_not_found'), [], $serviceName, false, 404);
    }

    private function maxAvailableTonnage(Bid $item)
    {
        $tonnagesAccepted = $item->bidFarmer()->where('status', '1')->sum('tonnage');
        return $item->max_tonnage - $tonnagesAccepted;
    }

    private function getAvailableTonnageSelection(Bid $item, int $max)
    {
        $isSellingRequest = !empty($item->farmer_sell_bid_id);
        $tonnages =  array_filter(
            config('common.tonnage'),
            function ($v) use ($max, $isSellingRequest) {
                if ($isSellingRequest)
                    return $v == $max;
                return $v <= $max;
            }
        );

        if (!in_array($max, $tonnages))
            array_push($tonnages, $max);

        rsort($tonnages);
        return $tonnages;
    }

    /**
     * Bid Accept/Reject
     * 
     * @bodyParam  bid_id int required The bid_id field is required. 
     * @bodyParam  status int required The status field is required. 
     * @bodyParam  tonnage int required The tonnage field is required when will status 1. 
     * @bodyParam  counter_offer optional  Enter counter offer.
     * @response  400 {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Bid Accept Reject",
                                "timestamp": "2022-01-11 14:49:01"
                            },
                            "body": {
                                "status": false,
                                "msg": "The bid id  field is required."
                            }
                        }
                    }
     * @response  {
                    "APIService": {
                        "header": {
                            "version": "v1",
                            "serviceName": "Bid Accept Reject",
                            "timestamp": "2022-01-11 14:54:29"
                        },
                        "body": {
                            "status": true,
                            "msg": "Bid rejected successfully",
                            "data": []
                        }
                    }
                }
     */

    public function acceptRejectBid(Request $request)
    {
        $serviceName =  'Bid Accept Reject';

        $validator = Validator::make($request->all(), [
            'bid_id' => 'required|integer|exists:bids,id',
            'status' => 'required|integer',
            'tonnage' => 'required_if:status,==,1|integer',
            'counter_offer' => 'nullable',
        ], [
            'bid_id.required' => trans('app_sell_error.bid_id.required'),
            'bid_id.integer' => trans('app_sell_error.bid_id.integer'),
            'bid_id.exists' => trans('app_sell_error.bid_id.exists'),
            'status.required' => trans('app_sell_error.status.required'),
            'status.integer' => trans('app_sell_error.status.integer'),
            'tonnage.required_if' => trans('app_sell_error.tonnage.required_if'),
            'tonnage.integer' => trans('app_sell_error.tonnage.integer'),

        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $farmer_id = auth()->guard('api')->id();
        $check_bid_farmer = BidFarmer::whereFarmerId($farmer_id)->whereBidId($request->bid_id)->first();

        if ($check_bid_farmer) {

            if ($check_bid_farmer->status != 0) {
                return apiFormatResponse(trans('app_sell.bid_exist'), [], $serviceName);
            }

            try {
                DB::beginTransaction();

                $bid_details = Bid::whereId($request->bid_id)->first();  /// Getting Bid Details
                $max_available_tonnage =  $this->maxAvailableTonnage($bid_details);

                if ($request->status ==  1) { ////////////  Accecpting Bid

                    if ($max_available_tonnage > 0  && $request->tonnage > 0 &&  $request->tonnage <=  $max_available_tonnage) {

                        $check_bid_farmer->tonnage = $request->tonnage;
                        $check_bid_farmer->counter_offer = $request->counter_offer ?? null;
                        $check_bid_farmer->status = $request->status;
                        $check_bid_farmer->save();
                    } else {
                        return apiFormatResponse(trans('app_sell.exceed_tonnage'), null, $serviceName, false, 400);
                    }
                } else {

                    // $check_bid_farmer->tonnage = $request->tonnage;
                    $check_bid_farmer->counter_offer = $request->counter_offer ?? null;
                    //$check_bid_farmer->reason = $request->reason ?? null;
                    $check_bid_farmer->status = $request->status;
                    $check_bid_farmer->save();
                }

                if (!empty($bid_details->selling_request_id)) {
                    SellingRequest::whereId($bid_details->selling_request_id)
                        ->update([
                            'bid_id' => $check_bid_farmer->bid_id,
                            'status' => $check_bid_farmer->status == 1 ? 4 : 5
                        ]);
                }

                if ($check_bid_farmer->status == 1) {
                    $api_msg = trans('app_sell.bid_accepted');
                    $title = trans('app_notification.bid_accecpt_by_farmer', ['farmer_name' => auth()->guard('api')->user()->name]);
                    $item_type = config('common.notification_item_type.bid_accecpt_by_farmer');
                } else if ($check_bid_farmer->status == 2) {
                    $api_msg = trans('app_sell.bid_rejected');
                    $title = trans('app_notification.bid_reject_by_farmer', ['farmer_name' => auth()->guard('api')->user()->name]);
                    $item_type = config('common.notification_item_type.bid_reject_by_farmer');
                }

                ////////////////// Sending Push Notification //////////////////
                $super_admin = getSuperAdminData();
                $device_type = getDeviceType(auth()->guard('api')->user()->id);
                $res = $this->sendPushNotification(
                    [
                        'title' => $title,
                        'item_id' => $request->bid_id,
                        'item_type' => $item_type,
                        'country_id' => auth()->guard('api')->user()->country_id,
                        'type' => 1,
                        'device_type' => $device_type,
                    ],
                    [
                        'user_id' => $super_admin['id'],
                        'user_type' => $super_admin['role_id'],
                    ],
                    [$super_admin['fcm_token']],
                    $super_admin['selected_country']['language'] ?? config('common.default_language'),
                    $device_type
                );
                ////////////////// Sending Push Notification //////////////////

                DB::commit();
                return apiFormatResponse($api_msg, [], $serviceName);
            } catch (\Exception $e) {
                DB::rollback();
                //throw $e;
                return apiFormatResponse($e, null, $serviceName, false, 400);
            }
        }

        return apiFormatResponse(trans('app_sell.not_assign'), null, $serviceName, false, 400);

        // $data = $validator->validated();
        // $data['farmer_id'] = $farmer_id;

        // $bid_farmer = BidFarmer::create($data);

        // if ($bid_farmer->status == 1) {
        //     return apiFormatResponse(trans('app_sell.bid_accepted'), [], $serviceName);
        // } else if ($bid_farmer->status == 2) {
        //     return apiFormatResponse(trans('app_sell.bid_rejected'), [], $serviceName);
        // }
    }



    /**
     * Bid Trading History
     * 
     * @bodyParam  page int required The page field is required.
     * @bodyParam  limit int required The limit field is required.
     * @bodyParam  from_date optional The from date format d-m-Y. 
     * @bodyParam  to_date optional The to date format d-m-Y. 
     * @response  400 {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Bid Trading History",
                                    "timestamp": "2022-01-11 15:00:13"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The page field is required."
                                }
                            }
                        }
     * @response  {
                    "APIService": {
                        "header": {
                            "version": "v1",
                            "serviceName": "Bid Trading History",
                            "timestamp": "2022-01-11 15:01:35"
                        },
                        "body": {
                            "status": true,
                            "msg": "Bid list",
                            "data": [
                                {
                                    "id": 3,
                                    "type": "Bid",
                                    "bid_code": "GMG-34811434",
                                    "status": "Rejected",
                                    "bid_date": "11/01/2022"
                                }
                            ],
                            "total": 1,
                            "current_page": 1,
                            "last_page": 1
                        }
                    }
                }
     */

    public function bidTradingHistory(Request $request)
    {
        $serviceName =  'Bid Trading History';

        $validator = Validator::make($request->all(), [
            'page' => 'required|integer',
            'limit' => 'required|integer',
            'from_date' => 'nullable|date|before_or_equal:now',
            'to_date' => 'nullable|date|before_or_equal:now',
        ], [
            'page.required' => trans('app_sell_error.page.required'),
            'page.integer' => trans('app_sell_error.page.integer'),
            'limit.required' => trans('app_sell_error.limit.required'),
            'limit.integer' => trans('app_sell_error.limit.integer'),
            'from_date.before_or_equal' => trans('app_sell_error.from_date.before_or_equal'),
            'from_date.date' => trans('app_sell_error.from_date.date'),
            'to_date.before_or_equal' => trans('app_sell_error.to_date.before_or_equal'),
            'to_date.date' => trans('app_sell_error.to_date.date'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $limit = $request->limit ?? config('common.api_max_result_set');
        $farmer_id = auth()->guard('api')->id();
        $country_id = auth()->guard('api')->user()->country_id; 

        $filter_date = [
            'from_date' => isset($request->from_date) ? date('Y-m-d', strtotime($request->from_date)) : '',
            'to_date' => isset($request->to_date) ? (date('Y-m-d', strtotime($request->to_date)) == date('Y-m-d') ? date('Y-m-d H:i:s') :  date('Y-m-d', strtotime($request->to_date))) :  date('Y-m-d H:i:s')
        ];
        $bids = Bid::whereCountryId($country_id)-> 
            when($filter_date, function ($query) use ($filter_date) {
                if ($filter_date['from_date'] && $filter_date['to_date']) {
                    $query->whereDateBetween('publish_on', $filter_date['from_date'], $filter_date['to_date']);
                } else {
                    $query->where('publish_on', '<=', $filter_date['to_date']);
                }

                //$query->orWhere('status',2);
            })
            ->with(['sellingRequest:id,farmer_id,status'])
           
            ->whereHas('singleFarmer', function ($query) use ($farmer_id) {
                $query->where('farmer_id', $farmer_id);
            })
            ->with(['singleFarmer' => function ($query) use ($farmer_id) {
                $query->where('farmer_id', $farmer_id); 
            }])

            // ->orWhereHas('singleSellingRequest', function ($query) use ($farmer_id) {
            //     $query->where('farmer_id', $farmer_id);
            // })
            // ->with(['singleSellingRequest' => function ($query) use ($farmer_id) {
            //     $query->where('farmer_id', $farmer_id);
            // }])

            
            ->select([
                'id',
                'bid_code',
                'valid_till',
                'status',
                'publish_on',
                'selling_request_id'
            ])
            ->orderBy('publish_on', 'desc')
            ->paginate($limit);

        if (count($bids)) {

            $history = [];

            foreach ($bids as $key => $value) {
                $type  = '';
                $status = '';

                $history[$key]['id'] = $value->id;

                if ($value->selling_request_id) {

                    if (isset($value->sellingRequest->farmer_id) && $farmer_id == $value->sellingRequest->farmer_id) {
                        $type =  'Sell';

                        if (isset($value->sellingRequest) && isset($value->sellingRequest->status)) {
                            $status = SellingRequest::STATUS[$value->sellingRequest->status];
                        }
                    } else {
                        $type =  'Bid';
                    }
                } else {
                    $type = 'Bid';
                }

                if (isset($value->singleFarmer) && isset($value->singleFarmer->status)) {

                    if ($value->valid_till < Carbon::now() && !in_array($value->singleFarmer->status, [1, 2])) {
                        $status = 'Expired';
                    } else {
                        $status = BidFarmer::STATUS[$value->singleFarmer->status];
                    }
                } else  if ($value->status == 2 ) {
                    $status = 'Rejected';
                }else  if ($value->valid_till < Carbon::now()) {
                    $status = 'Expired';
                }
                $history[$key]['id'] = $value->id;
                $history[$key]['type'] = $type;
                $history[$key]['bid_code'] = $value->bid_code;
                $history[$key]['status'] = $status;
                $history[$key]['bid_date'] = $value->publish_on;
            }

            return paginationResponse(
                $bids,
                trans('app_sell.bid_list'),
                $serviceName,
                true,
                200,
                $history,

            );
        }

        return apiFormatResponse(trans('app_sell.not_found'), [], $serviceName, false, 404);
    }

    /**
     * Bid Trading History Detail
     * 
     * @bodyParam  bid_id int required The bid_id field is required. 
     * @response  400 {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Bid History Detail",
                                "timestamp": "2022-01-11 15:06:52"
                            },
                            "body": {
                                "status": false,
                                "msg": "The bid id  field is required."
                            }
                        }
                    }
     * @response   {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Bid History Detail",
                                "timestamp": "2022-01-11 15:07:15"
                            },
                            "body": {
                                "status": true,
                                "msg": "Bid detail found",
                                "data": {
                                    "id": 3,
                                    "tonnage": 200,
                                    "month_of_movement_display": "December, 2022",
                                    "commodity": {
                                        "id": 1,
                                        "name": "Wheat"
                                    },
                                    "variety": {
                                        "id": 1,
                                        "name": "WHEAT FLOUR"
                                    },
                                    "specification": {
                                        "id": 1,
                                        "name": "LONDON WHEAT"
                                    },
                                    "delivery_method": 2,
                                    "delivery": {
                                        "id": 2,
                                        "name": "Humburg"
                                    },
                                    "postal_code": "",
                                    "status": "Pending"
                                }
                            }
                        }
                   }
     */

    public function bidTradingHistoryDetail(Request $request)
    {
        $serviceName =  'Bid History Detail';

        $bid_id = $request->bid_id ?? '' ;
        $selling_request_id = $request->selling_request_id ?? '' ;
        $limit = $request->limit ?? config('common.api_max_result_set');
        $farmer_id = auth()->guard('api')->id();
        $country_id = auth()->guard('api')->user()->country_id; 


        if(!empty($bid_id) && !is_null($bid_id) ) {
                $validator = Validator::make($request->all(), [
                            'bid_id' => 'required|integer|exists:bids,id',
                ], [
                    'bid_id.required' => trans('app_sell_error.bid_id.required'),
                    'bid_id.integer' => trans('app_sell_error.bid_id.integer'),
                    'bid_id.exists' => trans('app_sell_error.bid_id.exists'),
                ]);

            } else {

                $validator = Validator::make($request->all(), [
                    'selling_request_id' => 'required|integer|exists:selling_requests,id',
                ], [
                    'selling_request_id.required' => trans('app_sell_error.selling_request_id.required'),
                    'selling_request_id.integer' => trans('app_sell_error.selling_request_id.integer'),
                    'selling_request_id.exists' => trans('app_sell_error.selling_request_id.exists'),
                ]);
         }

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        if(!empty($selling_request_id) && !is_null($selling_request_id)) {
            $res = Bid::whereSellingRequestId($selling_request_id)->select(['id'])->first();
            $bid_id =  $res->id ?? 0 ; 
         }

         

        $bids = Bid::whereCountryId($country_id)->
        with([
            'commodity:id,name',
            'delivery:id,name',
            'variety:id,name',
            'specification:id,name',
            'bidLocation',
            //'singleFarmer',
           // 'sellingRequest',
            'singleSellingRequest',
        ])
            ->whereHas('bidFarmer', function ($query) use ($bid_id, $farmer_id) {
                $query->where('bid_id', $bid_id);
                $query->where('farmer_id', $farmer_id);
            })

            ->orWhereHas('singleSellingRequest', function ($query) use ($farmer_id) {
                $query->where('farmer_id', $farmer_id);
            })
             

            ->select([
                'id',
                'bid_code',
                'selling_request_id',
                'valid_till',
                'commodity_id',
                'specification_id',
                'variety_id',
                'delivery_location_id',
                'delivery_method',
                'delivery_address',
                'postal_code',
                'date_of_movement',
                'max_tonnage',
                'price',
                'status'
            ])
            ->find($bid_id);
        // dd($bids);

        if ($bids) {
            $tonnage ='' ;
            $bids->singleFarmer = BidFarmer::whereBidId($request->bid_id)->whereFarmerId($farmer_id)->first();
            if (isset($bids->singleFarmer) && isset($bids->singleFarmer->status)) {

                if ($bids->valid_till < Carbon::now() && !in_array($bids->singleFarmer->status, [1, 2])) {
                    $status = 'Expired';
                    $tonnage = $bids->max_tonnage;
                } else {
                    $status = BidFarmer::STATUS[$bids->singleFarmer->status];
                    $tonnage = $bids->singleFarmer->status == 0 ? $bids->max_tonnage : $bids->singleFarmer->tonnage;
                }
            }  else  if ($bids->status == 2 ) {
                $status = 'Rejected';
                $tonnage = $bids->max_tonnage;
            }  else  if ($bids->valid_till < Carbon::now()) {
                $status = 'Expired';
                $tonnage = $bids->max_tonnage;
            }

             $reason = '' ;
             if(isset($bids->singleSellingRequest->reason) && $bids->status == 2 ) {
                $reason = $bids->singleSellingRequest->reason ;
             }

             if(isset($bids->singleFarmer->status) && in_array($bids->singleFarmer->status,[4]) ) {
                $reason = $bids->singleFarmer->reason ;
             }

            $bid_history_details = [
                'id' => $bids->id,
                'tonnage' => $tonnage,
                'month_of_movement_display' => $bids->month_of_movement_display,
                'commodity' => $bids->commodity,
                'variety' => $bids->variety,
                'specification' => $bids->specification,
                'delivery_method' => $bids->delivery_method,
                'delivery_address' => $bids->delivery_address,
                'delivery' => $bids->delivery,
                'postal_code' => $bids->postal_code,
                'status' => $status,
                'reason' => $reason ,
            ];

            return apiFormatResponse(
                trans('app_sell.bid_detail_found'),
                $bid_history_details,
                $serviceName,
            );
        }

        return apiFormatResponse(trans('app_sell.bid_detail_not_found'), [], $serviceName, false, 404);
    }
}
