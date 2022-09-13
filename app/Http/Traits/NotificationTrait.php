<?php

namespace App\Http\Traits;

use App\Models\Farmer;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait NotificationTrait
{

    private function createNotification($notification_data,$notification_key,$notification_value,$country, array $farmer_ids = [])
    {
       
        $notification =  Notification::create($notification_data);
        if ($notification) {
            $farmer = new Farmer();
            $farmers = $farmer->getFarmerWithFcmToken($notification_key,$notification_value,$country->selected_country_id,$farmer_ids);
            if ($farmers) {
                $notification_data['id'] = $notification->id ; 

                foreach ($farmers as $farmer) {

                    ////////////////// Sending Push Notification //////////////////
                    
                    $res = $this->sendPushNotification(
                        $notification_data,
                        [
                            'user_id' => $farmer->id,
                            'user_type' => $farmer->user_type,
                        ],
                        [$farmer->fcm_token],
                        $country->selected_country->language,
                        $farmer->device_type
                    );
                    ////////////////// Sending Push Notification //////////////////
                }
            }
        }
    }


    private function sendNotification(object $notification,  $user, array $fcm_token, $notification_count, string $language_code = 'en', $device_type = 2)
    {
        $notification_title = "";
        App::setLocale($language_code);

        switch ($notification->item_type) {
            case 1:
                $notification_title = trans('app_notification.news_title', ['title' => $notification->title]);
                break;
            case 2:
                $notification_title = trans('app_notification.marketing_title', ['title' => $notification->title]);
                break;
            case 3:
                $notification_title = trans('app_notification.bids_title', ['title' => $notification->title]);
                break;
            case 4:
                $notification_title = trans('app_notification.selling_request_title', ['title' => $notification->title]);
                break;
            default:
                $notification_title = $notification->title;
                break;
        }

        $data = [
            "registration_ids" => $fcm_token,
        ];

        if ($device_type ==  2) {  /// IOS 
            $data['notification'] =  [
                'message'     => $notification->description,
                'title'        => $notification_title,
                'subtitle'    => '',
                'vibrate'    => 1,
                'sound'        => 1,
                'badge' => $notification_count + 1,
                'largeIcon'    => 'large_icon',
                'smallIcon'    => 'small_icon',
                'item_id' => $notification->item_id,
                'item_type' => $notification->item_type,
                'icon'    => env('APP_URL') . "/public/assets/media/logos/favicon.png"
            ];
        } else if ($device_type ==  1) {  /// Android
            $data['data'] =  [
                'message'     => $notification->description,
                'title'        => $notification_title,
                'subtitle'    => '',
                'vibrate'    => 1,
                'sound'        => 1,
                'badge'   => $notification_count +  1,
                'largeIcon'    => 'large_icon',
                'smallIcon'    => 'small_icon',
                'item_id' => $notification->item_id,
                'item_type' => $notification->item_type
            ];
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeader());
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $firebase_response = curl_exec($ch);
        $user_data = [
            'user_id' => $user->id,
            'notification_id' => $notification->id,
            'firebase_response' => $firebase_response,
            'user_type' => $user->user_type,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ];
        NotificationUser::insert($user_data);
        if ($firebase_response === FALSE) {
            $errorMsg = 'Push notification failed: ' . curl_error($ch);
            Log::channel(config('logging.default'))
                ->error($errorMsg);
        }
        curl_close($ch);
        return $firebase_response;
    }



    private  function getUserNotficationCount($user_id, $user_type = 2)
    {

        $notification_count = NotificationUser::where('user_id', $user_id)->where('is_seen', 0)->where('user_type', $user_type)
            ->count();

        return $notification_count;
    }

    private  function getTitle($title, $item_type, $language_code)
    {
        $notification_title = "";
        App::setLocale($language_code);
        switch ($item_type) {
            case 1:
                return $notification_title = trans('app_notification.news_title', ['title' => $title]);

            case 2:
                return $notification_title = trans('app_notification.marketing_title', ['title' => $title]);

            case 3:
                return $notification_title = trans('app_notification.bids_title', ['title' => $title]);

            case 4:
                return $notification_title = trans('app_notification.selling_request_title', ['title' => $title]);

            default:
                return $notification_title = $title;
        }
    }

    private  function getPayloadData($device_type, $title, $notification_count, $notification)
    {
        $data = [];
        switch ($device_type) {
            case 1:
                ///////// Android //////////////
                return   [
                    'data' => [
                        'message'     => $notification['description'] ?? '',
                        'title'        => $title,
                        'subtitle'    => '',
                        'vibrate'    => 1,
                        'sound'        => 1,
                        'badge'   => $notification_count,
                        'largeIcon'    => 'large_icon',
                        'smallIcon'    => 'small_icon',
                        'item_id' => $notification['item_id'],
                        'item_type' => $notification['item_type']
                    ]
                ];

            case 2:
                ///////// IOS //////////////
                return   [
                    'notification' => [
                        'message'     => $notification['description'] ?? '',
                        'title'        => $title,
                        'subtitle'    => '',
                        'vibrate'    => 1,
                        'sound'        => 1,
                        'badge' => $notification_count,
                        'largeIcon'    => 'large_icon',
                        'smallIcon'    => 'small_icon',
                        'item_id' => $notification['item_id'],
                        'item_type' => $notification['item_type'],
                        'icon'    => env('APP_URL') . "/public/assets/media/logos/favicon.png"
                    ]
                ];
        }
    }

    private  function getHeader()
    {

        return [
            'Content-Type: application/json',
            'Authorization: key=' . config('common.fcm_server_key')
        ];

    }



    private function sendPushNotification(array $notification_data, array  $user_data, array $fcm_token, string $language_code = 'en', $device_type = 2)
    {
        
        $notification_title = $this->getTitle($notification_data['title'], $notification_data['item_type'], $language_code);
        $notification_count = $this->getUserNotficationCount($user_data['user_id'], $user_data['user_type']) + 1;

        $data = $this->getPayloadData($device_type, $notification_title, $notification_count, $notification_data);
        $data['registration_ids'] =   $fcm_token;
        
        $notification_data['title'] = $notification_title; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeader());
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $firebase_response = curl_exec($ch);
       

        if (isset($notification_data['id']) && $notification_data['id']) {
            $user_data['notification_id'] = $notification_data['id'];
        } else {
            $notification = Notification::create($notification_data);
            $user_data['notification_id'] = $notification->id;
        }

        $user_data['firebase_response'] = $firebase_response;
        $user_data['created_at'] = date('Y-m-d H:i:s');
        $user_data['updated_at'] = date('Y-m-d H:i:s');

        NotificationUser::insert($user_data);
        curl_close($ch);
        return $firebase_response;
    }
}
