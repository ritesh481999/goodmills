<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

use App\Models\Marketing;

use Carbon\Carbon;

/**
 * @group  Marketing
 *
 * APIs for managing Market
 */

class MarketingController extends Controller
{

    /**
     * Marketing listing
     * 
     * @bodyParam  country_id int required The country id field is required.
     * @bodyParam  page int required The page field is required.
     * @bodyParam  limit int required The limit field is required.
     * @response  400 {
        "APIService": {
            "header": {
                "version": "v1",
                "serviceName": "Marketings List",
                "timestamp": "2022-01-11 13:40:12"
            },
            "body": {
                "status": false,
                "msg": "The country id field is required."
            }
        }
    }
     * @response  {
                "APIService": {
                    "header": {
                        "version": "v1",
                        "serviceName": "Marketings List",
                        "timestamp": "2022-01-11 13:40:28"
                    },
                    "body": {
                        "status": true,
                        "msg": "Marketing List",
                        "data": [
                            {
                                "id": 7,
                                "title": "Marketing notification",
                                "short_description": "short description",
                                "publish_on": "January 10th",
                                "image": "http://3.8.238.20/goodmills2/storage/marketing/image/6VcLrMSUNo.png"
                            },
                            {
                                "id": 2,
                                "title": "Brekke PLC",
                                "short_description": "Quod error et aperiam nesciunt tenetur eos eius ma",
                                "publish_on": "January 10th",
                                "image": "http://3.8.238.20/goodmills2/storage/marketing/image/GScnzGOQ96.png"
                            },
                            {
                                "id": 1,
                                "title": "Hand-Zboncak",
                                "short_description": "Omnis dolorum velit odit rem sunt. Aut explicabo e",
                                "publish_on": "January 10th",
                                "image": "http://3.8.238.20/goodmills2/storage/marketing/image/tqKVqJqhM1.jpg"
                            }
                        ],
                        "total": 3,
                        "current_page": 1,
                        "last_page": 1
                    }
                }
            }
     */

    public function marketingList(Request $request)
    {
        $serviceName =  'Marketings List';

        $validator = Validator::make($request->all(), [
            'country_id' => 'required|integer',
            'page' => 'required|integer',
            'limit' => 'nullable|integer',
        ], [
            'country_id.required' => trans('app_marketing_error.country_id.required'),
            'country_id.integer' => trans('app_marketing_error.country_id.integer'),
            'page.required' => trans('app_marketing_error.page.required'),
            'page.integer' => trans('app_marketing_error.page.integer'),
            'limit.required' => trans('app_marketing_error.limit.required'),
            'limit.integer' => trans('app_marketing_error.limit.integer'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $limit = $request->limit ?? config('common.api_max_result_set');

        $marketings = Marketing::whereCountryId($request->country_id)
            ->whereStatus(1)
            ->select([
                'marketings.id',
                'marketings.title',
                'marketings.short_description',
                'marketings.publish_on',
                'marketings.image',
            ])
            ->whereDate('publish_on', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->whereCountryId($request->country_id)
            ->orderBy('id', 'desc')
            ->paginate($limit);
                   
        if (count($marketings->items())) {
            return paginationResponse(
                $marketings,
                trans('app_marketing.marketing_list'),
                $serviceName,
                true,
                200,
                [], 
            );
        }

        return apiFormatResponse(trans('app_marketing.marketing_list'), [], $serviceName, false);
    }


    /**
     * Marketing details
     * 
     * @bodyParam  country_id int required The country id field is required.
     * @bodyParam  marketing_id int required The marketing id field is required. 
     * @response  400 {
                "APIService": {
                    "header": {
                        "version": "v1",
                        "serviceName": "Marketings Details",
                        "timestamp": "2022-01-11 13:43:04"
                    },
                    "body": {
                        "status": false,
                        "msg": "The country id field is required."
                    }
                }
            }
     * @response  {
                "APIService": {
                    "header": {
                        "version": "v1",
                        "serviceName": "Marketings Details",
                        "timestamp": "2022-01-11 13:43:20"
                    },
                    "body": {
                        "status": true,
                        "msg": "Marketing details found",
                        "data": {
                            "id": 1,
                            "title": "Hand-Zboncak",
                            "description": "Laborum reiciendis excepturi voluptatum saepe illum sapiente. Quod cumque eum omnis et. Neque omnis animi ratione ea ut.",
                            "publish_on": "January 10th",
                            "image": "http://3.8.238.20/goodmills2/storage/marketing/image/tqKVqJqhM1.jpg",
                            "marketing_files": []
                        }
                    }
                }
            }
     */

    public function marketingDetails(Request $request)
    {
        $serviceName =  'Marketings Details';

        $validator = Validator::make($request->all(), [
            'marketing_id' => 'required|integer',
            'country_id' => 'required|integer',
        ], [
            'marketing_id.required' => trans('app_marketing_error.marketing_id.required'),
            'marketing_id.integer' => trans('app_marketing_error.marketing_id.integer'),
            'country_id.required' => trans('app_marketing_error.country_id.required'),
            'country_id.integer' => trans('app_marketing_error.country_id.integer'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $marketings = Marketing::with('marketing_files')->select([
            'marketings.id',
            'marketings.title',
            'marketings.description',
            'marketings.publish_on',
            'marketings.image',
        ])
            ->whereDate('publish_on', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->whereStatus(1)
            ->whereCountryId($request->country_id)
            ->find($request->marketing_id);

        if ($marketings) {
            return apiFormatResponse(
                trans('app_marketing.marketing_details'),
                $marketings->toArray(),
                $serviceName,
                true
            );
        }

        return apiFormatResponse(trans('app_marketing.marketing_details_not_found'), [], $serviceName, false, 404);
    }
}
