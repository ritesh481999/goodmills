<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Models\Notification; 
use App\Models\NotificationUser; 
use App\Models\FarmerDevice; 

use Carbon\Carbon;

/**
 * @group  Notification
 *
 * APIs for managing Notification
 */

class NotificationController extends Controller
{
     /**
     * Notification List
     *   
     * @bodyParam  page int required The page field is required.
     * @bodyParam  limit int required The limit field is required.
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Notification List",
                                    "timestamp": "2022-01-13 10:20:56"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The page field is required."
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Notification List",
                                "timestamp": "2022-01-13 10:21:13"
                            },
                            "body": {
                                "status": true,
                                "msg": "Notification list",
                                "data": [
                                    {
                                        "id": 11,
                                        "notification_seen_id": 11,
                                        "title": "kj",
                                        "description": "jk",
                                        "item_id": 7,
                                        "item_type": 1,
                                        "is_seen": 0,
                                        "human_time": "1 minute ago"
                                    },
                                    {
                                        "id": 11,
                                        "notification_seen_id": 12,
                                        "title": "kj",
                                        "description": "jk",
                                        "item_id": 7,
                                        "item_type": 1,
                                        "is_seen": 0,
                                        "human_time": "1 minute ago"
                                    },
                                    {
                                        "id": 11,
                                        "notification_seen_id": 13,
                                        "title": "kj",
                                        "description": "jk",
                                        "item_id": 7,
                                        "item_type": 1,
                                        "is_seen": 0,
                                        "human_time": "1 minute ago"
                                    }
                                ],
                                "total": 3,
                                "current_page": 1,
                                "last_page": 1,
                                "notification_count": 3
                            }
                        }
                    }
     */

    public function getNotification(Request $request)
    {
        $serviceName =  'Notification List';

        $validator = Validator::make($request->all(), [
            'page' => 'required|integer',
            'limit' => 'required|integer',
        ], [
            'page.required' => trans('app_notification_error.page.required'),
            'page.integer' => trans('app_notification_error.page.integer'),
            'limit.required' => trans('app_notification_error.limit.required'),
            'limit.integer' => trans('app_notification_error.limit.integer'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $limit = $request->limit ?? config('common.api_max_result_set'); 
        $whereCondition = [
            'notifications.status'=> 1,
            'notification_users.user_id'=> Auth::guard('api')->user()->id,
            'notification_users.user_type'=> 2,
        ] ;
        $notification = Notification::with('country')->join('notification_users',function($join){
            $join->on('notification_users.notification_id','=','notifications.id') ;
        })
        ->where($whereCondition)
        ->select([
            'notifications.id',  
            'notification_users.id as notification_seen_id',  
            'notifications.title',
            'notifications.description',
            'notifications.item_id',
            'notifications.item_type',
            'notifications.country_id',
            'notification_users.is_seen',  
            'notifications.created_at',  
        ])
        ->orderBy('id','desc')
        ->paginate($limit);

        if (count($notification)) {
            $whereCondition['notification_users.is_seen'] = 0 ;
            $notification_count = Notification::with('country')->join('notification_users',function($join){
                $join->on('notification_users.notification_id','=','notifications.id') ;
            })
            ->where($whereCondition)
            ->count() ; 

             foreach($notification as $key => $value) {
                 $value->is_deleted = isNotificationDelete($value->item_id,$value->item_type); 
                $notification[$key] = $value ;
             }

            $data['notification'] = $notification;
            return paginationResponse(
                $notification,
                trans('app_notification.notification_list'),
                $serviceName,
                true,
                200,
                [],
                ['notification_count'=>$notification_count]
            );
        }

        return apiFormatResponse(trans('app_notification.not_found'), [], $serviceName, false, 404);
    }

    /**
     * Send Notification (Self)
     *   
     * @bodyParam  title string required The title field is required. 
     * @bodyParam  description string required The description field is required. 
     * @bodyParam  item_id int required The item_id field is required.  
     * @bodyParam  item_type int required The item_type field is required(1-news/2-marketing/3-bids/4-selling_request). 
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Send Notification ",
                                    "timestamp": "2022-01-13 10:25:54"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The title field is required."
                                }
                            }
                        }
     * @response    {
                    "APIService": {
                        "header": {
                        "version": "v1",
                        "serviceName": "Send Notification ",
                        "timestamp": "2022-01-13 10:28:02"
                        },
                        "body": {
                        "status": true,
                        "msg": "Notification sent",
                        "data": {
                            "multicast_id": 628276734650860227,
                            "success": 1,
                            "failure": 0,
                            "canonical_ids": 0,
                            "results": [
                            {
                                "message_id": "75ed7b40-3cdf-46a2-8a09-fad3c98a820a"
                            }
                            ]
                        }
                        }
                    }
                    }
     */

    public function sendNotification(Request $request)
    {
        $serviceName =  'Send Notification ';

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'item_id' => 'required|integer', 
            'item_type' => 'required|integer', 
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }
        
        $farmer_device = FarmerDevice::where('farmer_id', Auth::guard('api')->user()->id)->first();
        $device_type = getDeviceType(auth()->guard('api')->user()->id) ; 
        $res = $this->sendPushNotification(
            [
                'title'=> $request['title'],
                'description'=> $request['description'],
                'item_id' => $request['item_id'],
                'item_type' => $request['item_type'],
                'country_id'=> auth()->guard('api')->user()->country_id,
                'type'=> 1 ,
                'device_type'=> $device_type ,
            ],
            [
                'user_id'=> Auth::guard('api')->user()->id,
                'user_type'=> 2,
            ],
            [$farmer_device->fcm_token],
            $request->header('language') ?? 'en',
            $device_type
        );


        return apiFormatResponse('Notification sent', json_decode($res,true), $serviceName);
    }

    /**
     * Seen Notification
     *   
     * @bodyParam  notification_seen_id int required The notification_seen_id field is required. 
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Seen Notification ",
                                    "timestamp": "2022-01-13 10:22:29"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The notification seen id field is required."
                                }
                            }
                        }
     * @response    {
                    "APIService": {
                        "header": {
                            "version": "v1",
                            "serviceName": "Seen Notification ",
                            "timestamp": "2022-01-13 10:23:53"
                        },
                        "body": {
                            "status": true,
                            "msg": "",
                            "data": []
                        }
                    }
                }
     */

    public function seenNotification(Request $request)
    {
        $serviceName =  'Seen Notification ';
        $farmer_id = Auth::guard('api')->user()->id ;

        $validator = Validator::make($request->all(), [
            'notification_seen_id' => 'required|integer|exists:notification_users,id', 
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }
        
        NotificationUser::where('id', $request->notification_seen_id)->update(['is_seen'=>1]);
        $whereCondition = [
            'notifications.status'=> 1,
            'notification_users.user_id'=> Auth::guard('api')->user()->id,
            'notification_users.user_type'=> 2,
            'notification_users.user_type'=> 2,
            'notification_users.is_seen'=> 0,
        ] ;

        $unseen_notification_count = Notification::join('notification_users',function($join){
            $join->on('notification_users.notification_id','=','notifications.id') ;
        })
        ->where($whereCondition)
        ->count() ;

        return apiFormatResponse('', ['unseen_notification_count'=>$unseen_notification_count], $serviceName);
    }


    /**
     * Notification Count   
     * @response    {
                    "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Notification  Count ",
                                "timestamp": "2022-01-13 10:23:53"
                            },
                            "body": {
                                "status": true,
                                "msg": "",
                                "data": [
                                    'unseen_notification_count' : 10
                                    ]
                                }
                        }
                }
     */

    public function notificationCount(Request $request)
    {
        $serviceName =  'Notification  Count';
        $farmer_id = Auth::guard('api')->user()->id ;

        $whereCondition = [
            'notifications.status'=> 1,
            'notification_users.user_id'=> Auth::guard('api')->user()->id,
            'notification_users.user_type'=> 2,
            'notification_users.user_type'=> 2,
            'notification_users.is_seen'=> 0,
        ] ;

        $unseen_notification_count = Notification::join('notification_users',function($join){
            $join->on('notification_users.notification_id','=','notifications.id') ;
        })
        ->where($whereCondition)
        ->count() ;

        return apiFormatResponse('', ['unseen_notification_count'=>$unseen_notification_count], $serviceName);
    }

}
