<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\StaticContent;

/**
 * @group  Static Content
 *
 * APIs for managing Static Content
 */

class StaticContentController extends Controller
{   

    /**
     * Get Static Contents
     *  
     * @bodyParam  country_id int required The country_id field is required.
     * @bodyParam  content_type int required The content_type field is required (1 -> Terms And Condition , 2-> Privacy Policy ).
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Static Content",
                                    "timestamp": "2022-01-13 10:09:58"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The country id field is required.",
                                    "data": []
                                }
                            }
                        }
     * @response    {
                    "APIService": {
                        "header": {
                            "version": "v1",
                            "serviceName": "Static Content",
                            "timestamp": "2022-01-13 10:10:13"
                        },
                        "body": {
                            "status": true,
                            "msg": "Static content",
                            "data": {
                                "id": 1,
                                "country_id": 1,
                                "content_type": 1,
                                "contents": "Doloribus architecto iusto quia quo ut. Enim quia nobis officiis nesciunt laudantium dolores. Sint ipsa non eos dignissimos. Aut magnam aliquam qui porro ipsam.",
                                "status": 1
                            }
                        }
                    }
                }
     */

    public function getStaticContents(Request $request)
    {
        $serviceName =  'Static Content';

        $validator = Validator::make($request->all(), [
            'country_id' => 'required|integer',
            'content_type' => 'required|integer',
        ], [
            'country_id.required' => trans('app_static_error.country_id.required'),
            'country_id.integer' => trans('app_static_error.country_id.integer'),
            'content_type.required' => trans('app_static_error.content_type.required'),
            'content_type.integer' => trans('app_static_error.content_type.integer'), 

        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), [], $serviceName, false, 400);
        }

        $static_content = StaticContent::whereStatus(1)
            ->whereCountryId($request->country_id)
            ->whereContentType($request->content_type)
            ->orderBy('id', 'desc')
            ->first();

        if ($static_content) {
            return apiFormatResponse(trans('app_static.record_found'), $static_content->toArray(), $serviceName);
        }

        return apiFormatResponse(trans('app_static.no_record_found'), [], $serviceName, false, 404);
    }
}
