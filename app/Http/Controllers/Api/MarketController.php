<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

use App\Models\CommodityMaster;

use Carbon\Carbon;

/**
 * @group  Market
 *
 * APIs for managing Market
 */
class MarketController extends Controller
{   

    /**
     * Commodity List
     *   
     * @bodyParam  page int required The page field is required.
     * @bodyParam  limit int required The limit field is required.
     * @response  400  {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Commodity List",
                                "timestamp": "2022-01-13 10:17:45"
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
                                "serviceName": "Commodity List",
                                "timestamp": "2022-01-13 10:18:06"
                            },
                            "body": {
                                "status": true,
                                "msg": "Commodity List",
                                "data": [
                                    {
                                        "id": 1,
                                        "name": "Wheat"
                                    },
                                    {
                                        "id": 2,
                                        "name": "Rice"
                                    }
                                ],
                                "total": 2,
                                "current_page": 1,
                                "last_page": 1
                            }
                        }
                    }
     */

    public function commodityList(Request $request)
    {
        $serviceName =  'Commodity List';

        $validator = Validator::make($request->all(), [ 
            'page' => 'required|integer',
            'limit' => 'nullable|integer',
        ], [
            'page.required' => trans('app_market_error.page.required'),
            'page.integer' => trans('app_market_error.page.integer'),
            'limit.required' => trans('app_market_error.limit.required'),
            'limit.integer' => trans('app_market_error.limit.integer'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $limit = $request->limit ?? config('common.api_max_result_set');

        $commodity = CommodityMaster::whereStatus(1)
            ->select(['id','name'])
            ->paginate($limit);

        if (count($commodity->items())) {
            return paginationResponse(
                $commodity,
                trans('app_market.commodity_list'),
                $serviceName,
            );
        }

        return apiFormatResponse(trans('app_market.commodity_list'), [], $serviceName, false);
    }

}
