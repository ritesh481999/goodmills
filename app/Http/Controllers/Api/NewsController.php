<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

use App\Models\News;

use Carbon\Carbon;

/**
 * @group  News
 *
 * APIs for managing News
 */

class NewsController extends Controller
{

    /**
     * News listing
     * 
     * @bodyParam  country_id int required The country id field is required.
     * @bodyParam  page int required The page field is required.
     * @bodyParam  limit int required The limit field is required.
     * @response  400 {
            "APIService": {
                "header": {
                    "version": "v1",
                    "serviceName": "News List",
                    "timestamp": "2022-01-11 13:15:14"
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
                    "serviceName": "News List",
                    "timestamp": "2022-01-11 13:08:13"
                },
                "body": {
                    "status": true,
                    "msg": "News List",
                    "data": [
                        {
                            "id": 18,
                            "title": "test",
                            "short_description": "fds",
                            "image": "news/image/xGYvUgi2bp.png",
                            "date_time": "2022-01-11 12:39:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/xGYvUgi2bp.png",
                            "app_date_time": "January 11th"
                        },
                        {
                            "id": 17,
                            "title": "Test new notification",
                            "short_description": "sa",
                            "image": "news/image/VVQjOIoqbT.png",
                            "date_time": "2022-01-11 12:37:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/VVQjOIoqbT.png",
                            "app_date_time": "January 11th"
                        },
                        {
                            "id": 16,
                            "title": "ad",
                            "short_description": "dsa",
                            "image": "news/image/12JgBLDuEI.png",
                            "date_time": "2022-01-11 12:24:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/12JgBLDuEI.png",
                            "app_date_time": "January 11th"
                        },
                        {
                            "id": 15,
                            "title": "sd",
                            "short_description": "sa",
                            "image": "news/image/LNGVmY9auU.png",
                            "date_time": "2022-01-11 12:21:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/LNGVmY9auU.png",
                            "app_date_time": "January 11th"
                        },
                        {
                            "id": 14,
                            "title": "sa",
                            "short_description": "sads",
                            "image": "news/image/9NCySc9Uzq.png",
                            "date_time": "2022-01-11 12:16:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/9NCySc9Uzq.png",
                            "app_date_time": "January 11th"
                        },
                        {
                            "id": 13,
                            "title": "gjkl",
                            "short_description": "njlk",
                            "image": "news/image/DlGhCr8dRV.png",
                            "date_time": "2022-01-11 10:56:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/DlGhCr8dRV.png",
                            "app_date_time": "January 11th"
                        },
                        {
                            "id": 12,
                            "title": "Dummy news",
                            "short_description": "Dummy news",
                            "image": "news/image/PdLauftPCG.png",
                            "date_time": "2022-01-11 10:45:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/PdLauftPCG.png",
                            "app_date_time": "January 11th"
                        },
                        {
                            "id": 11,
                            "title": "zxcvbnm",
                            "short_description": "qweretyui",
                            "image": "news/image/QV4xxvUXsd.png",
                            "date_time": "2022-01-11 10:34:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/QV4xxvUXsd.png",
                            "app_date_time": "January 11th"
                        },
                        {
                            "id": 10,
                            "title": "test news",
                            "short_description": "short description marketing",
                            "image": "news/image/zRSxBw87zG.png",
                            "date_time": "2022-01-11 10:31:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/zRSxBw87zG.png",
                            "app_date_time": "January 11th"
                        },
                        {
                            "id": 9,
                            "title": "qwwert",
                            "short_description": "ttttt",
                            "image": "news/image/9SQbR2hWBr.png",
                            "date_time": "2022-01-11 10:35:00",
                            "image_link": "http://3.8.238.20/goodmills2/storage/news/image/9SQbR2hWBr.png",
                            "app_date_time": "January 11th"
                        }
                    ],
                    "total": 10,
                    "current_page": 1,
                    "last_page": 2
                }
            }
        }
     */


    public function getNewsList(Request $request)
    {
        $serviceName =  'News List';

        $validator = Validator::make($request->all(), [
            'country_id' => 'required|integer',
            'page' => 'required|integer',
            'limit' => 'nullable|integer',
        ], [
            'country_id.required' => trans('app_news_error.country_id.required'),
            'country_id.integer' => trans('app_news_error.country_id.integer'),
            'page.required' => trans('app_news_error.page.required'),
            'page.integer' => trans('app_news_error.page.integer'),
            'limit.required' => trans('app_news_error.limit.required'),
            'limit.integer' => trans('app_news_error.limit.integer'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $limit = $request->limit ?? config('common.api_max_result_set');

        $news = News::select([
            'news.id',
            'news.title',
            'news.short_description',
            'news.image',
            'news.date_time',
        ])
            ->whereDate('date_time', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->whereCountryId($request->country_id);

        if (!isset(Auth::guard('api')->user()->id)) {
            $news = $news->whereType(1);
        }

        $news = $news->whereStatus(1)
            ->orderBy('id', 'desc')
            ->paginate($limit);

        if (count($news)) {
            
            return paginationResponse(
                $news,
                trans('app_news.news_list'),
                $serviceName,
                true,
                200,
                [], 
            );
        }

        return apiFormatResponse(trans('app_news.no_record_found'), [], $serviceName, false, 404);
    }

    /**
     * News details
     * 
     * @bodyParam  country_id int required The country id field is required.
     * @bodyParam  news_id int required The news_id field is required. 
     * @response  400 {
            "APIService": {
                "header": {
                    "version": "v1",
                    "serviceName": "News Detail",
                    "timestamp": "2022-01-11 13:34:19"
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
                    "serviceName": "News Detail",
                    "timestamp": "2022-01-11 13:35:02"
                },
                "body": {
                    "status": true,
                    "msg": "News Details",
                    "data": {
                        "id": 1,
                        "title": "Feil, Reichel and Heller",
                        "description": "Sed expedita nesciunt voluptatem et iusto eaque. Ut aperiam nostrum ipsa. Natus ad qui nesciunt.",
                        "short_description": "Consequatur explicabo et sed explicabo voluptatem.",
                        "image": "news/image/pyNs2Q0Qeq.jpg",
                        "date_time": "2022-01-10 13:28:17",
                        "image_link": "http://3.8.238.20/goodmills2/storage/news/image/pyNs2Q0Qeq.jpg",
                        "app_date_time": "January 10th"
                    }
                }
            }
        }
     */

    public function newsDetails(Request $request)
    {
        $serviceName =  'News Detail';

        $validator = Validator::make($request->all(), [
            'news_id' => 'required|integer',
            'country_id' => 'required|integer',
        ], [
            'news_id.required' => trans('app_news_error.news_id.required'),
            'news_id.integer' => trans('app_news_error.news_id.integer'),
            'country_id.required' => trans('app_news_error.country_id.required'),
            'country_id.integer' => trans('app_news_error.country_id.integer'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $news_detail = News::select([
            'news.id',
            'news.title',
            'news.description',
            'news.short_description',
            'news.image',
            'news.date_time',
        ])
            ->whereDate('date_time', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->whereCountryId($request->country_id)
            ->whereStatus(1);

        if (!isset(Auth::guard('api')->user()->id)) {
            $news_detail = $news_detail->whereType(1);
        }

        $news_detail = $news_detail->find($request->news_id);

        if ($news_detail) {
            return apiFormatResponse(trans('app_news.record_found'), $news_detail->toArray(), $serviceName);
        }

        return apiFormatResponse(trans('app_news.no_record_found'), [], $serviceName, false, 404);
    }
}
