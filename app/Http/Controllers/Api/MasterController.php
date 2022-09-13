<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Traits\SMSTrait;

use App\Models\CountryMaster;
use App\Models\DeliveryLocation;

/**
 * @group  Master
 *
 * APIs for managing Master
 */

class MasterController extends Controller
{   
    use SMSTrait;

     /**
     * Master Date
     *   
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Master Services",
                                "timestamp": "2022-01-13 10:19:03"
                            },
                            "body": {
                                "status": true,
                                "msg": "Master Data",
                                "data": {
                                    "delivery_location": [
                                        {
                                            "id": 2,
                                            "name": "Humburg",
                                            "status": 1
                                        },
                                        {
                                            "id": 1,
                                            "name": "Berlin",
                                            "status": 1
                                        }
                                    ],
                                    "country": [
                                        {
                                            "id": 3,
                                            "name": "Germany",
                                            "language": "de",
                                            "direction": "ltr",
                                            "duration": "7",
                                            "status": 1
                                        },
                                        {
                                            "id": 2,
                                            "name": "Hungry",
                                            "language": "hu",
                                            "direction": "ltr",
                                            "duration": "3",
                                            "status": 1
                                        },
                                        {
                                            "id": 1,
                                            "name": "United Kingdom",
                                            "language": "en",
                                            "direction": "ltr",
                                            "duration": "1",
                                            "status": 1
                                        }
                                    ]
                                }
                            }
                        }
                    }
     */

    public function getMasterData(Request $request)
    {   
       // $this->sendSMS('Hello Hema it is twillo sms', '+917388337731');
        // $this->sendSMS('Mere Pyare bhaiyo and uski bheno,corona bdh raha h savdhan rahe satark rahe', '+918087888757');

        $serviceName =  'Master Services';

        $deliveryLocation = DeliveryLocation::where('status', true)
            ->orderby('id', 'desc')
            ->whereStatus(1)
            ->get()
            ->toArray();

        $countries = CountryMaster::whereStatus(1)
            ->orderby('name', 'asc')
            ->get()
            ->toArray();

        $data = [
            'delivery_location' => $deliveryLocation,
            'country' => $countries
        ];

        return apiFormatResponse('Master Data', $data, $serviceName);
    }
}
