<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\FAQ;
use App\Models\StaticContent;

/**
 * @group  Static Content
 *
 * APIs for managing Static Content
 */


class FAQController extends Controller
{

    /**
     * Get Help & FAQ List
     *  
     * @bodyParam  country_id int required The country_id field is required.
     * @bodyParam  search string .
     * @response  400  {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "FAQ List",
                                "timestamp": "2022-01-13 10:12:24"
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
                                "serviceName": "FAQ List",
                                "timestamp": "2022-01-13 10:12:40"
                            },
                            "body": {
                                "status": true,
                                "msg": "FAQ list",
                                "data": {
                                    "help_content": "",
                                    "faqs": [
                                        {
                                            "id": 20,
                                            "country_id": 1,
                                            "question": "Reynolds, Doyle and Swift",
                                            "answer": "Natus quia assumenda esse. Qui omnis nesciunt rem aut provident nisi eaque eaque. Omnis nostrum nobis quo doloremque quia omnis vitae consequatur. Eligendi et voluptas non voluptate.",
                                            "status": 1
                                        },
                                        {
                                            "id": 19,
                                            "country_id": 1,
                                            "question": "Runolfsdottir Group",
                                            "answer": "Explicabo facilis deleniti assumenda iusto minima sed quod repudiandae. Eius aut quaerat deleniti perferendis. Aut omnis ut nemo sequi.",
                                            "status": 1
                                        },
                                        {
                                            "id": 18,
                                            "country_id": 1,
                                            "question": "Okuneva, Shanahan and Dickens",
                                            "answer": "Hic error quo sapiente officia est. Tenetur qui ut dignissimos excepturi nemo et. Reiciendis blanditiis consequatur ab deserunt nulla facilis non. Quo eum omnis aperiam aut quaerat.",
                                            "status": 1
                                        },
                                        {
                                            "id": 17,
                                            "country_id": 1,
                                            "question": "Jakubowski, Walter and Marquardt",
                                            "answer": "Molestias vel aut nihil maxime consequatur numquam. Optio repudiandae voluptatum ducimus perspiciatis unde. Ipsa nostrum consequatur fugiat nam. Neque qui perferendis nemo vel possimus tempora non.",
                                            "status": 1
                                        },
                                        {
                                            "id": 16,
                                            "country_id": 1,
                                            "question": "Koepp-Schiller",
                                            "answer": "Magnam vero nam est veritatis dignissimos perferendis. Possimus accusamus rerum praesentium magnam vitae aspernatur dolorem. Neque ex ea repellendus.",
                                            "status": 1
                                        },
                                        {
                                            "id": 15,
                                            "country_id": 1,
                                            "question": "Gottlieb PLC",
                                            "answer": "Dolorum est sapiente dolor. Consequatur nostrum laborum et. Temporibus aliquid voluptates qui mollitia voluptatem dolor et. Enim distinctio beatae quam minus excepturi voluptatem quidem.",
                                            "status": 1
                                        },
                                        {
                                            "id": 14,
                                            "country_id": 1,
                                            "question": "Dietrich Ltd",
                                            "answer": "Et consequatur quasi necessitatibus cupiditate veniam optio. Consequuntur sint minima magni pariatur nihil.",
                                            "status": 1
                                        },
                                        {
                                            "id": 13,
                                            "country_id": 1,
                                            "question": "Tromp, McDermott and Johnson",
                                            "answer": "Aut labore corporis suscipit omnis ut. Nulla saepe vel ea autem et reprehenderit voluptates omnis. Dolores quae numquam voluptatibus aut aperiam nemo voluptatem. Dolore sapiente dolor non est quia.",
                                            "status": 1
                                        },
                                        {
                                            "id": 12,
                                            "country_id": 1,
                                            "question": "Mraz-Nienow",
                                            "answer": "Ipsa molestias adipisci labore omnis velit dolor. Et totam modi qui vel ut temporibus. Minima id ex expedita perspiciatis et. Corrupti et est natus aut.",
                                            "status": 1
                                        },
                                        {
                                            "id": 11,
                                            "country_id": 1,
                                            "question": "Ziemann, Jacobson and Zieme",
                                            "answer": "Et expedita deserunt nulla quo quae. Autem quia suscipit consequuntur et aut sed nemo.",
                                            "status": 1
                                        },
                                        {
                                            "id": 10,
                                            "country_id": 1,
                                            "question": "Littel PLC",
                                            "answer": "Laborum dolor numquam laborum vel eaque eveniet. Itaque quam repellendus laborum doloremque. Quas dolore blanditiis laboriosam modi similique. Repellat suscipit nemo sed et quisquam qui consectetur.",
                                            "status": 1
                                        },
                                        {
                                            "id": 9,
                                            "country_id": 1,
                                            "question": "Schaden-Ernser",
                                            "answer": "Animi harum et eos sed sed possimus numquam. Est repudiandae officiis nemo amet cupiditate. Facere quam consequatur repudiandae debitis illum. Autem et molestiae dolorem molestiae eius omnis.",
                                            "status": 1
                                        },
                                        {
                                            "id": 8,
                                            "country_id": 1,
                                            "question": "Runolfsson Ltd",
                                            "answer": "Omnis aut neque exercitationem autem dolor ab. Et reprehenderit et ut reprehenderit debitis.",
                                            "status": 1
                                        },
                                        {
                                            "id": 7,
                                            "country_id": 1,
                                            "question": "DuBuque, Schoen and Pouros",
                                            "answer": "Dolor et quidem velit dicta ut. Quibusdam recusandae est aut eum assumenda. Explicabo autem cupiditate quo minus quia.",
                                            "status": 1
                                        },
                                        {
                                            "id": 6,
                                            "country_id": 1,
                                            "question": "Koelpin, Kuhlman and Mertz",
                                            "answer": "Provident omnis possimus voluptas. Molestiae consectetur voluptatem distinctio qui. Vero molestias soluta dolores doloremque non.",
                                            "status": 1
                                        },
                                        {
                                            "id": 5,
                                            "country_id": 1,
                                            "question": "Kunze, Gibson and Runolfsson",
                                            "answer": "Qui sed voluptatibus reprehenderit eos neque. Et debitis omnis quia ut vel qui dolore. Dolor eum sit tempore deleniti.",
                                            "status": 1
                                        },
                                        {
                                            "id": 4,
                                            "country_id": 1,
                                            "question": "Batz-Armstrong",
                                            "answer": "Tempora quasi vero culpa sit illum. Culpa pariatur eius eum dicta nihil. Quia eos eius aut dolorem. Totam consectetur eveniet perferendis et omnis consequatur.",
                                            "status": 1
                                        },
                                        {
                                            "id": 3,
                                            "country_id": 1,
                                            "question": "Kuphal-Becker",
                                            "answer": "Aut rerum quos dolor corrupti quaerat ut ea. Aut qui molestiae minima fugiat ut magnam aut. Nobis harum quo et. Earum iusto earum ut nulla numquam.",
                                            "status": 1
                                        },
                                        {
                                            "id": 2,
                                            "country_id": 1,
                                            "question": "Hermann, Smith and Heidenreich",
                                            "answer": "Corrupti non amet nihil est. Voluptatum totam alias in unde dolor aliquam sint. Et assumenda aut ut accusamus est eos.",
                                            "status": 1
                                        },
                                        {
                                            "id": 1,
                                            "country_id": 1,
                                            "question": "Aufderhar-Smith",
                                            "answer": "Velit et dolor enim quo aliquam pariatur. Nesciunt asperiores et nisi ducimus explicabo et. Consequatur dolores vero ut unde expedita saepe fugit.",
                                            "status": 1
                                        }
                                    ]
                                }
                            }
                        }
                    }
     */

    public function getFAQList(Request $request)
    {
        $serviceName =  'FAQ List';
        $data = [
            'help_content' => '',
            'faqs' => []
        ];

        $validator = Validator::make($request->all(), [
            'country_id' => 'required|integer',
            'search' => 'nullable',
        ], [
            'country_id.required' => trans('app_static_error.country_id.required'),
            'country_id.integer' => trans('app_static_error.country_id.integer'), 

        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), [], $serviceName, false, 400);
        }

        $static_content = StaticContent::whereStatus(1)
            ->whereCountryId($request->country_id)
            ->whereContentType(3)
            ->first();

        if ($static_content) {
            $data['help_content'] = $static_content->contents;
        }

        $faqs = FAQ::whereStatus(1)
            ->whereCountryId($request->country_id)
            ->where(function ($query) use ($request) {
                $search = $request->search ?? '';
                if ($search) {
                    $query->where('question', 'LIKE', '%' . $search . '%');
                    $query->orWhere('answer', 'LIKE', '%' . $search . '%');
                }
            })
            ->orderBy('id', 'desc')
            ->get();

        if (count($faqs)) {
            $data['faqs'] = $faqs;
            return apiFormatResponse(trans('app_static.faq_record_found'), $data, $serviceName);
        } else {
            return apiFormatResponse(trans('app_static.no_faq_record_found'), $data, $serviceName, 404);
        }
    }
}
