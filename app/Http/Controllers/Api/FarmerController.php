<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\CountryMaster;
use App\Http\Traits\NotificationTrait;

/**
 * @group  Farmer
 *
 * APIs for managing Farmer
 */


class FarmerController extends Controller
{   
    use NotificationTrait;

    /**
     * Update Profile
     *   
     * @bodyParam  name string,min:2,max:30,alpha required The name field is required. 
     * @bodyParam  company_name string,min:2,max:30,alpha required The company_name field is required. 
     * @bodyParam  phone integer,digits_between:2,20 required The phone field is required. 
     * @bodyParam  address string,min:2,max:30 required The address field is required. 
     * @bodyParam  aditional_details string  The aditional_details field is required. 
     * @bodyParam  user_type string,min:2,max:30 required The user_type field is required. 
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Update Profile",
                                    "timestamp": "2022-01-13 09:55:36"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The name field is required."
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Update Profile",
                                "timestamp": "2022-01-13 09:59:21"
                            },
                            "body": {
                                "status": true,
                                "msg": "Profile updated successfully",
                                "data": []
                            }
                        }
                    }
     */

    public function updateProfile(Request $request)
    {
        $serviceName = 'Update Profile';

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:30',
            'company_name' => 'required|min:2|max:30',
            'dialing_code' => 'required|regex:/^\+(\d{1}\-)?(\d{1,3})$/',
            'phone' => 'required|integer|digits_between:2,20',
            'address' => 'required|min:2|max:30',
            'aditional_details' => 'nullable|string',
            'user_type' => 'required|min:2|max:30',
        ], [
            'name.required' => trans('app_auth_error.name.required'),
            'name.min' => trans('app_auth_error.name.min'),
            'name.max' => trans('app_auth_error.name.max'),
            'company_name.required' => trans('app_auth_error.company_name.required'),
            'company_name.min' => trans('app_auth_error.company_name.min'),
            'company_name.max' => trans('app_auth_error.company_name.max'),
            'dialing_code.regex' => trans('app_auth_error.dialing_code.regex'),
            'phone.required' => trans('app_auth_error.phone.required'),
            'phone.integer' => trans('app_auth_error.phone.integer'),
            'phone.digits_between' => trans('app_auth_error.phone.digits_between'),
            'address.required' => trans('app_auth_error.address.required'),
            'address.min' => trans('app_auth_error.address.min'),
            'address.max' => trans('app_auth_error.address.max'),
            'user_type.required' => trans('app_auth_error.user_type.required'),
            'user_type.min' => trans('app_auth_error.user_type.min'),
            'user_type.max' => trans('app_auth_error.user_type.max'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        auth()->guard('api')->user()->update($validator->validated());

        return apiFormatResponse('Profile updated successfully', [], $serviceName);
    }

    /**
     * Change Password
     *   
     * @bodyParam  current_pin int,digits:6 required The current_pin field is required.
     * @bodyParam  new_pin int,digits:6 required The new_pin field is required.
     * @bodyParam  confirm_pin int,digits:6,same:new_pin required The confirm_pin field is required. 
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Reset Password",
                                    "timestamp": "2022-01-13 10:01:45"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The current pin field is required."
                                }
                            }
                        }
     * @response  401  {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Reset Password",
                                "timestamp": "2022-01-13 10:02:15"
                            },
                            "body": {
                                "status": false,
                                "msg": "The current pin is invaild."
                            }
                        }
                    }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Reset Password",
                                "timestamp": "2022-01-13 10:02:54"
                            },
                            "body": {
                                "status": true,
                                "msg": "Password has reset successfully.",
                                "data": []
                            }
                        }
                    }
     */

    public function changePassword(Request $request)
    {
        $serviceName = 'Reset Password';

        $validator = Validator::make($request->all(), [
            'current_pin' => 'required|digits:6',
            'new_pin' => 'required|digits:6',
            'confirm_pin' => 'required|digits:6|required_with:new_pin|same:new_pin',
        ], [
            'pin.required' => trans('app_auth_error.pin.required'),
            'pin.digits' => trans('app_auth_error.pin.digits'),
            'confirm_pin.required' => trans('app_auth_error.confirm_pin.required'),
            'confirm_pin.same' => trans('app_auth_error.confirm_pin.same'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }
        $farmer = Farmer::find(auth()->guard('api')->id());
        if (!Hash::check($request['current_pin'], $farmer->pin)) {
            return apiFormatResponse(trans('app_farmer.invalid_pin'), null, $serviceName, false, 400);
        }
        $farmer->pin = Hash::make($request['new_pin']);
        $farmer->save();

        return apiFormatResponse(trans('app_farmer.reset_success'), [], $serviceName);
    }

    /**
     * Get User Details
     * 
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Farmer Details",
                                "timestamp": "2022-01-13 09:38:22"
                            },
                            "body": {
                                "status": true,
                                "msg": "Farmer Details",
                                "data": {
                                    "id": 3,
                                    "name": "Ajam",
                                    "username": "webolajam",
                                    "company_name": "Webol",
                                    "registration_number": "good123",
                                    "business_partner_id": null,
                                    "email": "mohd@webol.co.uk",
                                    "dialing_code": "+91",
                                    "phone": "7388337731",
                                    "address": "India",
                                    "country_id": 1,
                                    "aditional_details": null,
                                    "user_type": "Producer",
                                    "block_login_time": null,
                                    "is_news_sms": 0,
                                    "is_marketing_sms": 0,
                                    "is_bids_received_sms": 0,
                                    "is_news_notification": 0,
                                    "is_marketing_notification": 0,
                                    "is_bids_received_notification": 0,
                                    "mobile_verified": 0,
                                    "last_login_at": "2022-01-13 09:37:59",
                                    "reason": null,
                                    "is_suspend": 0,
                                    "status": 1,
                                    "country": {
                                        "id": 1,
                                        "name": "United Kingdom",
                                        "language": "en",
                                        "direction": "ltr",
                                        "duration": "1",
                                        "status": 1
                                    }
                                }
                            }
                        }
                    }
     */


    public function getUserDetails()
    {
        $serviceName =  'Farmer Details';

        $farmer = Farmer::with('country')->find(auth()->guard('api')->id());

        return apiFormatResponse(trans('app_farmer.farmer_detail'), $farmer->toArray(), $serviceName);
    }


     /**
     * Get SMS and Notification setup
     *   
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Getting SMS and Notification Setup  ",
                                "timestamp": "2022-01-13 09:46:07"
                            },
                            "body": {
                                "status": true,
                                "msg": "Listing SMS and Notification Setup ",
                                "data": {
                                    "id": 3,
                                    "name": "Ajam",
                                    "username": "webolajam",
                                    "company_name": "Webol",
                                    "registration_number": "good123",
                                    "business_partner_id": null,
                                    "email": "mohd@webol.co.uk",
                                    "dialing_code": "+91",
                                    "phone": "7388337731",
                                    "address": "India",
                                    "country_id": 2,
                                    "aditional_details": null,
                                    "user_type": "Producer",
                                    "block_login_time": null,
                                    "is_news_sms": 0,
                                    "is_marketing_sms": 0,
                                    "is_bids_received_sms": 0,
                                    "is_news_notification": 0,
                                    "is_marketing_notification": 0,
                                    "is_bids_received_notification": 0,
                                    "mobile_verified": 0,
                                    "last_login_at": "2022-01-13 09:37:59",
                                    "reason": null,
                                    "is_suspend": 0,
                                    "status": 1
                                }
                            }
                        }
                    }
     */

    public function getOption()
    {
        $serviceName = 'Getting SMS and Notification Setup  ';

        $farmer = auth()->guard('api')->user()->toArray();

        return apiFormatResponse(trans('app_farmer.get_option'), $farmer, $serviceName);
    }

    /**
     * Setup SMS and Notification 
     *   
     * @bodyParam  is_news_sms int:1,0 required The news sms field is required.
     * @bodyParam  is_marketing_sms int:1,0 required The marketing sms field is required.
     * @bodyParam  is_bids_received_sms int:1,0 required The bid received sms field is required.
     * @bodyParam  is_news_notification int:1,0 required The news notification field is required.
     * @bodyParam  is_marketing_notification int:1,0 required The marketing notification field is required.
     * @bodyParam  is_bids_received_notification int:1,0 required The bid received notification field is required. 
     * @response  400  {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Setup SMS and Notification ",
                                "timestamp": "2022-01-13 09:48:14"
                            },
                            "body": {
                                "status": false,
                                "msg": "The news sms  field is required."
                            }
                        }
                    }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Setup SMS and Notification ",
                                "timestamp": "2022-01-13 09:52:52"
                            },
                            "body": {
                                "status": true,
                                "msg": "Notifications settings successfully ",
                                "data": []
                            }
                        }
                    }
     */

    public function setOption(Request $request)
    {
        $serviceName = 'Setup SMS and Notification ';

        $validator = Validator::make($request->all(), [
            'is_news_sms' => 'required|in:1,0',
            'is_marketing_sms' => 'required|in:1,0',
            'is_bids_received_sms' => 'required|in:1,0',
            'is_news_notification' => 'required|in:1,0',
            'is_marketing_notification' => 'required|in:1,0',
            'is_bids_received_notification' => 'required|in:1,0',
        ], [
            'is_news_sms.required' => trans('app_farmer_error.is_news_sms.required'),
            'is_news_sms.in' => trans('app_farmer_error.is_news_sms.in'),
            'is_marketing_sms.required' => trans('app_farmer_error.is_marketing_sms.required'),
            'is_marketing_sms.in' => trans('app_farmer_error.is_marketing_sms.in'),
            'is_bids_received_sms.required' => trans('app_farmer_error.is_bids_received_sms.required'),
            'is_bids_received_sms.in' => trans('app_farmer_error.is_bids_received_sms.in'),
            'is_news_notification.required' => trans('app_farmer_error.is_news_notification.required'),
            'is_news_notification.in' => trans('app_farmer_error.is_news_notification.in'),
            'is_marketing_notification.required' => trans('app_farmer_error.is_marketing_notification.required'),
            'is_marketing_notification.in' => trans('app_farmer_error.is_marketing_notification.in'),
            'is_bids_received_notification.required' => trans('app_farmer_error.is_bids_received_notification.required'),
            'is_bids_received_notification.in' => trans('app_farmer_error.is_bids_received_notification.in'),

        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        auth()->guard('api')->user()->update($validator->validated());

        return apiFormatResponse(trans('app_farmer.set_option'), [], $serviceName);
    }

     /**
     * Get User Country List
     * 
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "User country list",
                                "timestamp": "2022-01-13 09:40:47"
                            },
                            "body": {
                                "status": true,
                                "msg": "User country list",
                                "data": {
                                    "user_country": [
                                        {
                                            "id": 1,
                                            "name": "United Kingdom",
                                            "language": "en"
                                        }
                                    ],
                                    "country_list": [
                                        {
                                            "id": 2,
                                            "name": "Hungry",
                                            "language": "hu"
                                        },
                                        {
                                            "id": 3,
                                            "name": "Germany",
                                            "language": "de"
                                        }
                                    ]
                                }
                            }
                        }
                    }
     */

    public function getCountryUserList()
    {
        $serviceName =  'User country list';

        $farmer = Farmer::find(auth()->guard('api')->id())->countries()->wherePivot('status', 1)->select(['id', 'name', 'language','abbreviation','time_zone'])->get()->makeHidden('pivot');
        $country_ids = array_column($farmer->toArray(), 'id');
        $country_list =       CountryMaster::whereNotIn('id', $country_ids)->select(['id', 'name', 'language','abbreviation','time_zone'])->get();

        $data = [
            'user_country' => $farmer,
            'country_list' => $country_list,
        ];

        return apiFormatResponse(trans('app_farmer.user_country_list'), $data, $serviceName);
    }

    /**
     * User Request Country 
     *   
     * @bodyParam  country_id int required The country_id field is required.
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "User request country",
                                    "timestamp": "2022-01-13 09:41:48"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The country id  field is required."
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "User request country",
                                "timestamp": "2022-01-13 09:44:03"
                            },
                            "body": {
                                "status": true,
                                "msg": "Country has been changed but GoodMills team will approve your country then will show country ",
                                "data": []
                            }
                        }
                    }
     */


    public function requestUserCountry(Request $request)
    {
        $serviceName = 'User request country';

        $validator = Validator::make($request->all(), [
            'country_id' => 'required|integer',
        ], [
            'country_id.required' => trans('app_farmer_error.country_id.required'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $farmer = Farmer::find(auth()->guard('api')->id());
        $farmer_country = $farmer->countries()->wherePivot('country_id', $request->country_id)->wherePivot('farmer_id', auth()->guard('api')->id())->select(['id', 'name', 'language'])->first();
        if ($farmer_country) {
            $farmer->countries()->updateExistingPivot($request->country_id, ['status' => 0]);
        } else {
            $farmer->countries()->attach($request['country_id'], ['status' => 0], false);
        }

        ////////////////// Sending Push Notification //////////////////
        $super_admin = getSuperAdminData(); 
        $device_type = getDeviceType(auth()->guard('api')->user()->id) ; 
        $res = $this->sendPushNotification(
            [
                'title' => trans('app_notification.country_request_by_farmer', ['farmer_name' => auth()->guard('api')->user()->name]), 
                'item_id' => auth()->guard('api')->id(),
                'item_type' => config('common.notification_item_type.country_request_by_farmer'),
                'country_id'=> auth()->guard('api')->user()->country_id,
                'type'=> 1 ,
                'device_type'=> $device_type ,
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

        return apiFormatResponse(trans('app_farmer.user_request_country'), [], $serviceName);
    }

    /**
     * Set User Country 
     *   
     * @bodyParam  country_id int required The country_id field is required.
     * @response  400  {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "User request country",
                                "timestamp": "2022-01-13 09:45:23"
                            },
                            "body": {
                                "status": false,
                                "msg": "The country id  field is required."
                            }
                        }
                    }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "User request country",
                                "timestamp": "2022-01-13 09:45:41"
                            },
                            "body": {
                                "status": true,
                                "msg": "Country has switched",
                                "data": []
                            }
                        }
                    }
     */

    public function setUserCountry(Request $request)
    {
        $serviceName = 'User request country';

        $validator = Validator::make($request->all(), [
            'country_id' => 'required|integer',
        ], [
            'country_id.required' => trans('app_farmer_error.country_id.required'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $farmer = Farmer::find(auth()->guard('api')->id());
        $farmer->country_id =  $request->country_id ;
        $farmer->save() ;
        return apiFormatResponse(trans('app_farmer.set_user_country'), [], $serviceName);
    }
}
